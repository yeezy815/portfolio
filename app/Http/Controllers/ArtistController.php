<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use Illuminate\Http\Request;

class ArtistController extends Controller
{
    public function show($id)
    {
        $artist = Artist::find($id);
       // var_dump($artist);
        foreach ($artist->albums as $album)
            print_r($album->name."<br>");
        return "1222";
    }
}
