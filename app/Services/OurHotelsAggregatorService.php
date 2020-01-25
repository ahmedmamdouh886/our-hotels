<?php

namespace App\Services;

use App\Services\Interfaces\OurHotelsAggregatorInterface as OurHotelsAggregatorInterface;

class OurHotelsAggregatorService implements OurHotelsAggregatorInterface
{
    public function search(string $from_date, string $to_date, string $city, int $adults_number) 
    {
        return 'OurHotelsAggregatorService';
    }
}