<?php
namespace App\Http\Services\Jwt;

use Exception;
use Illuminate\Support\Collection;


class Jwt
{

    public $payload;

    // public const signing_key = env("JWT_TOKEN");


    public function __call($method, $args)
    {
        return $this->call($method, $args);
    }
    public static function __callStatic($method, $args)
    {
        return (new static())->call($method, $args);
    }

    private function call($method, $args)
    {
        if (!method_exists($this, "_" . $method)) {
            throw new Exception("method does not exist");
        }

        return $this->{"_" . $method}($args);
    }

    public function _getToken()
    {
        $header = [
            "alg" => "HS512",
            "typ" => "JWT"
        ];
        $header = $this->base64_url_encode(json_encode($header));
        $payload = $this->base64_url_encode(json_encode($this->payload));
        $signature = $this->base64_url_encode(hash_hmac('sha512', "$header.$payload", env("JWT_TOKEN"), true));
        $jwt = "$header.$payload.$signature";
        return $jwt;
    }

    /**
     * per https://stackoverflow.com/questions/2040240/php-function-to-generate-v4-uuid/15875555#15875555
     */
    private function base64_url_encode($text): string
    {
        return str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($text));
    }


    private function base64_url_decode($text): string
    {
        return base64_decode(
            str_replace(
                ["-", "_", '='],
                ["+", "/", ''],
                $text
            )
        );
    }


    public function _decode($text)
    {
        if (!$this->_checkSignature($text))
            throw new Exception('Signature Is Not Valid.');

        $result = explode('.', $text[0]);
        $payload = $result[1];

        return json_decode($this->base64_url_decode($payload), true);
    }


    private function _payload(array $payload)
    {
        $this->payload = $payload;

        return $this;
    }

    private function _checkSignature($text)
    {
        $result = explode('.', $text[0]);

        $header = $result[0];
        $payload = $result[1];
        $singnature = $result[2];

        $signature_from_user = $this->base64_url_decode($singnature);

        $signature = hash_hmac('sha512', "$header.$payload", env("JWT_TOKEN"), true);

        if (!hash_equals($signature, $signature_from_user)) {
            return false;
        }

        return true;
    }

    private function _getPayload($token): Collection
    {
        $result = explode('.', $token[0]);

        $header = $result[0];
        $payload = $result[1];
        $singnature = $result[2];

        return collect(json_decode($this->base64_url_decode($payload),true));
    }

    public function _check()
    {
        return $this->_checkSignature($this->payload);
    }


}

// $data = [
//     'id' => 1,
//     'name' => 'mehdi'
// ];

// $res = jwt::payload($data)->getToken();

// $data = jwt::payload($res)->check();
