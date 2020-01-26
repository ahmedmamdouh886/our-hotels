<?php

namespace App\Services;

use App\Services\Interfaces\OurHotelsAggregatorInterface as OurHotelsAggregatorInterface;
use App\APIProviders\TopHotelsAPIProvider as TopHotelsrovider;
use App\APIProviders\BestHotelsAPIProvider as BestHotelsProvider;

class OurHotelsAggregatorService implements OurHotelsAggregatorInterface
{
	/**
     * Constructor function.
     *
     * @param TopHotelsrovider and BestHotelsProvider injection (DI).
     */
    public function __construct(TopHotelsrovider $topHotelsrovider, BestHotelsProvider $bestHotelsProvider)
    {
        $this->topHotelsrovider = $topHotelsrovider;
        $this->bestHotelsProvider = $bestHotelsProvider;
    }

    /**
     * Search for hotels.
     *
     * @param string $from_date
     * @param string $to_date
     * @param string $city
     * @param string $adults_number
     * @return array
     */
    public function search(string $from_date, string $to_date, string $city, int $adults_number) 
    {
        $bestHotelsProviderData = $this->bestHotelsProvider->getHotels($from_date, $to_date, $city, $adults_number);
        
        $topHotelsProviderData = $this->topHotelsrovider->getHotels($from_date, $to_date, $city, $adults_number);
       
        $mergedHotelsProvidersData = array_merge($bestHotelsProviderData, $topHotelsProviderData);
        
        $sortedData = $this->sortDescByRate($mergedHotelsProvidersData);

        $response = $this->removwRate($sortedData);

        return $response;
    }

     /**
     * Sort hotels desc order by rate
     *
     * @param array $hotels
     * @return array
     */
    private function sortDescByRate(array $hotels): array
    {
    	$allHotels = $hotels;
    	uasort($allHotels, function($first, $second) {
    		if ($first == $second) {
    			return 0;
    		}

			return ($first > $second) ? 1 : -1;
    	});
    	
    	return $allHotels;
    }

     /**
     * Remove rate item from hotels.
     *
     * @param array $hotels
     * @return array
     */
    private function removwRate(array $hotels) {

    	$allHotels = [];
    	foreach ($hotels as $hotel) {
            unset($hotel['rate']);

            $allHotels[] = $hotel;
        }

        return $allHotels;

    }
}