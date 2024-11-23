// app/Models/FestivalRegion.php
class FestivalRegion extends Model 
{
    protected $fillable = [
        'name', 'image', 'festivals', 'significance', 'best_places'
    ];

    // Optional: Cast JSON columns
    protected $casts = [
        'festivals' => 'array',
        'best_places' => 'array'
    ];
}



class FestivalRegion extends Model
{
    protected $fillable = ['name', 'image', 'festivals', 'significance', 'best_places'];

    // If festivals is stored as a JSON column, use a mutator
    public function getFestivalsAttribute($value)
    {
        return json_decode($value, true);
    }

    public function getBestPlacesAttribute($value)
    {
        return json_decode($value, true);
    }
}