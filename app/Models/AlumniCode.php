<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlumniCode extends Model
{
    use HasFactory;
     protected $connection = "admin";
     protected $table = 'alumnicode_migration';
}
