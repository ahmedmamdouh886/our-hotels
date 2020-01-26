<?php

namespace App\API;

use App\API\Interfaces\TopHotelsAPIInterface as TopHotelsAPIInterface;
use Carbon\Carbon as Carbon;

class TopHotelsAPI implements TopHotelsAPIInterface
{
  
   /**
     * Hotels search.
     *
     * @param string $from
     * @param string $to
     * @param string $city
     * @param int $adultsCount
     * @return array $hotels
    */
   public function search(
   	string $from, 
   	string $to, 
   	string $city, 
   	int $adultsCount
   ) {
        $filteredHotels = [];
        $topHotelData = $this->getHotels()['data'];
        foreach ($topHotelData['hotels'] as $key => $hotel) {
        	if ($this->filterHotel($hotel, $from, $to, $city, $adultsCount)) {
        		$filteredHotels[] = $this->formatHotel($hotel);
        	}
        }

        return $filteredHotels;
   }

   /**
     * Get test hotels.
     * @return array.
    */
   private function getHotels(): array
   {
       return [

        'data' => [

          'hotels' => [
            [
            'hotelName' => 'Top hotel 1',
            'rate' => '***',
            'city' => 'CAI',
            'price' => 20.00,
            'from' => '2020-07-01',
            'to' => '2020-07-03',
            'adults_count' => 1,
            'amenities' => 'Wi-Fi,Sea view,Breakfast,Air condition,Hammock,CD player',
            ],
            [
            'hotelName' => 'Top hotel 11',
            'rate' => '***',
            'city' => 'CAI',
            'price' => 10.00,
            'from' => '2020-08-01',
            'to' => '2020-08-03',
            'adults_count' => 2,
            'amenities' => 'Wi-Fi,Sea view,Breakfast,Air condition,Hammock,CD player',
            ],
            [
            'hotelName' => 'Top hotel 2',
            'rate' => '**',
            'price' => 30.00,
            'city' => 'AUH',
            'from' => '2020-07-04',
            'to' => '2020-07-06',
            'adults_count' => 2,
            'amenities' => 'Wi-Fi,City view,Breakfast,Air condition,Hammock,CD player',
            ],
            [
            'hotelName' => 'Top hotel 3',
            'rate' => '***',
            'price' => 40.00,
            'city' => 'ASW',
            'from' => '2020-07-07',
            'adults_count' => 2,
            'to' => '2020-07-09',
            'amenities' => 'Wi-Fi,sea view,Breakfast,Air condition,CD player,Coffee Maker',
            ],
            [
            'hotelName' => 'Top hotel 4',
            'rate' => '****',
            'price' => 50.00,
            'city' => 'CAI',
            'adults_count' => 1,
            'from' => '2020-07-10',
            'to' => '2020-07-12',
            'amenities' => 'Wi-Fi,sea view,Breakfast,Air condition,Hammock',
            ],
            [
            'hotelName' => 'Top hotel 5',
            'rate' => '*****',
            'price' => 60.00,
            'city' => 'ASW',
            'adults_count' => 1,
            'from' => '2020-07-13',
            'to' => '2020-07-15',
            'amenities' => 'Wi-Fi,Pool view,Breakfast,Air condition,Hammock,CD player',
            ],
            [
            'hotelName' => 'Top hotel 6',
            'rate' => '***',
            'price' => 65.00,
            'city' => 'AUH',
            'adults_count' => 2,
            'from' => '2020-07-16',
            'to' => '2020-07-18',
            'amenities' => 'Wi-Fi,Pool view,Breakfast,Hammock,CD player,Hair dryer',
            ],
            [
            'hotelName' => 'Top hotel 7',
            'rate' => '*',
            'price' => 70.00,
            'city' => 'ASW',
            'adults_count' => 2,
            'from' => '2020-07-19',
            'to' => '2020-07-21',
            'amenities' => 'Wi-Fi,Sea view,Breakfast,Air condition,Hammock,CD player,Hair dryer',
            ],
            [
            'hotelName' => 'Top hotel 8',
            'rate' => '*',
            'price' => 75.00,
            'city' => 'CAI',
            'adults_count' => 1,
            'from' => '2020-07-22',
            'to' => '2020-07-24',
            'amenities' => 'Wi-Fi,City view,Breakfast,Air condition,Hammock,CD player,Hair dryer',
            ],
            [
            'hotelName' => 'Top hotel 9',
            'rate' => '***',
            'price' => 80.00,
            'city' => 'ASW',
            'adults_count' => 1,
            'from' => '2020-07-25',
            'to' => '2020-07-27',
            'amenities' => 'Wi-Fi,Sea view,Breakfast,Air condition,Hammock,CD player,LED TV,Locker',
            ],
            [
            'hotelName' => 'Top hotel 10',
            'rate' => '***',
            'price' => 85.00,
            'city' => 'AUH',
            'adults_count' => 2,
            'from' => '2020-07-28',
            'to' => '2020-07-30',
            'amenities' => 'Wi-Fi,Pool view,Breakfast,Air condition,Hammock,CD player,LED TV,Locker',
            ]
          ]

        ]

      ];
   }

   /**
     * Filter single hotel.
     *
     * @param array $hotel
     * @param string $from
     * @param string $to
     * @param string $city
     * @return boolean
    */
   private function filterHotel(
    array $hotel, 
    string $from, 
    string $to, 
    string $city, 
    int $adultsCount
   ) {
      return (bool) $this->checkAvailability($from, $to, $hotel['from'], $hotel['to']) && $this->filterCityCode($hotel['city'], $city) && $this->filterAdultCount($hotel['adults_count'], $adultsCount);
   }

   /**
     * Check hotels availability.
     *
     * @param array $from
     * @param string $to
     * @param string $hotelFrom
     * @param string $hotelTo
     * @return boolean
    */
   private function checkAvailability(
    string $from, 
    string $to, 
    string $hotelFrom, 
    string $hotelTo
   ) {
      return (bool) ( ($this->formatDate($from) >= $this->formatDate($hotelFrom) && $this->formatDate($from) <= $this->formatDate($hotelTo)) && ($this->formatDate($to) <= $this->formatDate($hotelTo) && $this->formatDate($to) >= $this->formatDate($hotelFrom)) );
   }

   /**
     * Format single date as iso local date.
     *
     * @param string $date
     * @return string
    */
   private function formatDate(string $date)
   {
      return Carbon::parse($date)->format('Y-m-d');
   }

   /**
     * Filter city code.
     *
     * @param string $hotelCityCode
     * @param string $cityCode
     * @return bool
    */
   private function filterCityCode(string $hotelCityCode, string $cityCode)
   {
      return (bool) (strtolower($hotelCityCode) == strtolower($cityCode));
   }

   /**
     * Check hotels availability.
     *
     * @param int $hotelCapacity
     * @param int $adultsCount
     * @return bool
    */
   private function filterAdultCount(int $hotelAdultCount, int $adultsCount)
   {
      return (bool) ($hotelAdultCount == $adultsCount);
   }

   /**
     * Format single hotel response.
     *
     * @param array $hotels
     * @return array $formattedHotel
    */
   private function formatHotel(array $hotel): array
   {
        $formattedHotel = [
          'hotelName' => $hotel['hotelName'], 
          'rate' => $hotel['rate'], 
          'price' => $hotel['price'],
          'amenities' => explode(',', $hotel['amenities'])
        ];

        return $formattedHotel;
   }
}
