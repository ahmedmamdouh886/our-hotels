<?php

namespace App\APIProviders;

use App\API\Interfaces\TopHotelsAPIInterface as TopHotelsAPIInterface;
use App\APIProviders\Interfaces\APIProviderInterface as APIProviderInterface;

class TopHotelsAPIProvider implements APIProviderInterface
{

    private $providerName = 'TopHotels';

    /**
     * Constructor function.
     *
     * @param TopHotelsAPIInterface injection (DI).
     */
    public function __construct(TopHotelsAPIInterface $topHotelsAPI)
    {
        $this->toptHotelsAPI = $topHotelsAPI;
    }

    /**
     * Retrieve all hotels.
     *
     * @return array
     */
    public function getHotels(string $from, string $to, string $city, int $adults_count)
    {
        $hotels = $this->toptHotelsAPI->search($from, $to, $city, $adults_count);

        return $this->formatHotel($hotels);
    }

    /**
     * Format single hotel response.
     *
     * @param array $from
     * @return array $formattedHotel
    */
   private function formatHotel(array $hotels): array
   {
        $formattedHotel = [];

        foreach ($hotels as $key => $hotel) {
          $formattedHotel[] = [
            'provider' => $this->getProviderName(), 
            'hotelName' => $hotel['hotelName'], 
            'rate' => $this->calculateRate($hotel['rate']), 
            'fare' => $hotel['price'],
            'amenities' => $hotel['amenities']
          ];
        }

        return $formattedHotel;
   }
   
    /**
     * return providerName
     *
     * @return string $this->providerName
    */
   private function getProviderName() 
   {
       return $this->providerName;
   }

   /**
     * return '*' character count.
     *
     * @return int
    */
   private function calculateRate(string $rate): int
   {
       return (int) strlen($rate);
   }
}
