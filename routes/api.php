<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoogleMapsController;

/*
|--------------------------------------------------------------------------
| API Routes for VehicleFinder Project
|--------------------------------------------------------------------------
|
| This file contains all the API routes required for integrating Google Maps
| functionality into the VehicleFinder project. Each route corresponds to a
| specific feature of the Google Maps API.
|
*/

// Route to geocode an address (convert address to latitude/longitude)
Route::post('/geocode', [GoogleMapsController::class, 'geocodeAddress'])
    ->name('api.geocode');

// Route to reverse geocode coordinates (convert latitude/longitude to address)
Route::post('/reverse-geocode', [GoogleMapsController::class, 'reverseGeocodeCoordinates'])
    ->name('api.reverse-geocode');

// Route to calculate directions between two or more locations
Route::post('/directions', [GoogleMapsController::class, 'getDirections'])
    ->name('api.directions');

// Route to search for places near a specific location
Route::post('/place-search', [GoogleMapsController::class, 'searchPlaces'])
    ->name('api.place-search');

// Route to get details about a specific place
Route::post('/place-details', [GoogleMapsController::class, 'getPlaceDetails'])
    ->name('api.place-details');
