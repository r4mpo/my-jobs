<?php

namespace App\Http\Controllers\Profiles;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class ProfilesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * @OA\Get(
     *      path="/api/profiles",
     *      operationId="profiles_index",
     *      tags={"Profiles"},
     *      summary="Retrieve a list of profiles",
     *      description="Returns a list of all profiles.",
     *      security={{"bearerAuth": {}}},
     *      @OA\Response(
     *          response=200,
     *          description="A list of profiles",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="data",
     *                  type="array",
     *                  @OA\Items(
     *                      @OA\Property(
     *                          property="id",
     *                          type="integer",
     *                          example="1",
     *                          description="Profile ID"
     *                      ),
     *                      @OA\Property(
     *                          property="name",
     *                          type="string",
     *                          example="Moder",
     *                          description="Profile name"
     *                      ),
     *                      @OA\Property(
     *                          property="guard_name",
     *                          type="string",
     *                          example="api",
     *                          description="Guard name"
     *                      ),
     *                      @OA\Property(
     *                          property="created_at",
     *                          type="string",
     *                          format="date-time",
     *                          example="2024-07-02T23:12:14.000000Z",
     *                          description="Creation timestamp"
     *                      ),
     *                      @OA\Property(
     *                          property="updated_at",
     *                          type="string",
     *                          format="date-time",
     *                          example="2024-07-02T23:12:14.000000Z",
     *                          description="Update timestamp"
     *                      )
     *                  )
     *              )
     *          )
     *      )
     * )
     */
    public function index(): JsonResponse
    {
        $roles = Role::all();
        return response()->json(['data' => $roles]);
    }

    /**
     * @OA\Post(
     *      path="/api/profiles",
     *      operationId="profiles_store",
     *      tags={"Profiles"},
     *      summary="Create a new profile",
     *      description="Creates a new profile with specified name and permissions.",
     *      security={{"bearerAuth": {}}},
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"name", "permissions"},
     *              @OA\Property(
     *                  property="name",
     *                  type="string",
     *                  example="Editor",
     *                  description="Name of the new profile"
     *              ),
     *              @OA\Property(
     *                  property="permissions",
     *                  type="array",
     *                  @OA\Items(
     *                      type="string",
     *                      enum={
     *                          "api.vacancies.index",
     *                          "api.vacancies.store",
     *                          "api.vacancies.show",
     *                          "api.vacancies.update",
     *                          "api.vacancies.destroy",
     *                          "api.infos.index",
     *                          "api.infos.store",
     *                          "api.infos.show",
     *                          "api.infos.update",
     *                          "api.infos.destroy",
     *                          "api.auth.login",
     *                          "api.auth.create",
     *                          "api.auth.logout",
     *                          "api.auth.refresh",
     *                          "api.auth.me",
     *                          "api.auth.infos",
     *                          "api.vacancies_user.my_published_vacancies",
     *                          "api.vacancies_user.my_applications_vacancies",
     *                          "api.vacancies_user.to_apply_or_unapply",
     *                          "api.vacancies_user.vacancy_applications"
     *                      },
     *                      description="Permission name"
     *                  )
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="The created profile",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="data",
     *                  type="array",
     *                  @OA\Items(
     *                      @OA\Property(
     *                          property="id",
     *                          type="integer",
     *                          example="1",
     *                          description="Profile ID"
     *                      ),
     *                      @OA\Property(
     *                          property="name",
     *                          type="string",
     *                          example="Moder",
     *                          description="Profile name"
     *                      ),
     *                      @OA\Property(
     *                          property="guard_name",
     *                          type="string",
     *                          example="api",
     *                          description="Guard name"
     *                      ),
     *                      @OA\Property(
     *                          property="created_at",
     *                          type="string",
     *                          format="date-time",
     *                          example="2024-07-02T23:12:14.000000Z",
     *                          description="Creation timestamp"
     *                      ),
     *                      @OA\Property(
     *                          property="updated_at",
     *                          type="string",
     *                          format="date-time",
     *                          example="2024-07-02T23:12:14.000000Z",
     *                          description="Update timestamp"
     *                      )
     *                  )
     *              )
     *          )
     *      )
     * )
     */

    public function store(Request $request): JsonResponse
    {
        if (strpos(strtolower($request->name), 'administrator') !== false || strpos(strtolower($request->name), 'default') !== false) {
            throw new \Exception('There was an error. It is not possible to manipulate information related to administrator or default roles, nor assign new profiles named as administrators or default users in the system');
        }

        $data = $request->only(['name']);
        $permissions = $request->permissions;

        try {
            $role = Role::create($data);
            $role->givePermissionTo($permissions); // permissions
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'There was a problem registering the profile.',
                'success' => false,
                'error' => $e->getMessage(),
                'code' => $e->getCode()
            ], 500);
        }

        return response()->json(['data' => $role]);
    }

    public function show($id): JsonResponse
    {
        throw new \Exception('invalid route');
    }

    /**
     * @OA\Put(
     *      path="/api/profiles/{profile}",
     *      operationId="profiles_update",
     *      tags={"Profiles"},
     *      summary="Update a profile",
     *      description="Updates an existing profile by ID with new name and permissions.",
     *      security={{"bearerAuth": {}}},
     *      @OA\Parameter(
     *          name="profile",
     *          in="path",
     *          required=true,
     *          description="ID of the profile to update",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"name", "permissions"},
     *              @OA\Property(
     *                  property="name",
     *                  type="string",
     *                  example="Editor",
     *                  description="New name of the profile"
     *              ),
     *              @OA\Property(
     *                  property="permissions",
     *                  type="array",
     *                  @OA\Items(
     *                      type="string",
     *                      enum={
     *                          "api.vacancies.index",
     *                          "api.vacancies.store",
     *                          "api.vacancies.show",
     *                          "api.vacancies.update",
     *                          "api.vacancies.destroy",
     *                          "api.infos.index",
     *                          "api.infos.store",
     *                          "api.infos.show",
     *                          "api.infos.update",
     *                          "api.infos.destroy",
     *                          "api.auth.login",
     *                          "api.auth.create",
     *                          "api.auth.logout",
     *                          "api.auth.refresh",
     *                          "api.auth.me",
     *                          "api.auth.infos",
     *                          "api.vacancies_user.my_published_vacancies",
     *                          "api.vacancies_user.my_applications_vacancies",
     *                          "api.vacancies_user.to_apply_or_unapply",
     *                          "api.vacancies_user.vacancy_applications"
     *                      },
     *                      description="New permission name"
     *                  )
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="The updated profile",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="data",
     *                  type="array",
     *                  @OA\Items(
     *                      @OA\Property(
     *                          property="id",
     *                          type="integer",
     *                          example="1",
     *                          description="Profile ID"
     *                      ),
     *                      @OA\Property(
     *                          property="name",
     *                          type="string",
     *                          example="Moder",
     *                          description="Profile name"
     *                      ),
     *                      @OA\Property(
     *                          property="guard_name",
     *                          type="string",
     *                          example="api",
     *                          description="Guard name"
     *                      ),
     *                      @OA\Property(
     *                          property="created_at",
     *                          type="string",
     *                          format="date-time",
     *                          example="2024-07-02T23:12:14.000000Z",
     *                          description="Creation timestamp"
     *                      ),
     *                      @OA\Property(
     *                          property="updated_at",
     *                          type="string",
     *                          format="date-time",
     *                          example="2024-07-02T23:12:14.000000Z",
     *                          description="Update timestamp"
     *                      )
     *                  )
     *              )
     *          )
     *      )
     * )
     */
    public function update(Request $request, $id): JsonResponse
    {
        if (strpos(strtolower($request->name), 'administrator') !== false || strpos(strtolower($request->name), 'default') !== false) {
            throw new \Exception('There was an error. It is not possible to manipulate information related to administrator or default roles, nor assign new profiles named as administrators or default users in the system');
        }

        $role = Role::findOrFail($id);
        $data = $request->only(['name']);
        $permissions = $request->permissions;

        try {

            foreach ($role->permissions as $permission) {
                $role->revokePermissionTo($permission->name);
            }

            $role->update($data);
            $role->givePermissionTo($permissions);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'There was a problem update the profile.',
                'success' => false,
                'error' => $e->getMessage(),
                'code' => $e->getCode()
            ], 500);
        }

        return response()->json(['data' => $role]);
    }

    /**
     * @OA\Delete(
     *      path="/api/profiles/{profile}",
     *      operationId="profiles_destroy",
     *      tags={"Profiles"},
     *      summary="Delete a profile",
     *      description="Deletes an existing profile by ID.",
     *      security={{"bearerAuth": {}}},
     *      @OA\Parameter(
     *          name="profile",
     *          in="path",
     *          required=true,
     *          description="ID of the profile to delete",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Profile successfully deleted"
     *      )
     * )
     */
    public function destroy($id): JsonResponse
    {
        $role = Role::findOrFail($id);

        if (strpos(strtolower($role->name), 'administrator') !== false || strpos(strtolower($role->name), 'default') !== false) {
            throw new \Exception('There was an error. It is not possible to manipulate information related to administrator or default roles, nor assign new profiles named as administrators or default users in the system');
        }

        try {
            // Deleting
            $role->delete();
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'There was a problem destroy the profile.',
                'success' => false,
                'error' => $e->getMessage(),
                'code' => $e->getCode()
            ], 500);
        }

        return response()->json(['profile successfully deleted']);
    }

    /**
     * @OA\Get(
     *      path="/api/profiles/assign_role_for_user/{user_id}",
     *      operationId="assign_role_for_user",
     *      tags={"Profiles"},
     *      summary="Assign one role for user",
     *      description="Assign one role for user.",
     *      security={{"bearerAuth": {}}},
     *      @OA\Parameter(
     *          name="user_id",
     *          in="path",
     *          required=true,
     *          description="ID of the user",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="role_id",
     *          in="query",
     *          description="Role to assign.",
     *          required=true,
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Profile assign for user successfully"
     *      )
     * )
     */
    public function assignRoleForUser($user_id): JsonResponse
    {
        try {
            $user = User::findOrFail($user_id);

            $new_role_id = request('role_id');

            $new_role = Role::where('id', $new_role_id)->firstOrFail();
            $old_role = $user->getRoleNames()->first();

            if ($old_role) {
                $user->removeRole($old_role);
            }

    
            $user->assignRole($new_role->name);

            return response()->json(['Profile assign for user successfully']);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'There was a problem assign profile.',
                'success' => false,
                'error' => $e->getMessage(),
                'code' => $e->getCode()
            ], 500);
        }
    }
}
