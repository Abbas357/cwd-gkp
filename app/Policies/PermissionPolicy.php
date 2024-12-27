<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class PermissionPolicy
{    
    public function viewAny(User $user): bool
    {
        return false;
    }
    
    public function view(User $user): bool
    {
        return false;
    }
    
    public function create(User $user): bool
    {
        return false;
    }
    
    public function update(User $user): bool
    {
        return false;
    }
    
    public function delete(User $user): bool
    {
        return false;
    }
    
    public function restore(User $user): bool
    {
        return false;
    }
    
    public function forceDelete(User $user): bool
    {
        return false;
    }
}

// INSERT INTO permissions ( name, guard_name, created_at, updated_at) VALUES 
    // ('view any category', 'web', NOW(), NOW()),
    // ('view category', 'web', NOW(), NOW()),
    // ('create category', 'web', NOW(), NOW()),
    // ('update category', 'web', NOW(), NOW()),
    // ('delete category', 'web', NOW(), NOW()),

    // ('update comment', 'web', NOW(), NOW()),
    // ('delete comment', 'web', NOW(), NOW()),
    // ('publish comment', 'web', NOW(), NOW()),
    // ('archive comment', 'web', NOW(), NOW()),

    // ('view any contractor', 'web', NOW(), NOW()),
    // ('view contractor', 'web', NOW(), NOW()),
    // ('update contractor', 'web', NOW(), NOW()),
    // ('deffer contractor first time', 'web', NOW(), NOW()),
    // ('deffer contractor second time', 'web', NOW(), NOW()),
    // ('approve contractor', 'web', NOW(), NOW()),
    // ('generate contractor card', 'web', NOW(), NOW()),
    // ('renew contractor card', 'web', NOW(), NOW()),
    // ('delete contractor', 'web', NOW(), NOW()),

    // ('create development project', 'web', NOW(), NOW()),
    // ('update development project', 'web', NOW(), NOW()),
    // ('delete development project', 'web', NOW(), NOW()),
    // ('publish development project', 'web', NOW(), NOW()),
    // ('archive development project', 'web', NOW(), NOW()),

    // ('create download', 'web', NOW(), NOW()),
    // ('update download', 'web', NOW(), NOW()),
    // ('delete download', 'web', NOW(), NOW()),
    // ('publish download', 'web', NOW(), NOW()),
    // ('archive download', 'web', NOW(), NOW()),
    // ('update download field', 'web', NOW(), NOW()),
    // ('upload download file', 'web', NOW(), NOW()),

    // ('view any standardization', 'web', NOW(), NOW()),
    // ('view standardization', 'web', NOW(), NOW()),
    // ('update standardization', 'web', NOW(), NOW()),
    // ('approve standardization', 'web', NOW(), NOW()),
    // ('reject standardization', 'web', NOW(), NOW()),
    // ('generate standardization card', 'web', NOW(), NOW()),
    // ('renew standardization card', 'web', NOW(), NOW()),
    // ('delete standardization', 'web', NOW(), NOW()),

    // ('view any event', 'web', NOW(), NOW()),
    // ('view event', 'web', NOW(), NOW()),
    // ('create event', 'web', NOW(), NOW()),
    // ('update event', 'web', NOW(), NOW()),
    // ('publish event', 'web', NOW(), NOW()),
    // ('archive event', 'web', NOW(), NOW()),
    // ('delete event', 'web', NOW(), NOW()),
    // ('update event field', 'web', NOW(), NOW()),
    // ('upload event file', 'web', NOW(), NOW()),

    // ('view any gallery', 'web', NOW(), NOW()),
    // ('view gallery', 'web', NOW(), NOW()),
    // ('create gallery', 'web', NOW(), NOW()),
    // ('update gallery', 'web', NOW(), NOW()),
    // ('publish gallery', 'web', NOW(), NOW()),
    // ('archive gallery', 'web', NOW(), NOW()),
    // ('delete gallery', 'web', NOW(), NOW()),
    // ('update gallery field', 'web', NOW(), NOW()),
    // ('upload gallery file', 'web', NOW(), NOW()),

    // ('view any newsletter', 'web', NOW(), NOW()),
    // ('create mass email', 'web', NOW(), NOW()),
    // ('send mass email', 'web', NOW(), NOW()),

    // ('view any news', 'web', NOW(), NOW()),
    // ('view news', 'web', NOW(), NOW()),
    // ('create news', 'web', NOW(), NOW()),
    // ('update news', 'web', NOW(), NOW()),
    // ('delete news', 'web', NOW(), NOW()),
    // ('publish news', 'web', NOW(), NOW()),
    // ('archive news', 'web', NOW(), NOW()),
    // ('update news field', 'web', NOW(), NOW()),
    // ('upload news file', 'web', NOW(), NOW()),

    // ('view any page', 'web', NOW(), NOW()),
    // ('view page', 'web', NOW(), NOW()),
    // ('create page', 'web', NOW(), NOW()),
    // ('update page', 'web', NOW(), NOW()),
    // ('delete page', 'web', NOW(), NOW()),
    // ('activate page', 'web', NOW(), NOW()),
    // ('update page field', 'web', NOW(), NOW()),
    // ('upload page file', 'web', NOW(), NOW()),

    // ('view project file', 'web', NOW(), NOW()),
    // ('create project file', 'web', NOW(), NOW()),
    // ('update project file', 'web', NOW(), NOW()),
    // ('delete project file', 'web', NOW(), NOW()),
    // ('publish project file', 'web', NOW(), NOW()),
    // ('archive project file', 'web', NOW(), NOW()),

    // ('view any project', 'web', NOW(), NOW()),
    // ('view project', 'web', NOW(), NOW()),
    // ('create project', 'web', NOW(), NOW()),
    // ('update project', 'web', NOW(), NOW()),
    // ('delete project', 'web', NOW(), NOW()),

    // ('view any public contact', 'web', NOW(), NOW()),
    // ('view public contact', 'web', NOW(), NOW()),
    // ('create public contact', 'web', NOW(), NOW()),
    // ('grant relief to public contact', 'web', NOW(), NOW()),
    // ('deny relief to public contact', 'web', NOW(), NOW()),
    // ('drop public contact', 'web', NOW(), NOW()),

    // ('view any seniority', 'web', NOW(), NOW()),
    // ('view seniority', 'web', NOW(), NOW()),
    // ('create seniority', 'web', NOW(), NOW()),
    // ('delete seniority', 'web', NOW(), NOW()),
    // ('publish seniority', 'web', NOW(), NOW()),
    // ('archive seniority', 'web', NOW(), NOW()),
    // ('update seniority field', 'web', NOW(), NOW()),
    // ('upload seniority file', 'web', NOW(), NOW()),

    // ('view any service card', 'web', NOW(), NOW()),
    // ('view service card', 'web', NOW(), NOW()),
    // ('create service card', 'web', NOW(), NOW()),
    // ('update service card', 'web', NOW(), NOW()),
    // ('delete service card', 'web', NOW(), NOW()),
    // ('verify service card', 'web', NOW(), NOW()),
    // ('reject service card', 'web', NOW(), NOW()),
    // ('restore service card', 'web', NOW(), NOW()),
    // ('renew service card', 'web', NOW(), NOW()),
    // ('update service card field', 'web', NOW(), NOW()),
    // ('upload service card file', 'web', NOW(), NOW()),

    // ('view any slider', 'web', NOW(), NOW()),
    // ('view slider', 'web', NOW(), NOW()),
    // ('create slider', 'web', NOW(), NOW()),
    // ('update slider', 'web', NOW(), NOW()),
    // ('delete slider', 'web', NOW(), NOW()),
    // ('publish slider', 'web', NOW(), NOW()),
    // ('archive slider', 'web', NOW(), NOW()),
    // ('update slider field', 'web', NOW(), NOW()),
    // ('upload slider file', 'web', NOW(), NOW()),

    // ('view any story', 'web', NOW(), NOW()),
    // ('view story', 'web', NOW(), NOW()),
    // ('create story', 'web', NOW(), NOW()),
    // ('update story', 'web', NOW(), NOW()),
    // ('delete story', 'web', NOW(), NOW()),
    // ('publish story', 'web', NOW(), NOW()),

    // ('view any tender', 'web', NOW(), NOW()),
    // ('view tender', 'web', NOW(), NOW()),
    // ('create tender', 'web', NOW(), NOW()),
    // ('update tender', 'web', NOW(), NOW()),
    // ('delete tender', 'web', NOW(), NOW()),
    // ('restore tender', 'web', NOW(), NOW()),
    // ('force delete tender', 'web', NOW(), NOW()),
    // ('publish tender', 'web', NOW(), NOW()),
    // ('archive tender', 'web', NOW(), NOW()),

    // ('view any user', 'web', NOW(), NOW()),
    // ('view user', 'web', NOW(), NOW()),
    // ('create user', 'web', NOW(), NOW()),
    // ('update user', 'web', NOW(), NOW()),
    // ('delete user', 'web', NOW(), NOW()),
    // ('activate user', 'web', NOW(), NOW()),
    // ('archive user', 'web', NOW(), NOW());
