<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Artist;
use Illuminate\Http\Request;

class AlbumController extends Controller
{
    public function show(Request $request)
    {
        $request->validate([
            'min_year' => 'integer',
            'max_year' => 'integer',
           'sortBy'   => 'in:year,name,artists',
            'sortorder' => 'in:asc,desc'
        ]);
        $album = new Album();
        if (isset($request["album"]))
            $album = $album->where('name', 'like', '%'.$request["album"].'%');
        if (isset($request["min_year"]))
            $album = $album->where('year', '>=', $request["min_year"]);
        if (isset($request["max_year"]))
            $album = $album->where('year', '<=', $request["max_year"]);

     //   $albums = $album->with('artists')->OrderBy('year')->get();
      //  return $albums;
        $order = $request->sortBy ?? 'year';
        $sortorder = $request->sortorder ?? 'asc';
        return $album->with('artists')->OrderBy($order, $sortorder)->get();
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
        $album = Album::findOrFail($id);
        $artists = [];
        print_r($request->artists);
        foreach ($request->artists as $artist)
        {
            $artists[] = Artist::firstOrCreate([
                'name' => $artist
            ])["id"];
        }
        print_r($artists);
        if ($artists){
            $album->artists()->sync($artists);
        }
     //   print_r($album->with('artists')->get());
        $album->update(["name" => $request->name, "year" => $request->year]);
    }
}
