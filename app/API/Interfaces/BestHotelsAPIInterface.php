<?php

namespace App\API\Interfaces;

interface BestHotelsAPIInterface
{
   public function search(string $formDate, string $toDate, string $city, int $numberOfAdults);
}
