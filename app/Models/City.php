<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Services\BusApiService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class City extends Model
{
    use HasFactory;

    protected $table = 'cities';

    protected $fillable = [
        'state_id',
        'city_name',
        'code'
    ];

    /**
     * Fetch all cities from both local database and third-party API
     */
    public static function fetchAllCities(): Collection
    {
        try {
            // Get local cities
            $localCities = self::all();
            
            // Fetch from API
            $apiCities = self::fetchAndSaveCitiesFromApi();
            
            // Merge local and API cities, removing duplicates based on city code
            $allCities = $localCities->concat($apiCities)->unique('code');
            
            return $allCities;
        } catch (\Exception $e) {
            Log::error('Error fetching cities', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * Fetch city list from API and store new cities in the local database
     */
    public static function fetchAndSaveCitiesFromApi(): Collection
    {
        try {
            $busApiService = new BusApiService();
            $apiCityList = $busApiService->fetchCityList();

            if (empty($apiCityList)) {
                return collect([]);
            }

            $newCities = [];
            $now = now();

            DB::beginTransaction();

            foreach ($apiCityList as $cityData) {
                if (!isset($cityData['CityId']) || !isset($cityData['CityName'])) {
                    continue;
                }

                // Check if city exists
                $existingCity = self::where('code', $cityData['CityId'])->first();

                if ($existingCity) {
                    // Update existing city if name has changed (case insensitive)
                    if (strcasecmp(trim($cityData['CityName']), $existingCity->city_name) !== 0) {
                        $existingCity->update([
                            'city_name' => trim($cityData['CityName']),
                            'updated_at' => $now
                        ]);
                    }
                    $newCities[] = $existingCity;
                } else {
                    // Create new city
                    $city = self::create([
                        'city_name' => trim($cityData['CityName']),
                        'code' => $cityData['CityId'],
                        'state_id' => null,
                        'created_at' => $now,
                        'updated_at' => $now
                    ]);
                    $newCities[] = $city;
                }
            }

            DB::commit();
            return collect($newCities);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('City Fetch API Error', ['message' => $e->getMessage()]);
            throw $e;
        }
    }
}
