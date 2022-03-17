<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use Illuminate\Http\Request;

class ArtistController extends Controller
{
    public function show($id)
    {
        return  Artist::with('albums')->find($id);
    }
}
