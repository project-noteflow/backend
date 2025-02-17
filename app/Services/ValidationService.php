<?php

namespace App\Services;

use Illuminate\Support\Facades\Validator;

class ValidationService
{
    public function validate(array $data, array $rules)
    {
        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return response()->json([
                __('messages.labels.message') => $validator->messages(),
            ]);
        }

        return null;
    }
}
