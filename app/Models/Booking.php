<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillabel = [
        'employee_id',
        'vehicle_id',
        'booking_date',
        'usage_start',
        'usage_end',
        'status',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function approvals()
    {
        return $this->hasMany(Approval::class);
    }
}
