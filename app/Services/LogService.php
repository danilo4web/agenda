<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Exception;

class LogService
{
    public function logException(Exception $exception): void
    {
        Log::error('Exception: ' . $exception->getMessage(), ['exception' => $exception]);
    }
}
