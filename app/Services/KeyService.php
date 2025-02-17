<?php

namespace App\Services;
use Illuminate\Support\Facades\File;

class KeyService
{
    public function getPrivateKey()
    {
        $relativePath = env('JWT_PRIVATE_KEY_PATH');
        $absolutePath = base_path($relativePath);

        if (!File::exists($absolutePath)) {
            throw new \Exception("El archivo de la clave privada no existe en: $absolutePath");
        }

        return $absolutePath;
    }

    public function getPublicKey()
    {
        $relativePath = env('JWT_PUBLIC_KEY_PATH');
        $absolutePath = base_path($relativePath);

        if (!File::exists($absolutePath)) {
            throw new \Exception("El archivo de la clave pública no existe en: $absolutePath");
        }

        return $absolutePath;
    }
}
