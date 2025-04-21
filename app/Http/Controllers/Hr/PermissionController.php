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