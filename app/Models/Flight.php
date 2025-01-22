<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Flight extends Model
{
    // Assuming you have a 'flights' table or similar

    public static function searchFlights($flightFromCity, $flightToCity, $flightDepartureDate, $flightReturnDate, $passengers)
    {
        // Example query to search flights based on the given parameters
        return self::where('flightFromCity', $flightFromCity)
            ->where('flightToCity', $flightzToCity)
            ->where('flightDepartureDate', '>=', $flightDepartureDate)
            ->where(function ($query) use ($returnDate) {
                if ($returnDate) {
                    $query->where('flightReturnDate', '>=', $flightReturnDate);
                }
            })
            ->where('passengers', '>=', $passengers)
            ->get();
    }
}
