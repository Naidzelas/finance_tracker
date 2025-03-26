<?php

namespace App\Services\Chart\Exceptions;

use Exception;

class ChartExceptions extends Exception
{
    public static function invalidDateRange(string $startDate, string $endDate): self
    {
        return new self("Invalid date range: start date '{$startDate}' comes after end date '{$endDate}'");
    }
    
    public static function userNotFound(int $userId): self
    {
        return new self("User with ID {$userId} not found");
    }

    public static function noDataAvailable(): self
    {
        return new self("No data available for the requested chart");
    }
}
