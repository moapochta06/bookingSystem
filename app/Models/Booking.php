<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'estate_object_id',
        'guest_name',
        'from_date',
        'to_date',
        'status'
    ];
    public static function isBooked($estateObjectId, $fromDate, $toDate)
    {
        return self::where('estate_object_id', $estateObjectId)
            ->where(function($q) use ($fromDate, $toDate) {
                $q->whereBetween('from_date', [$fromDate, $toDate])
                ->orWhereBetween('to_date', [$fromDate, $toDate])
                ->orWhere(function($q) use ($fromDate, $toDate) {
                    $q->where('from_date', '<', $fromDate)
                        ->where('to_date', '>', $toDate);
                });
            })->exists();
    }
}

