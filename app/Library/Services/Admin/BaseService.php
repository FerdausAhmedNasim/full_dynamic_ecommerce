<?php

namespace App\Library\Services\Admin;

use Exception;
use Illuminate\Support\Facades\Log;

class BaseService
{
    public string $message = '';
    public mixed $data = null;

    protected function log(mixed $exception)
    {
        Log::error($exception);
    }

    protected function handleSuccess(string $message, mixed $data = null): bool
    {
        $this->message = $message;
        $this->data = $data;

        return true;
    }

    protected function handleFailed(string $message, mixed $data = null): bool
    {
        $this->message = $message;
        $this->data = $data;

        return false;
    }

    protected function handleException(Exception $exception): bool
    {
        $this->log($exception);

        if (get_class($exception) == 'App\Exceptions\CustomException') {
            $this->message = $exception->getMessage();
        } else {
            $this->message = 'Operation failed';
        }

        return false;
    }

}
