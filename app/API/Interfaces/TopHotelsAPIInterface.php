<?php

namespace App\API\Interfaces;

interface TopHotelsAPIInterface
{
   public function search(string $from, string $to, string $city, int $adultsCount);
}
