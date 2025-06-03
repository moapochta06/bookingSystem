<?php

namespace App\Models;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Model;

class EstateObject extends Model
{
    protected $table = 'estate_objects';

    protected $fillable = [
        'title',
        'city',
        'street',
        'house_number',
        'apartment_number',
        'rooms_count',
        'guests_count',
        'area',
        'price',
        'description',
        'image',
        'pets_allowed',
        'free_cleaning',
        'air_conditioner',
        'wifi',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
    
    public static function storeImage($image)
    {
        $path = $image->store('images/estate', 'public');
        return $path;
    }

}

