<?php

namespace App\Http\Controllers;

use App\Models\Role;

class RoleController extends Controller
{
    public function getAll()
    {
        $roles = Role::all();

        if (!$roles) {
            return response()->json([
                __('messages.labels.message') => __('messages.users.not_found')
            ], 404);
        }

        return response()->json([
            'data' => $roles,
        ]);
    }
}
