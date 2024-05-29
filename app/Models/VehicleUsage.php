<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleUsage extends Model
{
    use HasFactory;

    protected $fillable = [
        'vehicle_id',
        'employee_id',
        'status',
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
