<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class GoogleMapsController extends Controller
{
    /**
     * Geocode an address (convert address to latitude/longitude).
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function geocodeAddress(Request $request)
    {
        // Validate the request
        $request->validate([
            'address' => 'required|string',
        ]);

        $address = $request->input('address');
        $apiKey = config('services.google_maps.api_key');

        $client = new Client();
        try {
            $response = $client->get("https://maps.googleapis.com/maps/api/geocode/json", [
                'query' => [
                    'address' => $address,
                    'key' => $apiKey,
                ],
            ]);

            return response()->json(json_decode($response->getBody(), true));
        } catch (\Exception $e) {
            return response()->json(['error' => 'Unable to geocode address', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Reverse geocode coordinates (convert latitude/longitude to address).
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function reverseGeocodeCoordinates(Request $request)
    {
        // Validate the request
        $request->validate([
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
        ]);

        $lat = $request->input('lat');
        $lng = $request->input('lng');
        $apiKey = config('services.google_maps.api_key');

        $client = new Client();
        try {
            $response = $client->get("https://maps.googleapis.com/maps/api/geocode/json", [
                'query' => [
                    'latlng' => "$lat,$lng",
                    'key' => $apiKey,
                ],
            ]);

            return response()->json(json_decode($response->getBody(), true));
        } catch (\Exception $e) {
            return response()->json(['error' => 'Unable to reverse geocode coordinates', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Calculate directions between two or more locations.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDirections(Request $request)
    {
        // Validate the request
        $request->validate([
            'origin' => 'required|string',
            'destination' => 'required|string',
        ]);

        $origin = $request->input('origin');
        $destination = $request->input('destination');
        $apiKey = config('services.google_maps.api_key');

        $client = new Client();
        try {
            $response = $client->get("https://maps.googleapis.com/maps/api/directions/json", [
                'query' => [
                    'origin' => $origin,
                    'destination' => $destination,
                    'key' => $apiKey,
                ],
            ]);

            return response()->json(json_decode($response->getBody(), true));
        } catch (\Exception $e) {
            return response()->json(['error' => 'Unable to calculate directions', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Search for places near a specific location.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchPlaces(Request $request)
    {
        // Validate the request
        $request->validate([
            'location' => 'required|string', // Format: "lat,lng"
            'radius' => 'required|integer', // In meters
            'type' => 'nullable|string', // e.g., "restaurant", "gas_station"
        ]);

        $location = $request->input('location');
        $radius = $request->input('radius');
        $type = $request->input('type');
        $apiKey = config('services.google_maps.api_key');

        $client = new Client();
        try {
            $response = $client->get("https://maps.googleapis.com/maps/api/place/nearbysearch/json", [
                'query' => array_filter([
                    'location' => $location,
                    'radius' => $radius,
                    'type' => $type,
                    'key' => $apiKey,
                ]),
            ]);

            return response()->json(json_decode($response->getBody(), true));
        } catch (\Exception $e) {
            return response()->json(['error' => 'Unable to search places', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Get details about a specific place.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPlaceDetails(Request $request)
    {
        // Validate the request
        $request->validate([
            'place_id' => 'required|string',
        ]);

        $placeId = $request->input('place_id');
        $apiKey = config('services.google_maps.api_key');

        $client = new Client();
        try {
            $response = $client->get("https://maps.googleapis.com/maps/api/place/details/json", [
                'query' => [
                    'place_id' => $placeId,
                    'key' => $apiKey,
                ],
            ]);

            return response()->json(json_decode($response->getBody(), true));
        } catch (\Exception $e) {
            return response()->json(['error' => 'Unable to get place details', 'message' => $e->getMessage()], 500);
        }
    }
}
