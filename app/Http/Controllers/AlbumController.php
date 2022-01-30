<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Artist;
use Illuminate\Http\Request;

class AlbumController extends Controller
{
    public function show()
    {
   //    $album = Album::findOrFail($id);

//       // $album = Album::where('name', 'Kids See Ghosts')->first();
//        print_r($album."<hr>");
//     //   return $album->artists;
//        foreach ($album->artists as $artist)
//            print_r($artist->name."<br>");
        return Album::get();
    }
    public function create(Request $request)
    {
        $request->validate([
            'artist' => 'required',
            'album' => 'required',
            'year' => 'required'
        ]);
       var_dump($request['artist']);
        return "111";
//        $artist = Artist::where('name', $request["artist"])->first();
//       // return Artist::where('name', $request["artist"])->first()->albums->where('name', $request["album"])->first();
//        if (!$artist) {
//            $row = [
//                "name" => $request["artist"]
//            ];
//            $artist = Artist::create($row);
//        }
//     //   $row =
//        $album =Album::create(["name" => $request["album"], "year" => $request["year"]]);
//       return $artist->albums()->syncWithoutDetaching($album);
////        return $album->artists()->syncWithoutDetaching($artist); //attach($artist);
    }

    public function destroy($id)
    {
        return Album::destroy($id);
    }

    public function update(Request $request, $id)
    {
        $album = Album::find($id);
        $album->update([
            "name" => $request["album"],
            "year" => $request["year"]
            ]);
    }
}
