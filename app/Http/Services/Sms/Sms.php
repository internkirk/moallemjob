<?php
namespace App\Http\Services\Sms;

use Exception;
use Illuminate\Support\Facades\Http;


class Sms
{

    public $body_id;
    public $number;
    public $variables;

    public function __call($method, $args)
    {
        return $this->call($method, $args);
    }
    public static function __callStatic($method, $args)
    {
        return (new static())->call($method, $args);
    }

    public function call($method, $args)
    {
        if (!method_exists($this, "_" . $method))
            throw new Exception("Method " . $method . " Does Not Exists in This Class...");

        return $this->{"_" . $method}($args);
    }


    private function _welcome()
    {
        $this->body_id = $this->getBodyId('welcome');

        return $this;
    }
    private function _loginAndRegister()
    {
        $this->body_id = $this->getBodyId('login');

        return $this;
    }
    private function _changePassword()
    {
        $this->body_id = $this->getBodyId('changePassword');

        return $this;
    }

    private function _send()
    {
        try {

            Http::post('https://rest.payamak-panel.com/api/SendSMS/BaseServiceNumber', [
                'username' => $this->getUsername(),
                'password' => $this->getPassword(),
                'text' => $this->variables ? $this->variables : '',
                'to' => $this->number,
                'bodyId' => $this->body_id,
            ]);

            return response([
                'message' => 'ok'
            ]);

        } catch (Exception $e) {
            return response([
                'error' => $e->getMessage()
            ], 400);
        }
    }

    private function _variables(...$var)
    {
        $this->variables = implode(";",$var[0]);

        return $this;
    }

    private function getUsername()
    {
        return config('sms.username');
    }
    private function getPassword()
    {
        return config('sms.password');
    }

    private function _to($number)
    {
        $this->number = $number[0];

        return $this;
    }
    private function getBodyId($type)
    {
        if ($type == 'welcome')
            return 321544;

        if ($type == 'login')
            return 311998;

        if ($type == 'changePassword')
            return 321543;
    }
}