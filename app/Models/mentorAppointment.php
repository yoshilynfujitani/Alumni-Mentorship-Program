<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class mentorAppointment extends Model
{
    use HasFactory;
    protected $connection = 'mentor';
    protected $table = 'appointmentdetails';
}
