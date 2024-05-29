<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'ownership',
        'brand',
        'model',
        'year',
        'plate_number',
        'capacity',
        'office_id',
    ];

    public function fuelConsumptions()
    {
        return $this->hasMany(FuelConsumption::class);
    }

    public function office()
    {
        return $this->belongsTo(Office::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }    

    public function serviceSchedule()
    {
        return $this->hasOne(ServiceSchedule::class);
    }

    public function vehicleUsage()
    {
        return $this->hasMany(VehicleUsage::class);
    }
}
