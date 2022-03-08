<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Artist;
use Illuminate\Http\Request;
use App\Http\Requests\AlbumRequest;
class AlbumController extends Controller
{
    /**
     * Shows all or filtered albums.
     *
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
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


        $order = $request->sortBy ?? 'year';
        $sortorder = $request->sortorder ?? 'asc';
        return $album->with('artists')->OrderBy($order, $sortorder)->paginate(25);
    }


    /**
     * Creates an album.
     * @param Request $request
     * @return mixed
     */






    public function store(AlbumRequest $request)
    {
       // $artists = AlbumController::findOrCreateArtists($request["artists"]);
        $album =Album::create([
            "name" => $request["name"],
            "year" => $request["year"]
        ]);
        $album->artists()->sync($request["artists"]);
        return Album::with('artists')->find($album["id"]);
    }

    public function show($id)
    {
        return Album::with('artists')->findOrFail($id);
    }





    public function destroy($id)
    {
        return Album::destroy($id);
    }




    public function update(AlbumRequest $request, $id)
    {
        $album = Album::findOrFail($id);
        $album->artists()->sync($request["artists"]);
        return $album->update([
            "name" => $request["name"],
            "year" => $request["year"]
        ]);
    }
}
