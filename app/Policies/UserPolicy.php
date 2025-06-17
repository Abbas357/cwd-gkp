<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can('view any user');
    }

    public function create(User $user): bool
    {
        return $user->can('create user');
    }

    public function viewCurrentPosting(User $user): bool
    {
        return $user->can('view current posting user');
    }

    public function update(User $user, User $model): bool
    {
        return $user->id == $model->id || $user->can('update user');
    }

    public function viewEmployee(User $user, User $model): bool
    {
        return $user->can('view employee user');
    }

    public function view(User $user, User $model): bool
    {
        return $user->can('view user');
    }

    public function delete(User $user, User $model): bool
    {
        return $user->can('delete user');
    }

    public function viewVacancyReport(User $user): bool
    {
        return $user->can('view vacancy report user');
    }

    public function viewEmployeeDirectoryReport(User $user): bool
    {
        return $user->can('view employee directory report user');
    }

    public function viewOfficeStrengthReport(User $user): bool
    {
        return $user->can('view office strength report user');
    }

    public function viewPostingHistoryReport(User $user): bool
    {
        return $user->can('view posting history report user');
    }

    public function viewServiceLengthReport(User $user): bool
    {
        return $user->can('view service length report user');
    }

    public function viewRetirementForecastReport(User $user): bool
    {
        return $user->can('view retirement forecast report user');
    }

    public function viewOfficeStaffReport(User $user): bool
    {
        return $user->can('view office staff report user');
    }

    public function viewSettings(User $user): bool
    {
        return $user->can('view settings hr');
    }

    public function updateSettings(User $user): bool
    {
        return $user->can('update settings hr');
    }

    public function initSettings(User $user): bool
    {
        return $user->can('init settings hr');
    }
}
