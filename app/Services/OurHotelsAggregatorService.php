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
     * @param APIProviderInterface injection (DI).
     */
    public function __construct(TopHotelsrovider $topHotelsrovider, BestHotelsProvider $bestHotelsProvider)
    {
        $this->topHotelsrovider = $topHotelsrovider;
        $this->bestHotelsProvider = $bestHotelsProvider;
    }

    public function search(string $from_date, string $to_date, string $city, int $adults_number) 
    {
        $bestHotelsProviderData = $this->bestHotelsProvider->getHotels($from_date, $to_date, $city, $adults_number);
        
        $topHotelsProviderData = $this->topHotelsrovider->getHotels($from_date, $to_date, $city, $adults_number);
        // dd($topHotelsProviderData, $bestHotelsProviderData);
        // $mergedHotelsProvidersData = $this->mergeProvidersData($bestHotelsProviderData, $topHotelsProviderData);
        $mergedHotelsProvidersData = array_merge($bestHotelsProviderData, $topHotelsProviderData);
        // dd($mergedHotelsProvidersData);
        $sortedData = $this->sortDescByRate($mergedHotelsProvidersData);

        $response = $this->removwRate($sortedData);

        return $response;
    }

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

    private function removwRate(array $hotels) {

    	$allHotels = [];
    	foreach ($hotels as $hotel) {
            unset($hotel['rate']);

            $allHotels[] = $hotel;
        }

        return $allHotels;

    }
}