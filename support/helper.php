<?php

if (!function_exists('config')) {
    function config(string $key, $default = null)
    {
        $configLevel = explode('.', $key);

        if (!count($configLevel)) {
            return '';
        }

        $confDir = __DIR__ . "/../config/{$configLevel[0]}.php";
        if (!file_exists($confDir)) {
            return '';
        }

        $configData = require $confDir;

        foreach ($configLevel as $index => $config) {
            if ($index == 0) continue;

            $configData = $configData[$config];
        }

        return is_array($configData) ? '' : $configData ?? $default;
    }
}

if (!function_exists('dump')) {
    function dump($data)
    {
        header('Content-Type: application/json');

        echo json_encode($data);
        die();
    }
}

if (!function_exists('error')) {
    function error(string $message, int $code = 400)
    {
        echo $message;
    }
}

if (!function_exists('invalid_class')) {
    function invalid_class($errors, $key)
    {
        if (!empty($errors['errors'][$key])) {
            return 'is-invalid';
        }

        return '';
    }
}

if (!function_exists('invalid_message')) {
    function invalid_message($errors, $key)
    {
        if (!empty($errors['errors'][$key])) {
            return '<div class="invalid-feedback">'. $errors['errors'][$key][0] .'</div>';
        }

        return '';
    }
}

if (!function_exists('old')) {
    function old($errors, $key)
    {
        return !empty($errors['values'][$key]) ? $errors['values'][$key] : null;
    }
}

if (!function_exists('message')) {
    function message($data)
    {
        return !empty($data['message']) ? '<div class="alert alert-success">'. $data['message'] .'</div>' : '';
    }
}
