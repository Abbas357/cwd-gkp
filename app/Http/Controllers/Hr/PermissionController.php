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
        
        return view('modules.hr.permissions.index', compact('groupedPermissions', 'totalPermissions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:permissions,name',
        ]);

        $permission = Permission::create(['name' => $request->name]);
        
        return redirect()->route('admin.apps.hr.permissions.index')
            ->with('success', 'Permission created successfully.');
    }

    public function destroy(Permission $permission)
    {
        $permission->delete();
        
        return redirect()->route('admin.apps.hr.permissions.index')
            ->with('success', 'Permission deleted successfully.');
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
            
            return redirect()->route('admin.apps.hr.permissions.index')
                ->with('success', 'All permissions have been reset to defaults.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->route('admin.apps.hr.permissions.index')
                ->with('error', 'Error resetting permissions: ' . $e->getMessage());
        }
    }
    
    protected function getPredefinedPermissions()
    {
        return [
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
            'view any news',
            'view news',
            'create news',
            'update news',
            'delete news',
            'publish news',
            'archive news',
            
            'view any event',
            'view event',
            'create event',
            'update event',
            'delete event',
            'publish event',
            'archive event',
            
            'view any tender',
            'view tender',
            'create tender',
            'update tender',
            'delete tender',
            'publish tender',
            'archive tender',
            
            'view any gallery',
            'view gallery',
            'create gallery',
            'update gallery',
            'delete gallery',
            'publish gallery',
            'archive gallery',
            
            'view any slider',
            'view slider',
            'create slider',
            'update slider',
            'delete slider',
            'publish slider',
            'archive slider',
            
            'view any story',
            'view story',
            'create story',
            'update story',
            'delete story',
            'publish story',
            
            'view any page',
            'view page',
            'create page',
            'update page',
            'delete page',
            'activate page',
            
            'create download',
            'view any download',
            'view download',
            'update download',
            'delete download',
            'publish download',
            'archive download',
            
            'view any card',
            
            'view any project',
            'view project',
            'create project',
            'update project',
            'delete project',
            
            'view project file',
            
            'view any development project',
            'view development project',
            'create development project',
            'update development project',
            'delete development project',
            'publish development project',
            'archive development project',
            
            'view any scheme',
            'view scheme',
            'sync scheme',
            
            'view any achievement',
            'view achievement',
            'create achievement',
            'update achievement',
            'delete achievement',
            'publish achievement',
            'archive achievement',
            
            'update comment',
            'view any newsletter',
            'view newsletter',
            'sendMassEmail newsletter',
            
            'view any public contact',
            'view public contact',
            'reliefGrant public contact',
            'reliefNotGrant public contact',
            'drop public contact',
            
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
            
            // Activity Logs
            'view activity',
        ];
    }
}