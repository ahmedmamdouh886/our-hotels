<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\SearchRequest as SearchRequest;
use App\Services\Interfaces\OurHotelsAggregatorInterface as OurHotelsAggregatorInterface;

class OurHotelsController extends Controller
{

    /**
     * Constructor function.
     *
     * @param OurHotelsAggregatorInterface injection (DI).
     */
    public function __construct(OurHotelsAggregatorInterface $hotelsAggregator)
    {
        $this->hotelsAggregator = $hotelsAggregator;
    }
    
    /**
     * Search hotels.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(SearchRequest $request)
    {
        $hotels = $this->hotelsAggregator->search($request->input('from_date'), 
            $request->input('to_date'), 
            $request->input('city'), 
            $request->input('adults_number'));

        return response()->json(['data' => ['hotels' => $hotels], 'total_count' => count($hotels)], 200);
    }
}
