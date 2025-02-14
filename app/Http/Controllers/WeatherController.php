<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\FavoriteLocation;

class WeatherController extends Controller
{
    public function index(Request $request)
    {
        $location = $request->input('location');
        $locations = FavoriteLocation::all();
        $sessionWeather = session('weather');
        
        // If we have weather data in session, use that
        if ($sessionWeather) {
            session()->forget('weather');
            return view('index', [
                'weather' => $sessionWeather,
                'locations' => $locations,
                'showAddForm' => false
            ]);
        }
        
        if (!$location) {
            return view('index', [
                'locations' => $locations,
                'showAddForm' => false
            ])->with('error', 'Please enter a location.');
        }

        // Get location data
        $locationData = $this->getLocationData($location);
        if (!$locationData) {
            return view('index', [
                'locations' => $locations,
                'showAddForm' => false
            ])->with('error', 'Location not found.');
        }

        // Get weather data
        $weatherData = $this->getWeatherData($locationData['lat'], $locationData['lon']);
        if (isset($weatherData['error'])) {
            return view('index', [
                'locations' => $locations,
                'showAddForm' => false
            ])->with('error', $weatherData['error']);
        }

        // Prepare weather info with location data
        $weatherInfo = [
            'location' => $location,
            'current' => $this->mapCurrentWeather($weatherData['current']),
            'daily' => $this->mapDailyForecast($weatherData['daily']),
            'favorite' => false,
            'location_name' => $locationData['name'],
            'latitude' => $locationData['lat'],
            'longitude' => $locationData['lon']
        ];

        // Check if location is favorite
        $favoriteLocation = FavoriteLocation::where('city', $location)->first();
        if ($favoriteLocation) {
            $weatherInfo['favorite'] = true;
            $weatherInfo['location_name'] = $favoriteLocation->name;
            $weatherInfo['latitude'] = $favoriteLocation->latitude;
            $weatherInfo['longitude'] = $favoriteLocation->longitude;
        }

        return view('index', [
            'weather' => $weatherInfo,
            'locations' => $locations,
            'showAddForm' => false,
            'selectedLocation' => $location
        ]);
    }


    public function showAddLocation()
    {
        $locations = FavoriteLocation::all();
        return view('index', [
            'locations' => $locations,
            'showAddForm' => true
        ]);
    }

    private function getWeatherData($latitude, $longitude)
    {
        try {
            $response = Http::get("https://api.open-meteo.com/v1/forecast", [
                'latitude' => $latitude,
                'longitude' => $longitude,
                'current' => 'temperature_2m,relative_humidity_2m,apparent_temperature,wind_speed_10m,rain,weather_code,is_day',
                'daily' => 'weather_code,temperature_2m_max,temperature_2m_min,uv_index_max,relative_humidity_2m_max',
                'timezone' => 'auto',
                'forecast_days' => 7
            ]);

            if (!$response->successful()) {
                return ['error' => 'Failed to fetch weather data'];
            }

            return $response->json();
        } catch (\Exception $e) {
            return ['error' => 'An error occurred while fetching weather data'];
        }
    }

    private function getLocationData($location)
    {
        $response = Http::get('https://geocoding-api.open-meteo.com/v1/search', [
            'name' => $location,
            'count' => 1,
            'language' => 'en',
            'format' => 'json',
        ]);

        $data = $response->json();

        if (!isset($data['results'][0])) {
            return null;
        }

        return [
            'name' => $data['results'][0]['name'],
            'lat' => $data['results'][0]['latitude'],
            'lon' => $data['results'][0]['longitude'],
        ];
    }

    private function mapCurrentWeather($current)
    {
        $weatherCodes = $this->getWeatherCodes();
        $code = $current['weather_code'] ?? 0; // Default to clear sky (0) if no weather code
        $isDay = !empty($current['is_day']); // Get the weather condition
        
        return [
            'temperature_2m' => $current['temperature_2m'] ?? 'N/A',
            'relative_humidity_2m' => $current['relative_humidity_2m'] ?? 'N/A',
            'wind_speed_10m' => $current['wind_speed_10m'] ?? 'N/A',
            'apparent_temperature' => $current['apparent_temperature'] ?? 'N/A',
            'rain' => $current['rain'] ?? 'N/A',
            'weather_condition' => [
                'name' => $weatherCodes[$code]['name'] ?? 'Unknown',
                'icons' => $weatherCodes[$code]['icons'][$isDay ? 'day' : 'night'] ?? 'clear.svg', 
            ],
        ];
    }


    private function mapDailyForecast($daily)
    {
        $weatherCodes = $this->getWeatherCodes();
        $result = [];

        for ($i = 0; $i < count($daily['time']); $i++) {
            $code = $daily['weather_code'][$i];
            $weatherCondition = $weatherCodes[$code] ?? $weatherCodes[0]; // Default to clear sky if code not found

            $result[] = [
                'time' => $daily['time'][$i],
                'weather_condition' => $weatherCondition,
                'temperature_2m_max' => $daily['temperature_2m_max'][$i] ?? 'N/A',
                'temperature_2m_min' => $daily['temperature_2m_min'][$i] ?? 'N/A',
                'uv_index_max' => $daily['uv_index_max'][$i] ?? 'N/A',
                'relative_humidity_2m_max' => $daily['relative_humidity_2m_max'][$i] ?? 'N/A'
            ];
        }

        return $result;
    }

