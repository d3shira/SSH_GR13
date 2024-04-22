<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointments extends Model
{
    use HasFactory;
    protected $primaryKey = 'Appointment_id';
    protected $fillable = [
        'Property_id',
        'Time',
        'Full_name',
        'Email',
        'Phone',
        'Message',
    ];

    public function properties()
    {
        return $this->belongsTo(Properties::class);
    }
}
