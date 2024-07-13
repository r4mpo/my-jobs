<?php

namespace App\Http\Controllers\Users;

use  App\Http\Requests\Users\Create as Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Users\Info;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'create']]);
    }


    /**
     * Authenticate user.
     *
     * @OA\Post(
     *      path="/api/auth/login",
     *      operationId="login",
     *      tags={"Auth"},
     *      summary="Authenticate user.",
     *      description="Authenticate user.",
     *      @OA\RequestBody(
     *          required=true,
     *          description="login Credentials",
     *          @OA\JsonContent(
     *              required={"email", "password"},
     *              @OA\Property(property="email", type="string", example="giovana@email.com"),
     *              @OA\Property(property="password", type="string", example="giovana3#_!.G"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Login successfully.",
     *          @OA\JsonContent(
     *              @OA\Property(property="access_token", type="string", example="token"),
     *              @OA\Property(property="token_type", type="string", example="bearer"),
     *              @OA\Property(property="expires_in", type="integer", example=3600)
     *          )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Invalid Credentials.",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Not authorized")
     *          )
     *      )
     * )
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(): JsonResponse
    {
        $credentials = request(['email', 'password']);

        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Not authorized.'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * @OA\Post(
     *      path="/api/auth/register",
     *      operationId="user_store",
     *      tags={"Users"},
     *      summary="Creates a new user.",
     *      description="Creates a new user.",
     *      @OA\RequestBody(
     *          required=true,
     *          description="Informações do usuário",
     *          @OA\JsonContent(
     *              required={"name", "email", "password"},
     *              @OA\Property(property="name", type="string", example="Giovana"),
     *              @OA\Property(property="email", type="string", example="giovana@email.com"),
     *              @OA\Property(property="password", type="string", example="giovana3#_!.G"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="User registered successfully!",
     *          @OA\JsonContent(
     *              @OA\Property(property="user", type="object", example={}),
     *              @OA\Property(property="data", type="object", example={}),
     *              @OA\Property(property="message", type="string", example="User registered successfully.!"),
     *              @OA\Property(property="success", type="boolean", example=true)
     *          )
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="There was a problem registering the user.",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="There was a problem registering the user."),
     *              @OA\Property(property="success", type="boolean", example=false),
     *              @OA\Property(property="error", type="string", example="Error details"),
     *              @OA\Property(property="code", type="integer", example=500)
     *          )
     *      )
     * )
     */
    public function create(Request $request): JsonResponse
    {
        try {
            $data = $request->only(['name', 'email', 'password']);
            $user = User::create($data);

            $user->assignRole('default');

            return response()->json([
                'user' => $user,
                'data' => $data,
                'message' => 'User registered successfully.',
                'success' => true
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'There was a problem registering the user.',
                'success' => false,
                'error' => $th->getMessage(),
                'code' => $th->getCode()
            ], 500);
        }
    }

    /**
     * Information about the authenticated user.
     *
     * @OA\Post(
     *      path="/api/auth/me",
     *      operationId="me",
     *      tags={"Auth"},
     *      summary="Information about the authenticated user.",
     *      description="Information about the authenticated user.",
     *      security={{"bearerAuth": {}}},
     *      @OA\Response(
     *          response=200,
     *          description="User information successfully retrieved.",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="integer", example="444"),
     *              @OA\Property(property="name", type="string", example="Giovana"),
     *              @OA\Property(property="email", type="string", example="giovana@gmail.com"),
     *              @OA\Property(property="email_verified_at", type="string", example="null"),
     *              @OA\Property(property="created_at", type="string", example="2024-05-01T18:31:41.000000Z"),
     *              @OA\Property(property="updated_at", type="string", example="2024-05-01T18:31:41.000000Z")
     *          )
     *      )
     * )
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me(): JsonResponse
    {
        return response()->json(auth()->user());
    }

    /**
     * Logs out the user and invalidates the JWT token.
     *
     * @OA\Post(
     *      path="/api/auth/logout",
     *      operationId="logout",
     *      tags={"Auth"},
     *      summary="Logs out the user and invalidates the JWT token.",
     *      description="Logs out the user and invalidates the JWT token.",
     *      security={{"bearerAuth": {}}},
     *      @OA\Response(
     *          response=200,
     *          description="User logged out successfully.",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Logout completed successfully.")
     *          )
     *      )
     * )
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(): JsonResponse
    {
        auth()->logout();

        return response()->json(['message' => 'Logout completed successfully.']);
    }

    /**
     * Restore user token.
     *
     * @OA\Post(
     *      path="/api/auth/refresh",
     *      operationId="refresh",
     *      tags={"Auth"},
     *      summary="Restore user token.",
     *      description="Restore user token.",
     *      security={{"bearerAuth": {}}},
     *      @OA\Response(
     *          response=200,
     *          description="User information successfully retrieved.",
     *          @OA\JsonContent(
     *              @OA\Property(property="access_token", type="string", example="token"),
     *              @OA\Property(property="token_type", type="string", example="bearer"),
     *              @OA\Property(property="expires_in", type="integer", example=3600)
     *          )
     *      )
     * )
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh(): JsonResponse
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Returns the response with the JWT token.
     *
     * @param $token
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token): JsonResponse
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

    /**
     * @OA\Get(
     *      path="/api/auth/infos/{user_id}",
     *      operationId="getInfos",
     *      tags={"Users"},
     *      summary="Get user's infos",
     *      description="Retrieve all infos belonging to the specified user.",
     *      security={{"bearerAuth": {}}},
     *      @OA\Parameter(
     *          name="user_id",
     *          in="path",
     *          required=false,
     *          description="ID of the user whose infos are to be retrieved. If not provided, retrieves infos for the authenticated user.",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="List of infos retrieved successfully.",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="data",
     *                  type="array",
     *                  @OA\Items(
     *                      type="object",
     *                      @OA\Property(
     *                          property="id",
     *                          type="integer",
     *                          description="ID of the info.",
     *                          example="1"
     *                      ),
     *                      @OA\Property(
     *                          property="info",
     *                          type="string",
     *                          description="Formatted information content.",
     *                          example="Formatted info content"
     *                      ),
     *                      @OA\Property(
     *                          property="type",
     *                          type="string",
     *                          description="Type of the info.",
     *                          example="phone"
     *                      )
     *                  )
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthorized",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="message",
     *                  type="string",
     *                  example="Unauthenticated."
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="No infos found for the specified user.",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="message",
     *                  type="string",
     *                  example="No infos found."
     *              )
     *          )
     *      )
     * )
     */
    public function getInfos($user_id = null): JsonResponse
    {
        $user_id = is_null($user_id) ? auth()->id() : $user_id;
        $infos = Info::where('user_id', $user_id)->get();

        $infos = $infos->map(function ($info) {

            $id   = $info->id;
            $data = $info->info;
            $type = $info->getTypeInfo();

            if (in_array($type, ['phone', 'zip_code', 'money', 'cpf', 'cnpj', 'rg'])) {
                $data = $this->format($type, $data);
            }

            return [
                'id' => $id,
                'info' => $data,
                'type' => $type
            ];
        });

        return response()->json(['data' => $infos]);
    }
}
