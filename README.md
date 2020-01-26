## Introduction

OurHotels is a hotel search solution that look into many providers and display results from
all the available hotels.

## Installation

### Prerequisites

* You must have PHP 7 installed. 
* You must have Composer installed.

### Step 1

Cloning this repository

```bash
git clone https://github.com/ahmedmamdouh886/our-hotels.git
cd our-hotels
composer install
php artisan serve
``` 

### Step 2

* visit: http://localhost:8000/api/{endpoint}?from_date=2020-08-01&to_date=2020-08-03&city=cai&adults_number=2

## Structure

* app/API/*.php
* app/APIProviders/*.php
* app/Services/*.php
* app/Providers/HotelsAggregatorServiceProvider.php
* tests/Features/OurHotelsTest.php
* routes/api.php
* app/Http/Controller/API/OurHotelController.php

