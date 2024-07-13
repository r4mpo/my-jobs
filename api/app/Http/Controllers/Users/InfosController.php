<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\Infos\Create;
use App\Http\Requests\Users\Infos\Update;
use App\Models\Users\Info;

class InfosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        throw new \Exception('invalid route');
    }

    /**
     * @OA\Post(
     *      path="/api/infos",
     *      operationId="infos_store",
     *      tags={"Infos"},
     *      summary="Create a new info",
     *      description="Create a new info with the provided data.",
     *      security={{"bearerAuth": {}}},
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="code",
     *                  type="string",
     *                  description="Code of the info.",
     *                  example="1"
     *              ),
     *              @OA\Property(
     *                  property="info",
     *                  type="string",
     *                  description="Information content.",
     *                  example="14920388."
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Info created successfully.",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="data",
     *                  type="object",
     *                  @OA\Property(
     *                      property="id",
     *                      type="integer",
     *                      description="ID of the created info.",
     *                      example="8"
     *                  ),
     *                  @OA\Property(
     *                      property="code",
     *                      type="string",
     *                      description="code of the created info.",
     *                      example="1"
     *                  ),
     *                  @OA\Property(
     *                      property="info",
     *                      type="string",
     *                      description="info of the created info.",
     *                      example="14920388"
     *                  ),
     *                  @OA\Property(
     *                      property="user_id",
     *                      type="integer",
     *                      description="user_id of the created info.",
     *                      example="1"
     *                  ),
     *                  @OA\Property(
     *                      property="updated_at",
     *                      type="string",
     *                      description="updated_at of the created info.",
     *                      example="2024-06-24T22:24:25.000000Z"
     *                  ),
     *                  @OA\Property(
     *                      property="created_at",
     *                      type="string",
     *                      description="created_at of the created info.",
     *                      example="2024-06-24T22:24:25.000000Z"
     *                  )
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="There was a problem registering the info.",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="message",
     *                  type="string",
     *                  example="There was a problem registering the info."
     *              ),
     *              @OA\Property(
     *                  property="success",
     *                  type="boolean",
     *                  example=false
     *              ),
     *              @OA\Property(
     *                  property="error",
     *                  type="string",
     *                  example="Internal server error."
     *              ),
     *              @OA\Property(
     *                  property="code",
     *                  type="integer",
     *                  example=500
     *              )
     *          )
     *      )
     * )
     */
    public function store(Create $request)
    {
        $data = $request->only('code', 'info', 'user_id');

        try {
            $info = Info::create($data);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'There was a problem registering the info.',
                'success' => false,
                'error' => $th->getMessage(),
                'code' => $th->getCode()
            ], 500);
        }

        return response()->json(['data' => $info]);
    }

    public function show(string $id)
    {
        throw new \Exception('invalid route');
    }

    /**
     * @OA\Put(
     *      path="/api/infos/{id}",
     *      operationId="infos_update",
     *      tags={"Infos"},
     *      summary="Update info",
     *      description="Update info with the provided data.",
     *      security={{"bearerAuth": {}}},
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          description="ID of the info to update",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="code",
     *                  type="string",
     *                  description="Code of the info.",
     *                  example="3"
     *              ),
     *              @OA\Property(
     *                  property="info",
     *                  type="string",
     *                  description="Information content.",
     *                  example="Updated information content."
     *              ),
     *              @OA\Property(
     *                  property="user_id",
     *                  type="integer",
     *                  description="ID of the user updating the info.",
     *                  example="1"
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Info updated successfully.",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="data",
     *                  type="object",
     *                  @OA\Property(
     *                      property="id",
     *                      type="integer",
     *                      description="ID of the updated info.",
     *                      example="8"
     *                  ),
     *                  @OA\Property(
     *                      property="code",
     *                      type="string",
     *                      description="Code of the updated info.",
     *                      example="3"
     *                  ),
     *                  @OA\Property(
     *                      property="info",
     *                      type="string",
     *                      description="Information content of the updated info.",
     *                      example="Updated information content."
     *                  ),
     *                  @OA\Property(
     *                      property="user_id",
     *                      type="integer",
     *                      description="ID of the user who updated the info.",
     *                      example="1"
     *                  ),
     *                  @OA\Property(
     *                      property="updated_at",
     *                      type="string",
     *                      format="date-time",
     *                      description="Date and time of the last update.",
     *                      example="2024-06-24T22:30:45.000000Z"
     *                  ),
     *                  @OA\Property(
     *                      property="created_at",
     *                      type="string",
     *                      format="date-time",
     *                      description="Date and time of creation.",
     *                      example="2024-06-24T22:24:25.000000Z"
     *                  )
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Invalid info: unauthorized",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="message",
     *                  type="string",
     *                  example="Invalid info: unauthorized"
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="There was a problem updating the info.",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="message",
     *                  type="string",
     *                  example="There was a problem updating the info."
     *              ),
     *              @OA\Property(
     *                  property="success",
     *                  type="boolean",
     *                  example=false
     *              ),
     *              @OA\Property(
     *                  property="error",
     *                  type="string",
     *                  example="Internal server error."
     *              ),
     *              @OA\Property(
     *                  property="code",
     *                  type="integer",
     *                  example=500
     *              )
     *          )
     *      )
     * )
     */
    public function update(Update $request, string $id)
    {
        $data = $request->only('code', 'info', 'user_id');
        $info = Info::findOrFail($id);

        if ($data['user_id'] != $info->user_id) {
            throw new \Exception('invalid info: unauthorized');
        }

        try {
            $info->update($data);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'There was a problem update the info.',
                'success' => false,
                'error' => $th->getMessage(),
                'code' => $th->getCode()
            ], 500);
        }

        return response()->json(['data' => $info]);
    }

    public function destroy(string $id)
    {
        throw new \Exception('invalid route');
    }
}