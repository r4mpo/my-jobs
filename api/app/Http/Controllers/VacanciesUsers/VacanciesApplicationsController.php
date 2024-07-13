<?php

namespace App\Http\Controllers\VacanciesUsers;

use App\Http\Controllers\Controller;
use App\Models\Vacancies\Vacancy;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VacanciesApplicationsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * @OA\Get(
     *      path="/api/vacancies_user/my_applications_vacancies",
     *      operationId="myApplications",
     *      tags={"VacanciesUsers"},
     *      summary="Retrieve a list of vacancies published by the authenticated user",
     *      description="Returns a list of vacancies published by the authenticated user.",
     *      security={{"bearerAuth": {}}},
     *      @OA\Response(
     *          response=200,
     *          description="A list of vacancies published by the authenticated user.",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="data",
     *                  type="array",
     *                  @OA\Items(
     *                      @OA\Property(
     *                          property="id",
     *                          type="integer",
     *                          example="2",
     *                          description="ID Vacancy."
     *                      ),
     *                      @OA\Property(
     *                          property="created_at",
     *                          type="string",
     *                          example="2024-05-26T22:40:21.000000Z",
     *                          description="Creation timestamp of vacancy."
     *                      ),
     *                      @OA\Property(
     *                          property="updated_at",
     *                          type="string",
     *                          example="2024-05-26T22:40:21.000000Z",
     *                          description="Update timestamp of vacancy."
     *                      ),
     *                      @OA\Property(
     *                          property="short_description",
     *                          type="string",
     *                          example="test update",
     *                          description="Short description of vacancy."
     *                      ),
     *                      @OA\Property(
     *                          property="long_description",
     *                          type="string",
     *                          example="Fazendo teste de tal tal tal.",
     *                          description="Long description of vacancy."
     *                      ),
     *                      @OA\Property(
     *                          property="wage",
     *                          type="string",
     *                          example="R$ 7,77",
     *                          description="Wage of vacancy."
     *                      ),
     *                      @OA\Property(
     *                          property="zip_code",
     *                          type="string",
     *                          example="12345678",
     *                          description="Zip code (CEP) of vacancy."
     *                      ),
     *                      @OA\Property(
     *                          property="user",
     *                          type="object",
     *                          @OA\Property(
     *                              property="id",
     *                              type="integer",
     *                              description="ID of the user.",
     *                              example="1"
     *                          ),
     *                          @OA\Property(
     *                              property="name",
     *                              type="string",
     *                              description="Name of the user.",
     *                              example="Erick"
     *                          ),
     *                          @OA\Property(
     *                              property="email",
     *                              type="string",
     *                              description="Email of the user.",
     *                              example="erick@jobs.com"
     *                          ),
     *                          @OA\Property(
     *                              property="email_verified_at",
     *                              type="string",
     *                              description="Email verified at of the user.",
     *                              example="erick_verify@jobs.com"
     *                          ),
     *                          @OA\Property(
     *                              property="created_at",
     *                              type="string",
     *                              description="created at of the user.",
     *                              example="2024-06-04T01:42:02.000000Z"
     *                          ),
     *                          @OA\Property(
     *                              property="updated_at",
     *                              type="string",
     *                              description="updated at of the user.",
     *                              example="2024-06-04T01:42:02.000000Z"
     *                          ),
     *                      )
     *                  )
     *              )
     *          )
     *      )
     * )
     */
    public function myApplications(): JsonResponse
    {
        $user = Auth::user();
        $vacancies = $user->vacancies;

        $vacancies = $vacancies->map(function ($vacancy) {
            return [
                'id' => $vacancy->id,
                'short_description' => $vacancy->short_description,
                'long_description' => $vacancy->long_description,
                'wage' => $this->format("money", $vacancy->wage),
                'zip_code' => $vacancy->zip_code,
                'user' => $vacancy->user,
            ];
        });

        return response()->json([
            'data' => $vacancies
        ]);
    }

    /**
     * @OA\Get(
     *      path="/api/vacancies_user/to_apply_or_unapply/{vacancy_id}",
     *      operationId="toApplyOrUnapply",
     *      tags={"VacanciesUsers"},
     *      summary="Apply or unapply to a vacancy",
     *      description="Apply or unapply to a specific vacancy.",
     *      security={{"bearerAuth": {}}},
     *      @OA\Parameter(
     *          name="vacancy_id",
     *          in="path",
     *          description="ID of the vacancy.",
     *          required=true,
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="action",
     *          in="query",
     *          description="Action to perform (attach or detach).",
     *          required=true,
     *          @OA\Schema(
     *              type="string",
     *              enum={"attach", "detach"}
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Success message confirming the action.",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="message",
     *                  type="string",
     *                  example="User John applied to Vacancy XYZ"
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Invalid data or action provided.",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="error",
     *                  type="string",
     *                  example="Invalid data or action provided."
     *              )
     *          )
     *      )
     * )
     */
    public function toApplyOrUnapply($vacancy_id): JsonResponse
    {
        $user = Auth::user();
        $vacancy = Vacancy::findOrFail($vacancy_id);

        if (empty($user) || empty($vacancy)) {
            throw new \Exception('invalid data');
        }

        if ($action = request('action')) {
            $action = empty($action) ? '' : strtolower($action);
        }

        if ($action != 'attach' && $action != 'detach') {
            throw new \Exception('invalid action');
        }

        $user->vacancies()->$action($vacancy_id);

        return response()->json(['user ' . $user->name . ' ' . ($action == 'attach' ? 'applied' : 'disappointed') . ' to ' . $vacancy->short_description]);
    }

    /**
     * @OA\Get(
     *      path="/api/vacancies_user/vacancy_applications/{vacancy_id}",
     *      operationId="vacancyApplications",
     *      tags={"VacanciesUsers"},
     *      summary="Retrieve a list of users who applied to a specific vacancy",
     *      description="Returns a list of users who applied to a specific vacancy.",
     *      security={{"bearerAuth": {}}},
     *      @OA\Parameter(
     *          name="vacancy_id",
     *          in="path",
     *          required=true,
     *          description="ID of the vacancy",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="A list of users who applied to the specified vacancy.",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="data",
     *                  type="array",
     *                  @OA\Items(
     *                      @OA\Property(
     *                          property="id",
     *                          type="integer",
     *                          example="1",
     *                          description="ID of the user."
     *                      ),
     *                      @OA\Property(
     *                          property="name",
     *                          type="string",
     *                          example="John Doe",
     *                          description="Name of the user."
     *                      ),
     *                      @OA\Property(
     *                          property="email",
     *                          type="string",
     *                          example="john@exasmple.com",
     *                          description="Email of the user."
     *                      ),
     *                      @OA\Property(
     *                          property="created_at",
     *                          type="string",
     *                          example="2024-06-09T12:00:00.000000Z",
     *                          description="Creation timestamp of the user application."
     *                      ),
     *                      @OA\Property(
     *                          property="updated_at",
     *                          type="string",
     *                          example="2024-06-09T12:00:00.000000Z",
     *                          description="Update timestamp of the user application."
     *                      )
     *                  )
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Vacancy not found"
     *      )
     * )
     */
    public function vacancyApplications($vacancy_id): JsonResponse
    {
        $vacancy = Vacancy::findOrFail($vacancy_id);
        $users = $vacancy->users;

        return response()->json([
            'data' => $users
        ]);
    }
}
