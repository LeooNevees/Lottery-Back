<?php

namespace App\Services;

use App\Jobs\ProcessSortition;

class QueueService
{
    public static function dispatchSortition(array $params, int $delay = 0): mixed
    {
        return ProcessSortition::dispatch($params)->delay(now()->addSeconds($delay));
    }
}
