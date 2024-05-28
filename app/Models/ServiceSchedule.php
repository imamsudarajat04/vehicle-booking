<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceSchedule extends Model
{
    use HasFactory;

    protected $fillabe = [
        'vehicle_id',
        'service_date',
        'description',
        'cost'
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }
}