    private function getWeatherCodes()
    {
        return [
            0 => ['name' => "Clear Sky", 'icons' => ['day' => 'clear.svg', 'night' => 'clear-night.svg']],
            1 => ['name' => "Mainly Clear", 'icons' => ['day' => 'clear.svg', 'night' => 'clear-night.svg']],
            2 => ['name' => "Partly Cloudy", 'icons' => ['day' => 'partly-cloudy.svg', 'night' => 'partly-cloudy-night.svg']],
            3 => ['name' => "Overcast", 'icons' => ['day' => 'overcast.svg', 'night' => 'overcast.svg']],
            45 => ['name' => "Fog", 'icons' => ['day' => 'fog.svg', 'night' => 'fog-night.svg']],
            48 => ['name' => "Rime Fog", 'icons' => ['day' => 'rime-fog.svg', 'night' => 'rime-fog.svg']],
            51 => ['name' => "Light Drizzle", 'icons' => ['day' => 'light-drizzle.svg', 'night' => 'light-drizzle.svg']],
            53 => ['name' => "Moderate Drizzle", 'icons' => ['day' => 'drizzle.svg', 'night' => 'drizzle.svg']],
            55 => ['name' => "Heavy Drizzle", 'icons' => ['day' => 'heavy-drizzle.svg', 'night' => 'heavy-drizzle.svg']],
            56 => ['name' => "Light Freezing Drizzle", 'icons' => ['day' => 'drizzle.svg', 'night' => 'drizzle.svg']],
            57 => ['name' => "Dense Freezing Drizzle", 'icons' => ['day' => 'heavy-drizzle.svg', 'night' => 'heavy-drizzle.svg']],
            61 => ['name' => "Slight Rain", 'icons' => ['day' => 'slight-rain.svg', 'night' => 'slight-rain-night.svg']],
            63 => ['name' => "Moderate Rain", 'icons' => ['day' => 'rain.svg', 'night' => 'rain.svg']],
            65 => ['name' => "Heavy Rain", 'icons' => ['day' => 'heavy-rain.svg', 'night' => 'heavy-rain.svg']],
            66 => ['name' => "Light Freezing Rain", 'icons' => ['day' => 'rain.svg', 'night' => 'rain.svg']],
            67 => ['name' => "Heavy Freezing Rain", 'icons' => ['day' => 'heavy-rain.svg', 'night' => 'heavy-rain.svg']],
            71 => ['name' => "Slight snowfall", 'icons' => ['day' => 'light-snow.svg', 'night' => 'light-snow-night.svg']],
            73 => ['name' => "Moderate snowfall", 'icons' => ['day' => 'snow.svg', 'night' => 'snow.svg']],
            75 => ['name' => "Heavy snowfall", 'icons' => ['day' => 'heavy-snow.svg', 'night' => 'heavy-snow.svg']],
            77 => ['name' => "Snow Grains", 'icons' => ['day' => 'snow-grains.svg', 'night' => 'snow-grains.svg']],
            80 => ['name' => "Slight Rain Showers", 'icons' => ['day' => 'slight-rain-showers.svg', 'night' => 'slight-rain-showers-night.svg']],
            81 => ['name' => "Moderate Rain Showers", 'icons' => ['day' => 'rain-showers.svg', 'night' => 'rain-showers.svg']],
            82 => ['name' => "Violent Rain Showers", 'icons' => ['day' => 'heavy-rain-showers.svg', 'night' => 'heavy-rain-showers.svg']],
            85 => ['name' => "Light Snow Showers", 'icons' => ['day' => 'light-snow-showers.svg', 'night' => 'light-snow-showers.svg']],
            86 => ['name' => "Heavy Snow Showers", 'icons' => ['day' => 'heavy-snow-showers.svg', 'night' => 'heavy-snow-showers.svg']],
            95 => ['name' => "Thunderstorm", 'icons' => ['day' => 'thunderstorm.svg', 'night' => 'thunderstorm.svg']],
            96 => ['name' => "Slight Hailstorm", 'icons' => ['day' => 'hail.svg', 'night' => 'hail.svg']],
            99 => ['name' => "Heavy Hailstorm", 'icons' => ['day' => 'heavy-hail.svg', 'night' => 'heavy-hail.svg']],
        ];
    }

    public function saveFavorite(Request $request)
    {
        try {
            // Check if location already exists
            $exists = FavoriteLocation::where('city', $request->city)->exists();
            
            if ($exists) {
                return redirect()->back()->with('error', 'Location is already in favorites!');
            }

            // Create new favorite location
            FavoriteLocation::create([
                'name' => $request->name,
                'city' => $request->city,
                'country' => $request->country ?? '',
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'notes' => ''
            ]);

            return redirect()->back()->with('success', 'Location added to favorites!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to save location.');
        }
    }


}
