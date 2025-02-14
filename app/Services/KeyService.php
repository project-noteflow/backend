<?php

namespace App\Services;

class KeyService
{
    public function getPrivateKey()
    {
        $relativePath = env('JWT_PRIVATE_KEY_PATH');
        return base_path($relativePath);
    }

    public function getPublicKey()
    {
        $relativePath = env('JWT_PUBLIC_KEY_PATH');
        return base_path($relativePath);
    }
}
