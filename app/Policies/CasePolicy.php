<?php

namespace App\Policies;

use App\Models\User;
use App\Models\cases;

class CasePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->role === 'doctor';
    }

    public function view(User $user, cases $case): bool
    {
        if ($user->id !== $case->doctor_id) {
            abort(404);
        }

        return true;
    }

    public function create(User $user): bool
    {
        if ($user->role !== 'doctor') {
            abort(404);
        }
        return true;
    }

    public function update(User $user, cases $case): bool
    {
        if ($user->id !== $case->doctor_id) {
            abort(404);
        }

        return true;
    }

    public function delete(User $user, cases $case): bool
    {
        if ($user->id !== $case->doctor_id) {
            abort(404);
        }

        return true;
    }

    public function restore(User $user, cases $case): bool
    {
        if ($user->id !== $case->doctor_id) {
            abort(404);
        }

        return true;
    }

    public function forceDelete(User $user, cases $case): bool
    {
        return false;
    }
}
