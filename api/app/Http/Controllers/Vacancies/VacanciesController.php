<?php

namespace App\Http\Controllers\Vacancies;

use App\Http\Controllers\Controller;
use App\Models\Vacancies\Vacancy;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Vacancies\Create as CreateRequest;
use App\Http\Requests\Vacancies\Update as UpdateRequest;
use App\Services\AddressService as Address;
use Illuminate\Http\JsonResponse;

class VacanciesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * @OA\Get(
     *      path="/api/vacancies",
     *      operationId="vacancies_index",
     *      tags={"Vacancies"},
     *      summary="Retrieve a list of vacancies",
     *      description="Returns a paginated list of vacancies optionally filtered by parameters.",
     *      security={{"bearerAuth": {}}},
     *      @OA\Parameter(
     *          name="zip_code",
     *          in="query",
     *          description="Filter vacancies by zip code.",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="wage",
     *          in="query",
     *          description="Filter vacancies by wage.",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="short_description",
     *          in="query",
     *          description="Filter vacancies by short description.",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="long_description",
     *          in="query",
     *          description="Filter vacancies by long description.",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="amount_page",
     *          in="query",
     *          description="Number of vacancies per page.",
     *          @OA\Schema(
     *              type="integer",
     *              default=10
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="A paginated list of vacancies.",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="data",
     *                  type="array",
     *                  @OA\Items(
     *                      @OA\Property(
     *                          property="id",
     *                          type="int",
     *                          description="ID Vacancy.",
     *                          example="1"
     *                      ),
     *                      @OA\Property(
     *                          property="short_description",
     *                          type="string",
     *                          description="Short description of vacancy",
     *                          example="Test..."
     *                      ),
     *                      @OA\Property(
     *                          property="long_description",
     *                          type="string",
     *                          description="Long description of vacancy",
     *                          example="Test... (long)"
     *                      ),
     *                      @OA\Property(
     *                          property="wage",
     *                          type="string",
     *                          description="Wage of vacancy",
     *                          example="R$ 12409,14"
     *                      ),
     *                      @OA\Property(
     *                          property="zip_code",
     *                          type="string",
     *                          description="Zip code (CEP) of vacancy",
     *                          example="14148-300"
     *                      ),
     *                      @OA\Property(
     *                          property="user",
     *                          type="string",
     *                          description="User registered of vacancy",
     *                          example="Erick Rampo"
     *                      )
     *                  )
     *              ),
     *              @OA\Property(
     *                  property="pages",
     *                  type="object",
     *                  @OA\Property(
     *                      property="amount",
     *                      type="string",
     *                      description="Amount pages."
     *                  ),
     *                  @OA\Property(
     *                      property="current",
     *                      type="string",
     *                      description="Current page number."
     *                  )
     *              )
     *          )
     *      )
     * )
     */
    public function index(): JsonResponse // query param optional: ?page=X (x = number page)
    {
        try {
            $params = request();

            $zip_code = $params['zip_code'] ? preg_replace('/\D/', '', $params['zip_code']) : '';
            $wage = $params['wage'] ? preg_replace('/\D/', '', $params['wage']) : '';

            $short_description = $params['short_description'] ?? '';
            $long_description = $params['long_description'] ?? '';

            $amount_page = $params['amount_page'] ?? 10;

            $vacancies = DB::table('Vacancies')
                ->join('users', 'Vacancies.user_id', '=', 'users.id')
                ->select('Vacancies.*', 'users.name as user')
                ->whereNull('deleted_at');

            if (!empty($zip_code)) {
                $vacancies = $vacancies->where('zip_code', '=', $zip_code);
            }

            if (!empty($wage)) {
                $vacancies = $vacancies->where('wage', '=', $wage);
            }

            if (!empty($short_description)) {
                $vacancies = $vacancies->where('short_description', 'like', '%' . $short_description . '%');
            }

            if (!empty($long_description)) {
                $vacancies = $vacancies->where('long_description', 'like', '%' . $long_description . '%');
            }

            $vacancies = $vacancies->orderBy('created_at', 'desc')->paginate($amount_page);

            $params_url = [
                'current' => $vacancies->currentPage(),
                'amount' => $vacancies->lastPage()
            ];

            $vacancies = $vacancies->map(function ($vacancy) {
                return [
                    'id' => $vacancy->id,
                    'short_description' => $vacancy->short_description,
                    'long_description' => $vacancy->long_description,
                    'wage' => $this->format("money", $vacancy->wage),
                    'zip_code' => $this->format("zip_code", $vacancy->zip_code),
                    'user' => $vacancy->user,
                ];
            });

            return response()->json([
                'data' => $vacancies,
                'pages' => $params_url,
            ]);
        } catch (\Exception $e) {
            return response()->json(['code' => $e->getCode(), 'message' => $e->getMessage()]);
        }
    }

    /**
     * @OA\Post(
     *      path="/api/vacancies",
     *      operationId="vacancies_store",
     *      tags={"Vacancies"},
     *      summary="Create a new vacancy",
     *      description="Create a new vacancy with the provided data.",
     *      security={{"bearerAuth": {}}},
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="short_description",
     *                  type="string",
     *                  description="Short description of the vacancy (between 5 and 60 characters).",
     *                  example="Test short description"
     *              ),
     *              @OA\Property(
     *                  property="long_description",
     *                  type="string",
     *                  description="Long description of the vacancy (between 10 and 250 characters).",
     *                  example="Test long description"
     *              ),
     *              @OA\Property(
     *                  property="wage",
     *                  type="integer",
     *                  description="Wage of the vacancy (in cents).",
     *                  example="1240914"
     *              ),
     *              @OA\Property(
     *                  property="zip_code",
     *                  type="string",
     *                  description="Zip code (CEP) of the vacancy.",
     *                  example="14148-300"
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Vacancy created successfully.",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="data",
     *                  type="object",
     *                  @OA\Property(
     *                      property="id",
     *                      type="integer",
     *                      description="ID of the created vacancy.",
     *                      example="8"
     *                  ),
     *                  @OA\Property(
     *                      property="short_description",
     *                      type="string",
     *                      description="Short description of the vacancy.",
     *                      example="Teste"
     *                  ),
     *                  @OA\Property(
     *                      property="long_description",
     *                      type="string",
     *                      description="Long description of the vacancy.",
     *                      example="Teste de uma descrição longa"
     *                  ),
     *                  @OA\Property(
     *                      property="wage",
     *                      type="string",
     *                      description="Wage of the vacancy.",
     *                      example="1240914"
     *                  ),
     *                  @OA\Property(
     *                      property="zip_code",
     *                      type="string",
     *                      description="Zip code (CEP) of the vacancy.",
     *                      example="14315250"
     *                  ),
     *                  @OA\Property(
     *                      property="user_id",
     *                      type="integer",
     *                      description="ID of the user creating the vacancy.",
     *                      example="5"
     *                  ),
     *                  @OA\Property(
     *                      property="updated_at",
     *                      type="string",
     *                      format="date-time",
     *                      description="Date and time of the last update.",
     *                      example="2024-05-17T00:04:49.000000Z"
     *                  ),
     *                  @OA\Property(
     *                      property="created_at",
     *                      type="string",
     *                      format="date-time",
     *                      description="Date and time of creation.",
     *                      example="2024-05-17T00:04:49.000000Z"
     *                  )
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateRequest $request): JsonResponse
    {
        $data = $request->only('short_description', 'long_description', 'wage', 'zip_code', 'user_id');

        try {
            $this->registerAddressVacancy($data['zip_code']);
            $vacancy = Vacancy::create($data);
        } catch (\Exception $e) {
            return response()->json(['code' => $e->getCode(), 'message' => $e->getMessage()]);
        }

        return response()->json(['data' => $vacancy]);
    }

    /**
     * @OA\Get(
     *      path="/api/vacancies/{id}",
     *      operationId="vacancies_show",
     *      tags={"Vacancies"},
     *      summary="Retrieve a single vacancy",
     *      description="Retrieve details of a single vacancy by its ID.",
     *      security={{"bearerAuth": {}}},
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="ID of the vacancy to retrieve",
     *          required=true,
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Vacancy details retrieved successfully.",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="data",
     *                  type="object",
     *                  @OA\Property(
     *                      property="id",
     *                      type="integer",
     *                      description="ID of the vacancy.",
     *                      example="1"
     *                  ),
     *                  @OA\Property(
     *                      property="short_description",
     *                      type="string",
     *                      description="Short description of the vacancy.",
     *                      example="Test"
     *                  ),
     *                  @OA\Property(
     *                      property="long_description",
     *                      type="string",
     *                      description="Long description of the vacancy.",
     *                      example="Test long description"
     *                  ),
     *                  @OA\Property(
     *                      property="wage",
     *                      type="string",
     *                      description="Wage of the vacancy.",
     *                      example="R$ 12409,14"
     *                  ),
     *                  @OA\Property(
     *                      property="zip_code",
     *                      type="string",
     *                      description="Zip code (CEP) of the vacancy.",
     *                      example="14148-300"
     *                  ),
     *                  @OA\Property(
     *                      property="user",
     *                      type="object",
     *                      @OA\Property(
     *                          property="id",
     *                          type="integer",
     *                          description="ID of the user.",
     *                          example="1"
     *                      ),
     *                      @OA\Property(
     *                          property="name",
     *                          type="string",
     *                          description="Name of the user.",
     *                          example="Erick"
     *                      ),
     *                      @OA\Property(
     *                          property="email",
     *                          type="string",
     *                          description="Email of the user.",
     *                          example="erick@jobs.com"
     *                      ),
     *                      @OA\Property(
     *                          property="email_verified_at",
     *                          type="string",
     *                          description="Email verified at of the user.",
     *                          example="erick_verify@jobs.com"
     *                      ),
     *                      @OA\Property(
     *                          property="created_at",
     *                          type="string",
     *                          description="created at of the user.",
     *                          example="2024-06-04T01:42:02.000000Z"
     *                      ),
     *                      @OA\Property(
     *                          property="updated_at",
     *                          type="string",
     *                          description="updated at of the user.",
     *                          example="2024-06-04T01:42:02.000000Z"
     *                      ),
     *                  ),
     *                  @OA\Property(
     *                      property="zip",
     *                      type="object",
     *                      @OA\Property(
     *                          property="zip_code",
     *                          type="string",
     *                          description="code of the zip.",
     *                          example="14085-440"
     *                      ),
     *                      @OA\Property(
     *                          property="street",
     *                          type="string",
     *                          description="street of the zip.",
     *                          example="Captain Solomon Avenue"
     *                      ),
     *                      @OA\Property(
     *                          property="complement",
     *                          type="string",
     *                          description="Complement of the zip.",
     *                          example="Close to the market x"
     *                      ),
     *                      @OA\Property(
     *                          property="neighborhood",
     *                          type="string",
     *                          description="neighborhood of the zip.",
     *                          example="Elysian Fields"
     *                      ),
     *                      @OA\Property(
     *                          property="locality",
     *                          type="string",
     *                          description="city of the zip.",
     *                          example="Central City"
     *                      ),
     *                      @OA\Property(
     *                          property="uf",
     *                          type="string",
     *                          description="uf the zip.",
     *                          example="SP"
     *                      ),
     *                      @OA\Property(
     *                          property="ibge",
     *                          type="integer",
     *                          description="ibge code of the zip.",
     *                          example="3543402"
     *                      ),
     *                      @OA\Property(
     *                          property="gia",
     *                          type="integer",
     *                          description="gia code of the zip.",
     *                          example="5824"
     *                      ),
     *                      @OA\Property(
     *                          property="ddd",
     *                          type="integer",
     *                          description="ddd code of the zip.",
     *                          example="16"
     *                      ),
     *                      @OA\Property(
     *                          property="siafi",
     *                          type="integer",
     *                          description="siafi code of the zip.",
     *                          example="6969"
     *                      )
     *                  )
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Vacancy not found."
     *      )
     * )
     */
    public function show(string $id): JsonResponse
    {
        try {
            $vacancy = Vacancy::findOrFail($id);

            return response()->json(['data' => [
                'id' => $vacancy->id,
                'short_description' => $vacancy->short_description,
                'long_description' => $vacancy->long_description,
                'wage' => $this->format("money", $vacancy->wage),
                'zip' => $vacancy->zip(),
                'user' => $vacancy->user
            ]]);
        } catch (\Exception $e) {
            return response()->json(['code' => $e->getCode(), 'message' => $e->getMessage()]);
        }
    }

    /**
     * @OA\Put(
     *      path="/api/vacancies/{id}",
     *      operationId="vacancies_update",
     *      tags={"Vacancies"},
     *      summary="Update an existing vacancy",
     *      description="Update an existing vacancy with the provided data.",
     *      security={{"bearerAuth": {}}},
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="ID of the vacancy to be updated",
     *          required=true,
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="short_description",
     *                  type="string",
     *                  description="Short description of the vacancy (between 5 and 60 characters).",
     *                  example="Updated short description"
     *              ),
     *              @OA\Property(
     *                  property="long_description",
     *                  type="string",
     *                  description="Long description of the vacancy (between 10 and 250 characters).",
     *                  example="Updated long description"
     *              ),
     *              @OA\Property(
     *                  property="wage",
     *                  type="integer",
     *                  description="Wage of the vacancy (in cents).",
     *                  example=1500000
     *              ),
     *              @OA\Property(
     *                  property="zip_code",
     *                  type="string",
     *                  description="Zip code (CEP) of the vacancy.",
     *                  example="11020-123"
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Vacancy updated successfully.",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="data",
     *                  type="object",
     *                  @OA\Property(
     *                      property="id",
     *                      type="integer",
     *                      description="ID of the updated vacancy.",
     *                      example="8"
     *                  ),
     *                  @OA\Property(
     *                      property="short_description",
     *                      type="string",
     *                      description="Short description of the vacancy.",
     *                      example="Updated short description"
     *                  ),
     *                  @OA\Property(
     *                      property="long_description",
     *                      type="string",
     *                      description="Long description of the vacancy.",
     *                      example="Updated long description"
     *                  ),
     *                  @OA\Property(
     *                      property="wage",
     *                      type="string",
     *                      description="Wage of the vacancy.",
     *                      example="1500000"
     *                  ),
     *                  @OA\Property(
     *                      property="zip_code",
     *                      type="string",
     *                      description="Zip code (CEP) of the vacancy.",
     *                      example="11020-123"
     *                  ),
     *                  @OA\Property(
     *                      property="user_id",
     *                      type="integer",
     *                      description="ID of the user updating the vacancy.",
     *                      example="5"
     *                  ),
     *                  @OA\Property(
     *                      property="updated_at",
     *                      type="string",
     *                      format="date-time",
     *                      description="Date and time of the last update.",
     *                      example="2024-05-17T12:00:00.000000Z"
     *                  ),
     *                  @OA\Property(
     *                      property="created_at",
     *                      type="string",
     *                      format="date-time",
     *                      description="Date and time of creation.",
     *                      example="2024-05-17T00:00:00.000000Z"
     *                  )
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Unauthorized - The user is not authorized to update this vacancy."
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Vacancy not found."
     *      )
     * )
     */
    public function update(UpdateRequest $request, string $id): JsonResponse
    {
        $data = $request->only('short_description', 'long_description', 'wage', 'zip_code');

        try {
            $vacancy = Vacancy::findOrFail($id);

            $userId = auth()->user()->id;

            if ($vacancy->user_id != $userId) {
                throw new \Exception('not authorized.');
            }

            if (isset($data['zip_code']) && $vacancy->zip_code != $data['zip_code']) {
                $this->registerAddressVacancy($data['zip_code']);
            }

            $vacancy->update($data);
        } catch (\Exception $e) {
            return response()->json(['code' => $e->getCode(), 'message' => $e->getMessage()]);
        }

        return response()->json(['data' => $vacancy]);
    }

    /**
     * @OA\Delete(
     *      path="/api/vacancies/{id}",
     *      operationId="vacancies_destroy",
     *      tags={"Vacancies"},
     *      summary="Delete a vacancy",
     *      description="Delete a vacancy by its ID.",
     *      security={{"bearerAuth": {}}},
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="ID of the vacancy to delete",
     *          required=true,
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Vacancy deleted successfully.",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="message",
     *                  type="string",
     *                  description="Confirmation message.",
     *                  example="Vacancy successfully deleted."
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Unauthorized - The user is not authorized to delete this vacancy."
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Vacancy not found."
     *      )
     * )
     */
    public function destroy(string $id): JsonResponse
    {
        try {

            $vacancy = Vacancy::findOrFail($id);

            $userId = auth()->user()->id;

            if ($vacancy->user_id != $userId) {
                throw new \Exception('not authorized.');
            }

            $vacancy->delete();

            return response()->json(['vacancy successfully deleted']);
        } catch (\Exception $e) {
            return response()->json(['code' => $e->getCode(), 'message' => $e->getMessage()]);
        }
    }

    public function registerAddressVacancy($zip_code): array
    {
        $address = new Address;
        $data_address = $address->get("viacep.com.br/ws/" . $zip_code . "/json/");

        if (!isset($data['erro'])) {
            $address = $address->register($data_address);
        }

        try {
            return $address->toArray();
        } catch (\Exception $exception) {
            return ['error' => true];
        }
    }
}