<?php

namespace App\Services;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\BeforeValidException;
use Firebase\JWT\SignatureInvalidException;

class JWTService
{
    private $keyService;

    public function __construct(KeyService $keyService)
    {
        $this->keyService = $keyService;
    }

    public function generateToken(array $payload, int $expiration)
    {
        $claims = [
            'iat' => time(),
            'nbf' => time() + 5,
            'exp' => time() + $expiration,
        ];

        $payload = array_merge($claims, $payload);

        try {
            $privateKey = file_get_contents($this->keyService->getPrivateKey());
            if ($privateKey === false) {
                throw new \Exception("Error to read private key file");
            }

            return JWT::encode($payload, $privateKey, 'ES256');
        } catch (\Exception $e) {
            return "Error generating token: " . $e->getMessage();
        }
    }

    public function verifyToken(string $token)
    {
        try {
            $publicKey = file_get_contents($this->keyService->getPublicKey());

            if ($publicKey === false) {
                throw new \Exception("Error to read public key file");
            }

            $decoded = JWT::decode($token, new Key($publicKey, 'ES256'));

            return $decoded;
        } catch (ExpiredException $e) {
            return ['error' => __('auth.token.expired')];
        } catch (BeforeValidException $e) {
            return ['error' => __('auth.token.not_valid_yet')];
        } catch (SignatureInvalidException $e) {
            return ['error' => __('auth.token.invalid_signature')];
        } catch (\Exception $e) {
            return ['error' => __('auth.token.invalid')];
        }
    }
}
