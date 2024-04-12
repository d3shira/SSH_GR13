<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointments extends Model
{
    use HasFactory;
    protected $primaryKey = 'Appointment_id';
    protected $fillable = [
        'Time',
        'Full_name',
        'Email',
        'Address_id',
        'Phone',
        'Message',
        'Create_at',
        'Updated_at',
    ];

}
