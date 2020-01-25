<?php

namespace App\Services\Interfaces;

interface OurHotelsAggregatorInterface
{
    public function search(string $from_date, string $to_date, string $city, int $adult_number);
}
