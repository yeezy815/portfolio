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
            'sortorder' => 'in:asc,desc',
            'artist' => 'string'
        ]);

        $album = new Album();

        if ($request->has('artist')) {
            $artists = [];
            $request->artist = str_replace('-', ' ', $request->artist);
            $request->artist = str_replace(';', '', $request->artist);
            $request->artist = str_replace(',', '', $request->artist);
            $artists = explode(' ', $request->artist);
            $album = Album::whereHas('artists', function ($query) use ($artists) {
                $query->where(function($query) use ($artists){
                    foreach ($artists as $artist) {
                        $query->orWhere('artists.name', 'like', '%' . $artist . '%');
                    }
                });

            });
        }
        if ($request->has('album'))
                $album = $album->where('name', 'like', '%'.$request->input('album').'%');
        if ($request->has('min_year'))
            $album = $album->where('year', '>=', $request->min_year);
        if ($request->has('max_year'))
            $album = $album->where('year', '<=', $request->max_year);
        $order = $request->sortBy ?? 'year';
        $sortOrder = $request->sortorder ?? 'asc';
        return $album->with('artists')->OrderBy($order, $sortOrder)->paginate(25);
    }



    public function showDairies($id)
    {
        return Album::with('artists')->with('dairies')->findOrFail($id);
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
            'name' => $request->name,
            'year' =>$request->year
        ]);
        $album->artists()->sync($request->artists);
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
        $album->artists()->sync($request->artists);
        return $album->update([
            'name' => $request->name,
            'year' =>$request->year
        ]);
    }
}
