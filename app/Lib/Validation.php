<?php

namespace App\Lib;

class Validation
{
    protected static $ruleTypes = [
        'required',
        'min',
        'password_confirmation',
        'unique',
    ];

    protected static $response = [];

    public static $database;

    public static function make(array $data, array $rules): array
    {
        self::$database = (new Connection)->db;

        foreach ($rules as $key => $rulesArr) {
            self::$response['values'][$key] = $data[$key];

            if (empty($rulesArr)) {
                continue;
            }

            foreach ($rulesArr as $rule) {
                $explodeRule = explode(':', $rule);
                $parameter = null;

                if (count($explodeRule) > 1) {
                    $rule = $explodeRule[0];
                    $parameter = $explodeRule[1];
                }

                if (!in_array($rule, self::$ruleTypes) || !array_key_exists($key, $data)) {
                    continue;
                }

                if (is_string($result = self::{$rule}($data, $key, $parameter))) {
                    self::$response['errors'][$key][] = $result;
                }
            }
        }

        return self::$response;
    }

    public static function pushError(string $key, string $message)
    {
        self::$response['errors'][$key][] = $message;

        return self::$response;
    }

    private static function required(array $data, string $key, $parameter = null)
    {
        if (empty($data[$key])) {
            return sprintf('Please fill %s item', $key);
        }

        return true;
    }

    private static function min(array $data, string $key, $parameter = null)
    {
        if (mb_strlen($data[$key]) < $parameter) {
            return 'Parameter should be more then ' . $parameter;
        }

        return true;
    }

    public static function password_confirmation(array $data, string $key, $parameter = null)
    {
        if ($data[$key] !== $data['password_confirmation']) {
            return 'Password not match';
        }

        return true;
    }

    public static function unique(array $data, string $key, $parameter = null)
    {
        $stmt = self::$database->prepare("SELECT * FROM users WHERE email=:email");
        $stmt->execute(['email' => $data[$key]]);
        $result = $stmt->fetch();

        if ($result) {
            return 'This ' . $key . 'already taken';
        }

        return true;
    }
}
