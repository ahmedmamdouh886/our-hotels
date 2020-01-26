<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OurHotelsTest extends TestCase
{
    /**
     * Test Hotels valid Request Inputs
     *
     * @return void
     */
    public function testHotelsValidRequestInputsTest()
    {
        $response = $this->json('GET', '/api/CrazyHotel', [
                'from_date' => '2020-08-01',
                "to_date" => '2020-08-03',
                "city" => 'cai',
                'adults_number' => 2
        ]);

        $response->assertStatus(200)
                 ->assertJsonFragment([
                    'provider' => 'BestHotels'
                 ]);
    }

    /**
     * Test Hotels Invalid Request Inputs
     *
     * @return void
     */
    public function testHotelsInvalidRequestInputsTest()
    {
        $response = $this->json('GET', '/api/CrazyHotel', [
                'from_date' => '2020-08-01',
                'adults_number' => 2
        ]);

        $response->assertStatus(422);
    }
}
