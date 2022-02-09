<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Artist;
use Illuminate\Http\Request;

class AlbumController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'min_year' => 'integer',
            'max_year' => 'integer',
           'sortBy'   => 'in:year,name,artists',
            'sortorder' => 'in:asc,desc'
        ]);
//        $artists = [];
//        $request->artists = str_replace('-', ' ', $request->artists);
//        $request->artists = str_replace(';', '', $request->artists);
//        $request->artists = str_replace(',', '', $request->artists);
//        $artists = explode(' ', $request->artists);
//        return $artists;
        $album = new Album();
        if (isset($request["album"]))
            $album = $album->where('name', 'like', '%'.$request["album"].'%');
        if (isset($request["min_year"]))
            $album = $album->where('year', '>=', $request["min_year"]);
        if (isset($request["max_year"]))
            $album = $album->where('year', '<=', $request["max_year"]);

      //  $albums = $album->with('artists')->OrderBy('year')->get();
      //  return $albums;
        $order = $request->sortBy ?? 'year';
        $sortorder = $request->sortorder ?? 'asc';
        return $album->with('artists')->OrderBy($order, $sortorder)->paginate(10);
    }

    public function store(Request $request)
    {
        $request->validate([
            //'artist' => 'required',
            'name' => 'required',
            'year' => 'required'
        ]);
        $artists = [];

//        $artists[] = Artist::firstOrCreate([
//            'name' => $request->artists
//        ])["id"];
            $artists = [];
        if ($request->artists)
            foreach ($request->artists as $artist)
            {
                $artists[] = Artist::firstOrCreate([
                    'name' => $artist
                ])["id"];
            }
        $album =Album::create(["name" => $request["name"], "year" => $request["year"]]);
            $album->artists()
            ->sync($artists);

        return $album->id;
      // return $artist->albums()->syncWithoutDetaching($album);
////        return $album->artists()->syncWithoutDetaching($artist); //attach($artist);
    }
    public function show($id)
    {
        return Album::with('artists')->findOrFail($id);
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
        if (!empty($request->artists)) {
            foreach ($request->artists as $artist) {
                $artists[] = Artist::firstOrCreate([
                    'name' => $artist
                ])["id"];
            }
        }
        unset($request["artists"]);
        $album->artists()->sync($artists);
        $album->update($request->all());
    }
}
