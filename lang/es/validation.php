<?php

return [
    'required' => 'El campo :attribute es obligatorio.',
    'string' => 'El campo :attribute debe ser una cadena de texto.',
    'email' => 'El campo :attribute debe ser una dirección de correo electrónico válida.',
    'unique' => 'El campo :attribute ya ha sido recibido.',
    'min.string' => 'El campo :attribute debe tener al menos :min caracteres.',
    'exists' => 'El :attribute seleccionado es inválido',
    'password' => [
        'mixed' => 'La contraseña debe contener al menos una letra mayúscula y una minúscula.',
        'numbers' => 'La contraseña debe contener al menos un número.',
        'symbols' => 'La contraseña debe contener al menos un carácter especial.',
    ],
    'max_digits' => 'El campo :attribute debe tener como máximo :max dígitos.'
];
