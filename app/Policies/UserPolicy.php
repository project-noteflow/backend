<?php

namespace App\Policies;

use App\Enums\State;
use App\Enums\TypeUser;
use App\Models\User;

class UserPolicy
{
    public function activate(User $authUser, User $targetUser)
    {
        if ($authUser->activo !== State::active->value) {
            return false;
        }

        if ($authUser->id_usuario === $targetUser->id_usuario) {
            return false;
        }

        if ($authUser->id_rol === TypeUser::SuperAdmin->value && $targetUser->id_rol === TypeUser::Admin->value || $targetUser->id_rol === TypeUser::Client->value) {
            return true;
        }

        return $authUser->id_rol === TypeUser::Admin->value && $targetUser->id_rol === TypeUser::Client->value;
    }

    public function deactivate(User $authUser, User $targetUser)
    {
        if ($authUser->activo !== State::active->value) {
            return false;
        }
        
        if ($authUser->id_rol === TypeUser::SuperAdmin->value && $targetUser->id_rol === TypeUser::Admin->value || $targetUser->id_rol === TypeUser::Client->value) {
            return true;
        }

        return $authUser->id_rol === TypeUser::Admin->value && $targetUser->id_rol === TypeUser::Client->value;
    }
}
