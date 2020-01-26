<?php

namespace App\API;

use App\API\Interfaces\BestHotelsAPIInterface as BestHotelsAPIInterface;
use Carbon\Carbon as Carbon;

class BestHotelsAPI implements BestHotelsAPIInterface
{

   /**
     * Filter Hotels data.
     *
     * @param string $formDate
     * @param string $toDate
     * @param string $city
     * @param int $numberOfAdults
     * @return array $hotels
    */
   public function search(
   	string $formDate, 
   	string $toDate, 
   	string $city, 
   	int $numberOfAdults
   ) {
        $filteredHotels = [];
        $bestHotelData = $this->getHotels()['data'];
        foreach ($bestHotelData['hotels'] as $key => $hotel) {
        	if ($this->filterHotel($hotel, $formDate, $toDate, $city, $numberOfAdults)) {
        		$filteredHotels[] = $this->formatHotel($hotel);
        	}
        }

        return $filteredHotels;
   }

    /**
     * Format single hotel response.
     *
     * @param array $from
     * @return array $formattedHotel
    */
   private function formatHotel(array $hotel): array
   {
        $formattedHotel = [
          'hotel' => $hotel['hotel'], 
          'hotelRate' => $hotel['hotelRate'], 
          'hotelFare' => $this->calculateTotalFare($hotel['hotelFare'], $hotel['from'], $hotel['to']),
          'roomAmenities' => $hotel['roomAmenities']
        ];

        return $formattedHotel;
   }

    /**
     * Calculate total fare for a single hotel.
     *
     * @param string $formDate
     * @param string $toDate
     * @return float
    */
   private function calculateTotalFare(float $price, string $formDate, string $toDate)
   {
        return round($this->calculateReservationDays($formDate, $toDate) * $price, 2);
   }

   /**
     * Calculate reservation days.
     *
     * @param string $formDate
     * @param string $toDate
     * @return int
    */
   private function calculateReservationDays(string $formDate, string $toDate)
   {
        $from = Carbon::parse($formDate);
        $to = Carbon::parse($toDate);

        return (int) $from->diffInDays($to);
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
   	string $fromDate, 
   	string $toDate, 
   	string $city, 
   	int $numberOfAdults
   ) {
   		return (bool) $this->checkAvailability($fromDate, $toDate, $hotel['from'], $hotel['to']) && $this->filterCityCode($hotel['city'], $city) && $this->filterAdultCount($hotel['adults_count'], $numberOfAdults);
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
   	string $fromDate, 
   	string $toDate, 
   	string $hotelFromDate, 
   	string $hotelToDate
   ) {
   		return (bool) ( ($this->formatDate($fromDate) >= $this->formatDate($hotelFromDate) && $this->formatDate($fromDate) <= $this->formatDate($hotelToDate)) && ($this->formatDate($toDate) <= $this->formatDate($hotelToDate) && $this->formatDate($toDate) >= $this->formatDate($hotelFromDate)) );
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
     * @return boolean
    */
   private function filterAdultCount(int $hotelAdultsCount, int $adultsCount)
   {
   		return (bool) ($hotelAdultsCount == $adultsCount);
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
          	'hotel' => 'Best hotel 1',
          	'hotelRate' => 3.5,
          	'from' => '2020-08-01',
          	'to' => '2020-08-03',
          	'hotelFare' => 10.00,
          	'city' => 'CAI',
          	'adults_count' => 1,
          	'roomAmenities' => 'Wi-Fi,Sea view,Breakfast,Air condition,Hammock,CD player',
          	],
            [
            'hotel' => 'Best hotel 11',
            'hotelRate' => 3.5,
            'from' => '2020-08-01',
            'to' => '2020-08-03',
            'hotelFare' => 10.00,
            'city' => 'CAI',
            'adults_count' => 2,
            'roomAmenities' => 'Wi-Fi,Sea view,Breakfast,Air condition,Hammock,CD player',
            ],
          	[
          	'hotel' => 'Best hotel 2',
          	'hotelRate' => 3.7,
          	'from' => '2020-07-04',
          	'to' => '2020-07-06',
          	'hotelFare' => 12.00,
          	'city' => 'ESF',
          	'adults_count' => 2,
          	'roomAmenities' => 'Wi-Fi,sea view,Breakfast,Air condition,CD player,Coffee Maker',
          	],
          	[
          	'hotel' => 'Best hotel 3',
          	'hotelRate' => 4.1,
          	'from' => '2020-07-07',
          	'to' => '2020-07-09',
          	'hotelFare' => 13.00,
          	'city' => 'AUH',
          	'adults_count' => 1,
          	'roomAmenities' => 'Wi-Fi,City view,Breakfast,Air condition,Hammock,CD player',
          	],
          	[
          	'hotel' => 'Best hotel 4',
          	'hotelRate' => 2.8,
          	'from' => '2020-07-10',
          	'to' => '2020-07-12',
          	'hotelFare' => 14.00,
          	'city' => 'CAI',
          	'adults_count' => 2,
          	'roomAmenities' => 'Wi-Fi,Pool view,Breakfast,Air condition,Hammock,CD player',
          	],
          	[
          	'hotel' => 'Best hotel 5',
          	'hotelRate' => 4.8,
          	'from' => '2020-07-13',
          	'to' => '2020-07-15',
          	'hotelFare' => 15.00,
          	'city' => 'ESF',
          	'adults_count' => 2,
          	'roomAmenities' => 'Wi-Fi,Pool view,Breakfast,Hammock,CD player,Hair dryer',
          	],
          	[
          	'hotel' => 'Best hotel 6',
          	'hotelRate' => 1.2,
          	'from' => '2020-07-16',
          	'to' => '2020-07-18',
          	'hotelFare' => 16.00,
          	'city' => 'AUH',
          	'adults_count' => 1,
          	'roomAmenities' => 'Wi-Fi,Sea view,Breakfast,Air condition,Hammock,CD player,Hair dryer',
          	],
          	[
          	'hotel' => 'Best hotel 7',
          	'hotelRate' => 4.3,
          	'from' => '2020-07-19',
          	'to' => '2020-07-21',
          	'hotelFare' => 17.00,
          	'city' => 'CAI',
          	'adults_count' => 1,
          	'roomAmenities' => 'Wi-Fi,City view,Breakfast,Air condition,Hammock,CD player,Hair dryer',
          	],
          	[
          	'hotel' => 'Best hotel 8',
          	'hotelRate' => 3.9,
          	'from' => '2020-07-22',
          	'to' => '2020-07-24',
          	'hotelFare' => 18.00,
          	'city' => 'ESF',
          	'adults_count' => 2,
          	'roomAmenities' => 'Wi-Fi,Sea view,Breakfast,Air condition,Hammock,CD player,LED TV,Locker',
          	],
          	[
          	'hotel' => 'Best hotel 9',
          	'hotelRate' => 3.7,
          	'from' => '2020-07-25',
          	'to' => '2020-07-27',
          	'hotelFare' => 19.00,
          	'city' => 'CAI',
          	'adults_count' => 2,
          	'roomAmenities' => 'Wi-Fi,Pool view,Breakfast,Air condition,Hammock,CD player,LED TV,Locker',
          	],
          	[
          	'hotel' => 'Best hotel 10',
          	'hotelRate' => 3.5,
          	'from' => '2020-07-28',
          	'to' => '2020-07-31',
          	'hotelFare' => 20.00,
          	'city' => 'AUH',
          	'adults_count' => 1,
          	'roomAmenities' => 'Wi-Fi,Pool view,Breakfast,Air condition,Hammock,LED TV,Locker',
          	]
          ]
        ]
      ];
   }
}
