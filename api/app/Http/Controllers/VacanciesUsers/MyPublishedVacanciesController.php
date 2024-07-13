<?php

namespace App\Http\Controllers\VacanciesUsers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class MyPublishedVacanciesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * @OA\Get(
     *      path="/api/vacancies_user/my_published_vacancies",
     *      operationId="myPublishedVacancies",
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
    public function myPublishedVacancies(): JsonResponse
    {
        $user = Auth::user();
        $vacancies = $user->getVacanciesWithMyUserId;

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
}
