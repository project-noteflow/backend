<?php

return [
    'required' => 'The :attribute field is required.',
    'email' => 'The :attribute must be a valid email address.',
    'unique' => 'The :attribute has already been taken.',
    'min.string' => 'The :attribute must be at least :min characters.',
    'string' => 'The :attribute must be a string.',
    'exists' =>  'The selected :attribute is invalid.',
    'password' => [
        'mixed' => 'The :attribute must contain at least one uppercase and one lowercase letter.',
        'numbers' => 'The :attribute must contain at least one number',
        'symbols' => 'The :attribute must contain at least one symbol',
    ],
    'max_digits' => 'The :attribute must not be greater than :max digits.',
];
