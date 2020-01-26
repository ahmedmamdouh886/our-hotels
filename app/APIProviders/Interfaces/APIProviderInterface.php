<?php

namespace App\APIProviders\Interfaces;

interface APIProviderInterface
{
   public function getHotels(string $from, string $to, string $city, int $adults_count);
}
