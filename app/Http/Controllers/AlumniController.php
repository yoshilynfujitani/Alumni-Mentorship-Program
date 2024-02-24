<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AlumniController extends Controller
{
    //
    public function getAlumni(){
        $data = User::where('verified', 0)->get();

        return $data;
    }
}
