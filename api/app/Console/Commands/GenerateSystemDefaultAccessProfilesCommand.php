<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class GenerateSystemDefaultAccessProfilesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate-system-default-access-profiles';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'generate system default access profiles';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $roles = Role::where('name', 'default')->orWhere('name', 'administrator')->get();

        if (count($roles) > 0) {
            echo json_encode([
                'message' => 'apparently one of the default profiles already exists, in case of error contact the database administrator',
                'roles' => $roles
            ]);
            exit;
        }

        $all_permissions = Permission::pluck('name')->toArray();

        if (count($all_permissions) === 0) {
            echo json_encode([
                'message' => 'permissions invalid'
            ]);
            exit;
        }

        $permissions_default = [];

        // Initially, we removed the permissions related to access profiles, 
        // as a regular user should not have permission to edit these
        foreach ($all_permissions as $permission) {
            if (strpos($permission, 'profiles') === false) {
                $permissions_default[] = $permission;
            }
        }


        $administrator = Role::create(['name' => 'administrator', 'guard_name' => 'api']);
        $default = Role::create(['name' => 'default', 'guard_name' => 'api']);

        $administrator->givePermissionTo($all_permissions);
        $default->givePermissionTo($permissions_default);

        echo json_encode([
            'message' => 'success',
            'roles' => [$administrator, $default]
        ]);
        exit;
    }
}
