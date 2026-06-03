<?php

namespace App\Library\Services\Admin;

use Exception;
use App\Models\Config;
use App\Library\Helper;

class ConfigService extends BaseService
{
    public function updateConfig(string $key, string $value)
    {
        try {
            $config = Config::firstOrNew(['key' => $key]);
            $config->value = $value;
            $config->save();

            return $this->handleSuccess('Successfully updated');
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }

    public static function getByKey(string $key)
    {
        return Config::where('key', $key)->first();
    }

    public static function getDropdown(string $key)
    {
        $config = self::getByKey($key);

        return $config && $config->value ? json_decode($config->value) : [];
    }


}
