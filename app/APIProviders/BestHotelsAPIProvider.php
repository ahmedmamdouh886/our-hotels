<?php

namespace App\APIProviders;

use App\API\Interfaces\BestHotelsAPIInterface as BestHotelsAPIInterface;
use App\APIProviders\Interfaces\APIProviderInterface as APIProviderInterface;

class BestHotelsAPIProvider implements APIProviderInterface
{

    private $providerName = 'BestHotels';

    /**
     * Constructor function.
     *
     * @param BestHotelsAPIInterface injection (DI).
     */
    public function __construct(BestHotelsAPIInterface $bestHotelsAPIInterface)
    {
        $this->bestHotelsAPI = $bestHotelsAPIInterface;
    }

    /**
     * Retrieve all hotels.
     *
     * @param BestHotelsAPIInterface injection (DI).
     */
    public function getHotels(string $from_date, string $to_date, string $city, int $adult_number)
    {
        $hotels = $this->bestHotelsAPI->search($from_date, $to_date, $city, $adult_number);

        return $this->formatResponse($hotels);
    }

    /**
     * Format single hotel response.
     *
     * @param array $from
     * @return array $formattedHotel
    */
   private function formatResponse(array $hotels): array
   {
        $formattedHotel = [];

        foreach ($hotels as $key => $hotel) {
          $formattedHotel[] = [
            'provider' => $this->getProviderName(), 
            'hotelName' => $hotel['hotel'],
            'fare' => $hotel['hotelFare'],
            'rate' => $hotel['hotelRate'],
            'amenities' => explode(',', $hotel['roomAmenities'])
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

}
