<?php

namespace App\Http\Controllers\Hr;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::orderBy('name')->get();
        
        $groupedPermissions = $permissions->groupBy(function ($permission) {
            $parts = explode(' ', $permission->name);
            return count($parts) > 1 ? $parts[count($parts) - 1] : 'general';
        })->sortKeys();
        
        $totalPermissions = $permissions->count();
        
        return view('modules.hr.acl.permissions', compact('groupedPermissions', 'totalPermissions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:permissions,name',
        ]);

        $permission = Permission::create(['name' => $request->name]);
        
        return redirect()->back()->with('success', 'Permission created successfully.');
    }

    public function destroy(Permission $permission)
    {
        $permission->delete();
        
        return redirect()->back()->with('success', 'Permission deleted successfully.');
    }

    public function sync()
    {
        try {
            DB::beginTransaction();
            
            $tableNames = config('permission.table_names');
            
            DB::statement('SET FOREIGN_KEY_CHECKS=0');
            
            DB::table($tableNames['role_has_permissions'])->truncate();
            
            DB::table($tableNames['model_has_permissions'])->truncate();
            
            DB::table($tableNames['permissions'])->truncate();
            
            DB::statement('SET FOREIGN_KEY_CHECKS=1');
            
            $predefinedPermissions = $this->getPredefinedPermissions();
            $permissions = [];
            
            foreach ($predefinedPermissions as $permission) {
                $permissions[] = [
                    'name' => $permission,
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
            
            DB::table($tableNames['permissions'])->insert($permissions);
            
            app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
            
            DB::commit();
            
            return redirect()->back()->with('success', 'All permissions have been reset to defaults.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->back()->with('error', 'Error resetting permissions: ' . $e->getMessage());
        }
    }
    
    protected function getPredefinedPermissions()
    {
        return [

            // Admin Permissions Start
            // Downloads
            'view any download',
            'create download',
            'view download',
            'view detail download',
            'update field download',
            'upload file download',
            'publish download',
            'archive download',
            'delete download',

            // Events
            'view any event',
            'view event',
            'create event',
            'view detail event',
            'update field event',
            'publish event',
            'archive event',
            'post comment event',
            'delete event',

            // Events
            'view any gallery',
            'view gallery',
            'create gallery',
            'view detail gallery',
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
            'view detail news',
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
            'view detail seniority',
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
            'view detail development-project',
            'update field development-project',
            'publish development-project',
            'archive development-project',
            'post comment development-project',
            'delete development-project',

            // Project
            'view any project',
            'view project',
            'create project',
            'view detail project',
            'update field project',
            'upload file project',
            'delete project',

            // ProjectFile
            'view any project-file',
            'view project-file',
            'create project-file',
            'view detail project-file',
            'update field project-file',
            'upload file project-file',
            'publish project-file',
            'archive project-file',
            'delete project-file',

            // Slider
            'view any slider',
            'view slider',
            'create slider',
            'view detail slider',
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
            'view detail achievement',
            'update field achievement',
            'upload file achievement',
            'publish achievement',
            'archive achievement',
            'delete achievement',

            // Page
            'view any page',
            'view page',
            'create page',
            'view detail page',
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
            'view detail tender',
            'update field tender',
            'publish tender',
            'archive tender',
            'delete tender',
            'post comment tender',

            // Scheme
            'view any scheme',
            'view detail scheme',
            'sync schemes',

            // Comment
            'view any comment',
            'view comment',
            'response comment',
            'view detail comment',
            'publish comment',
            'archive comment',
            'delete comment',

            // Newsletter
            'view any newsletter',
            'mass email newsletter',

            // Public Contact
            'view any public-contact',
            'view detail public-contact',
            'relief grant public-contact',
            'relief not grant public-contact',
            'drop public-contact',

            // Activity Logs
            'view activity',
            //Admin Permissions End

            // Contractor Permissions Start
            
            // Contractor Permissions End

            // Dmis Permissions Start
            // Dmis Permissions End

            // Hr Permissions Start
            // Hr Permissions End

            // Machinery Permissions Start
            // Machinery Permissions End

            // Porms Permissions Start
            // Porms Permissions End

            // ServiceCard Permissions Start
            // ServiceCard Permissions End

            // Settings Permissions Start
            // Settings Permissions End

            // Standardization Permissions Start
            // Standardization Permissions End

            // Vehicle Permissions Start
            // Vehicle Permissions End

            // User permissions
            'view any user',
            'view user',
            'create user',
            'update user',
            'delete user',
            'activate user',
            'archive user',
            'edit profile',
            
            // Office permissions
            'view any office',
            'view office',
            'create office',
            'update office',
            'delete office',
            'activate office',
            
            // Designation permissions
            'view any designation',
            'view designation',
            'create designation',
            'update designation',
            'delete designation',
            'activate designation',
            
            // Sanctioned posts permissions
            'view any sanction post',
            'view sanction post',
            'create sanction post',
            'update sanction post',
            'delete sanction post',
            
            // Posting permissions
            'view any posting',
            'view posting',
            'create posting',
            'update posting',
            'delete posting',
            'end posting',
            
            // Role permissions
            'view any role',
            'view role',
            'create role',
            'update role',
            'delete role',
            
            // Permission permissions
            'view any permission',
            'view permission',
            'create permission',
            'update permission',
            'delete permission',
            'sync permission',
            
            // HR Reports
            'view vacancy report',
            'view employee directory',
            'view office strength',
            'view posting history',
            'view service length',
            'view retirement forecast',
            'view office staff',
            
            // HR Dashboard and organization
            'view hr dashboard',
            'view organization chart',
            'view organogram',
            
            // Website modules
            'manage website',
            
            // Vehicle Management
            'manage vehicles',
            'view any vehicle',
            'view vehicle',
            'create vehicle',
            'update vehicle',
            'delete vehicle',
            'view vehicle report',
            
            // Machinery Management
            'manage machinery',
            'view any machinery',
            'view machinery',
            'create machinery',
            'update machinery',
            'delete machinery',
            'view machinery report',
            
            // Contractor Management
            'manage contractors',
            'view any contractor',
            'view contractor',
            'create contractor',
            'update contractor',
            'delete contractor',
            'view contractor report',
            
            // Service Card Management
            'manage service cards',
            'view any service card',
            'view service card',
            'create service card',
            'update service card',
            'delete service card',
            'view service card report',
            
            // Standardization Management
            'manage standardizations',
            'view any standardization',
            'view standardization',
            'create standardization',
            'update standardization',
            'delete standardization',
            'view standardization report',
            
            // PORMS Management
            'manage porms',
            'view any porms',
            'view porms',
            'create porms',
            'update porms',
            'delete porms',
            'view porms report',
            
            // DTS Management
            'manage dts',
            'view any infrastructures',
            'view infrastructures',
            'create infrastructures',
            'update infrastructures',
            'delete infrastructures',
            
            'view any damages',
            'view damages',
            'create damages',
            'update damages',
            'delete damages',
            
            'view dts settings',
            
            // Settings Management
            'view settings',
            'update settings',
            'view any district',
            'view district',
            'create district',
            'update district',
            'delete district',
            'view any category',
            'view category',
            'create category',
            'update category',
            'delete category',
        ];
    }
}