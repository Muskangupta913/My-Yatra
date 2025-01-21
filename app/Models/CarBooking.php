namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarBooking extends Model
{
    use HasFactory;

    protected $table = 'car_bookings'; // Table name

    protected $fillable = [
        'customer_name',
        'phone',
        'email',
        'total_price',
        'booking_status'
    ];

    // Define any other relationships or methods as needed
}
