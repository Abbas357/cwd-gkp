<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class SyncPermissionsCommand extends Command
{
    protected $signature = 'permissions:sync {--force : Force the operation without confirmation} {--permissions-only : Only sync permissions, not roles} {--no-user-roles : Don\'t assign roles to users based on designation}';
    protected $description = 'Sync all permissions and default roles to predefined defaults';

    public function handle()
    {
        if (!$this->option('force') && !$this->confirm('This will reset all permissions and remove any role/user assignments. Are you sure?', false)) {
            $this->info('Operation cancelled.');
            return Command::FAILURE;
        }

        try {
            $tableNames = config('permission.table_names');
            
            $this->info('Disabling foreign key checks...');
            DB::statement('SET FOREIGN_KEY_CHECKS=0');
            
            $this->info('Clearing permission tables...');
            DB::table($tableNames['role_has_permissions'])->truncate();
            DB::table($tableNames['model_has_permissions'])->truncate();
            DB::table($tableNames['permissions'])->truncate();
            
            if (!$this->option('permissions-only')) {
                $this->info('Clearing roles tables...');
                DB::table($tableNames['model_has_roles'])->truncate();
                DB::table($tableNames['roles'])->truncate();
            }
            
            $this->info('Re-enabling foreign key checks...');
            DB::statement('SET FOREIGN_KEY_CHECKS=1');
            
            $predefinedPermissions = $this->getPredefinedPermissions();
            $permissions = [];
            
            $this->info('Preparing permission data...');
            foreach ($predefinedPermissions as $permission) {
                $permissions[] = [
                    'name' => $permission,
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
            
            $this->info('Inserting ' . count($permissions) . ' permissions...');
            DB::table($tableNames['permissions'])->insert($permissions);
            
            // Create default roles if not permissions-only mode
            if (!$this->option('permissions-only')) {
                $this->info('Creating default roles with permissions...');
                $this->createDefaultRoles();
                
                // Assign roles to users based on designation
                if (!$this->option('no-user-roles')) {
                    $this->info('Assigning roles to users based on designation...');
                    $this->assignRolesToUsersByDesignation();
                }
            }
            
            $this->info('Clearing permission cache...');
            app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
            
            $this->info('All permissions' . (!$this->option('permissions-only') ? ' and roles' : '') . ' have been successfully reset to defaults.');
            return Command::SUCCESS;
                
        } catch (\Exception $e) {
            $this->error('Error resetting permissions: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }
    
    protected function createDefaultRoles()
    {
        $roles = [
            'Secretary' => $this->getSecretaryPermissions(),
            'Chief Engineer' => $this->getChiefEngineerPermissions(),
            'Superintending Engineer' => $this->getSuperintendingEngineerPermissions(),
            'Executive Engineer' => $this->getExecutiveEngineerPermissions(),
            'Director IT' => $this->getDirectorITPermissions(),
            'Assistant Director IT' => $this->getAssistantDirectorITPermissions(),
            'News Manager' => $this->getNewsManagerPermissions(),
            'Tender Manager' => $this->getTenderManagerPermissions(),
            'Admin' => $this->getAdminPermissions()
        ];

        foreach ($roles as $roleName => $permissions) {
            $role = Role::create(['name' => $roleName, 'guard_name' => 'web']);
            
            if (!empty($permissions)) {
                $this->info("Assigning permissions to {$roleName} role...");
                $role->givePermissionTo($permissions);
            }
        }
    }

    protected function assignRolesToUsersByDesignation()
    {
        $designationRoleMap = [
            'Secretary' => 'Secretary',
            'Chief Engineer' => 'Chief Engineer',
            'Superintending Engineer' => 'Superintending Engineer',
            'Executive Engineer' => 'Executive Engineer',
            'Director IT' => 'Director IT',
            'Assistant Director IT' => 'Assistant Director IT',
            'News Manager' => 'News Manager',
            'Tender Manager' => 'Tender Manager'
            // Add more mappings as needed
        ];

        $assignedCount = 0;
        
        foreach ($designationRoleMap as $designation => $roleName) {
            $users = User::whereHas('currentPosting.designation', function($query) use ($designation) {
                $query->where('name', $designation);
            })->get();
            
            $role = Role::where('name', $roleName)->first();
            
            if (!$role) {
                $this->warn("Role '{$roleName}' not found. Skipping assignment for {$designation} designation.");
                continue;
            }
            
            $count = $users->count();
            if ($count > 0) {
                foreach ($users as $user) {
                    $user->syncRoles($role);
                    $assignedCount++;
                }
                $this->info("Assigned '{$roleName}' role to {$count} user(s) with '{$designation}' designation.");
            } else {
                $this->info("No users found with '{$designation}' designation.");
            }
        }
        
        $this->info("Total: {$assignedCount} role assignments completed.");
    }

    protected function getSecretaryPermissions()
    {
        // Permissions specific to the Secretary role
        return [
            'view any event',
            'view event',
            'view any news',
            'view news',
            'view any project',
            'view project',
            'view any download',
            'view download',
            'view any gallery',
            'view gallery',
            // Add more permissions as needed
        ];
    }

    protected function getChiefEngineerPermissions()
    {
        // Permissions specific to the Chief Engineer role
        return [
            'view any project',
            'view project',
            'create project',
            'update field project',
            'upload file project',
            'view any development-project',
            'view development-project',
            'view any tender',
            'view tender',
            'view any damage',
            'view damage',
            'view main report damage',
            'view officer report damage',
            'view district-wise report damage',
            'view any machinery',
            'view machinery',
            'view reports machinery',
            'view any vehicle',
            'view vehicle',
            'view reports vehicle',
            'view any user',
            'view employee user',
            'view user',
            'view employee directory report user',
            'view office strength report user',
            'view posting history report user',
            'view retirement forecast report user',
            'view office staff report user',
        ];
    }

    protected function getSuperintendingEngineerPermissions()
    {
        // Permissions specific to the Superintending Engineer role
        return [
            'view any project',
            'view project',
            'update field project',
            'upload file project',
            'view any development-project',
            'view development-project',
            'view any tender',
            'view tender',
            'view any damage',
            'view damage',
            'view officer report damage',
            'view district-wise report damage',
            'view any machinery',
            'view machinery',
            'view reports machinery',
            'view any vehicle',
            'view vehicle',
            'view any user',
            'view employee user',
            'view user',
            'view employee directory report user',
            'view office staff report user',
        ];
    }

    protected function getExecutiveEngineerPermissions()
    {
        // Permissions specific to the Executive Engineer role
        return [
            'view any project',
            'view project',
            'update field project',
            'view any development-project',
            'view development-project',
            'view any tender',
            'view tender',
            'view any damage',
            'view damage',
            'create damage',
            'update field damage',
            'view any machinery',
            'view machinery',
            'view any vehicle',
            'view vehicle',
            'view any user',
            'view employee user',
            'view user',
        ];
    }

    protected function getDirectorITPermissions()
    {
        // Permissions specific to the Director IT role
        return [
            'view any download',
            'create download',
            'view download',
            'update field download',
            'upload file download',
            'publish download',
            'view any event',
            'view event',
            'create event',
            'update field event',
            'publish event',
            'view any gallery',
            'view gallery',
            'create gallery',
            'update field gallery',
            'upload file gallery',
            'publish gallery',
            'view any news',
            'view news',
            'create news',
            'update field news',
            'upload file news',
            'publish news',
            'view any slider',
            'view slider',
            'create slider',
            'update field slider',
            'upload file slider',
            'publish slider',
            'view any page',
            'view page',
            'create page',
            'update field page',
            'upload file page',
            'activate page',
            'view any story',
            'view story',
            'create story',
            'publish story',
            'view any comment',
            'view comment',
            'response comment',
            'publish comment',
        ];
    }

    protected function getAssistantDirectorITPermissions()
    {
        // Permissions specific to the Assistant Director IT role
        return [
            'view any download',
            'view download',
            'update field download',
            'upload file download',
            'view any event',
            'view event',
            'update field event',
            'view any gallery',
            'view gallery',
            'update field gallery',
            'upload file gallery',
            'view any news',
            'view news',
            'update field news',
            'upload file news',
            'view any slider',
            'view slider',
            'update field slider',
            'upload file slider',
            'view any page',
            'view page',
            'update field page',
            'upload file page',
            'view any story',
            'view story',
            'view any comment',
            'view comment',
            'response comment',
        ];
    }

    protected function getNewsManagerPermissions()
    {
        // Permissions specific to the News Manager role
        return [
            'view any news',
            'view news',
            'create news',
            'update field news',
            'upload file news',
            'publish news',
            'archive news',
            'post comment news',
            'view any event',
            'view event',
            'create event',
            'update field event',
            'publish event',
            'archive event',
            'post comment event',
            'view any slider',
            'view slider',
            'create slider',
            'update field slider',
            'upload file slider',
            'publish slider',
        ];
    }

    protected function getTenderManagerPermissions()
    {
        // Permissions specific to the Tender Manager role
        return [
            'view any tender',
            'view tender',
            'create tender',
            'update field tender',
            'publish tender',
            'archive tender',
            'delete tender',
            'post comment tender',
            // Add more permissions as needed
        ];
    }

    protected function getAdminPermissions()
    {
        // For the Admin role, we'll give all permissions
        return Permission::all()->pluck('name')->toArray();
    }
    
    protected function getPredefinedPermissions()
    {
        return [
            /* ----------- Admin Permissions Start -----------*/
            // Downloads
            'view any download',
            'create download',
            'view download',
            'update field download',
            'upload file download',
            'publish download',
            'archive download',
            'delete download',

            // Events
            'view any event',
            'view event',
            'create event',
            'update field event',
            'publish event',
            'archive event',
            'post comment event',
            'delete event',

            // Events
            'view any gallery',
            'view gallery',
            'create gallery',
            'update field gallery',
            'upload file gallery',
            'publish gallery',
            'archive gallery',
            'post comment gallery',
            'delete gallery',

            // News
            'view any news',
            'view news',
            'create news',
            'update field news',
            'upload file news',
            'publish news',
            'archive news',
            'post comment news',
            'delete news',

            // Seniority
            'view any seniority',
            'view seniority',
            'create seniority',
            'update field seniority',
            'upload file seniority',
            'publish seniority',
            'archive seniority',
            'post comment seniority',
            'delete seniority',

            // DevelopmentProject
            'view any development-project',
            'view development-project',
            'create development-project',
            'update field development-project',
            'publish development-project',
            'archive development-project',
            'post comment development-project',
            'delete development-project',

            // Project
            'view any project',
            'view project',
            'create project',
            'update field project',
            'upload file project',
            'delete project',

            // ProjectFile
            'view any project-file',
            'view project-file',
            'create project-file',
            'update field project-file',
            'upload file project-file',
            'publish project-file',
            'archive project-file',
            'delete project-file',

            // Slider
            'view any slider',
            'view slider',
            'create slider',
            'update field slider',
            'upload file slider',
            'publish slider',
            'archive slider',
            'post comment slider',
            'delete slider',

            // Achievement
            'view any achievement',
            'view achievement',
            'create achievement',
            'update field achievement',
            'upload file achievement',
            'publish achievement',
            'archive achievement',
            'delete achievement',

            // Page
            'view any page',
            'view page',
            'create page',
            'update field page',
            'upload file page',
            'activate page',
            'delete page',

            // Story
            'view any story',
            'view story',
            'create story',
            'publish story',
            'delete story',

            // Tender
            'view any tender',
            'view tender',
            'create tender',
            'update field tender',
            'publish tender',
            'archive tender',
            'delete tender',
            'post comment tender',

            // Scheme
            'view any scheme',
            'view scheme',
            'sync schemes',

            // Comment
            'view any comment',
            'view comment',
            'response comment',
            'publish comment',
            'archive comment',
            'delete comment',

            // Newsletter
            'view any newsletter',
            'mass email newsletter',

            // Public Contact
            'view any public-contact',
            'view public-contact',
            'relief grant public-contact',
            'relief not grant public-contact',
            'drop public-contact',
            /* ----------- Admin Permissions End -----------*/

            /* ----------- Contractor Permissions Start -----------*/
            // Contractor
            'view any contractor',
            'view contractor',
            'update field contractor',
            'upload file contractor',

            // Contractor Human Resource
            'view any contaractor-human-resource',
            'update contractor-human-resource',
            'upload contractor-human-resource',
            'delete contractor-human-resource',

            // Contractor Machinery
            'view any contaractor-machinery',
            'update contractor-machinery',
            'upload contractor-machinery',
            'delete contractor-machinery',

            // Contractor Work Experience
            'view any contaractor-work-experience',
            'update contractor-work-experience',
            'upload contractor-work-experience',
            'delete contractor-work-experience',

            // Contractor Registration
            'view any contractor-registration',
            'defer contractor-registration',
            'approve contractor-registration',
            'view contractor-registration',
            'view card contractor-registration',
            'renew contractor-registration',
            'update field contractor-registration',
            'upload file contractor-registration',
            /* ----------- Contractor Permissions End -------------*/

            /* ----------- Dmis Permissions Start -----------*/
            // Damage
            'view any damage',
            'create damage',
            'view damage',
            'update field damage',
            'delete damage',
            'view main report damage',
            'view officer report damage',
            'view district-wise report damage',
            'view active-officer report damage',
            
            // Infrastructure
            'view any infrastructure',
            'create infrastructure',
            'view infrastructure',
            'update field infrastructure',
            'delete infrastructure',

            // Damage Log
            'view any damage-log',

            // Settings
            'view settings damage', 
            'update settings damage', 
            'init settings damage', 
            /* ------------ Dmis Permissions End ------------*/

            /* ----------- Hr Permissions Start -----------*/
            // User
            'view any user',
            'create user',
            'view current posting user',
            'update user',
            'view employee user',
            'view user',
            'delete user',
            'view vacancy report user',
            'view employee directory report user',
            'view office strength report user',
            'view posting history report user',
            'view service length report user',
            'view retirement forecast report user',
            'view office staff report user',

            // Office
            'view any office',
            'create office',
            'view office',
            'activate office',
            'update field office',
            'delete office',
            'view organogram office',

            // Designation
            'view any designation',
            'create designation',
            'view designation',
            'activate designation',
            'update field designation',
            'delete designation',

            // Sanction Post
            'view any sanctioned-post',
            'create sanctioned-post',
            'view sanctioned-post',
            'update sanctioned-post',
            'delete sanctioned-post',
            'iew available positions sanctioned-post',
            'check exists sanctioned-post',

            // Posting
            'view any posting',
            'create posting',
            'view posting',
            'update posting',
            'delete posting',
            'end posting',
            'check sanctioned posting',
            'check occupancy posting',
            'view current officers posting',
            
            // Role
            'view any role',
            'create role',
            'delete role',
            'assign role',
            'assign permission role',
            'update permission role',

            // Permission
            'view any permission',
            'create permission',
            'delete permission',
            /* -----=------ Hr Permissions End ------------*/

            /* ----------- Machinery Permissions Start -----------*/
            // Machinery
            'view any machinery',
            'view machinery',
            'create machinery',
            'view history machinery',
            'update field machinery',
            'upload file machinery',
            'delete machinery',
            'view reports machinery',

            // Machinery Allocation
            'create machinery-allocation',
            /* ----------- Machinery Permissions End -------------*/

            /* ----------- Porms Permissions Start -----------*/
            // Provincial Own Receipt
            'view any provincial-own-receipt',
            'view provincial-own-receipt',
            'create provincial-own-receipt',
            'update field provincial-own-receipt',
            'upload file provincial-own-receipt',
            'delete provincial-own-receipt',
            'view reports provincial-own-receipt',
            /* ----------- Porms Permissions End -------------*/

            /* ----------- ServiceCard Permissions Start -----------*/
            'view any service-card',
            'create service-card',
            'view service-card',
            'view card service-card',
            'verify service-card',
            'reject service-card',
            'restore service-card',
            'renew service-card',
            'update field service-card',
            'upload file service-card',
            'delete service-card',
            /* ----------- ServiceCard Permissions End -------------*/

            /* ----------- Settings Permissions Start -----------*/
            'update core settings ',
            'manage main category settings',
            'manage district settings',
            'view activity settings',
            /* ----------- Settings Permissions End -------------*/

            /* ----------- Standardization Permissions Start -----------*/
            // Standardization
            'view any standardization',
            'view standardization',
            'approve standardization',
            'reject standardization',
            'view card standardization',
            'renew standardization',
            'update field standardization',
            'upload file standardization',
            /* ----------- Standardization Permissions End -------------*/

            /* ----------- Vehicle Permissions Start -----------*/
            // Vehicle
            'view any vehicle',
            'view vehicle',
            'create vehicle',
            'view history vehicle',
            'update field vehicle',
            'upload file vehicle',
            'delete vehicle',
            'view reports vehicle',

            // Vehicle Allotment
            'create vehicle-allotment'
            /* ----------- Vehicle Permissions End -------------*/
        ];
    }
}