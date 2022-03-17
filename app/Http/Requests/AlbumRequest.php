<?php

namespace App\Http\Requests;

use App\Models\Artist;
use Illuminate\Foundation\Http\FormRequest;

class AlbumRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'year' => 'required||integer|min:0',
            'artists' => 'array',
        ];
    }

    protected static function findOrCreateArtists(array $artistRequest = null) : array
    {
        $artists = [];
        if (isset($artistRequest)) {
            foreach ($artistRequest as $artist) {
                $artists[] = Artist::firstOrCreate([
                    'name' => $artist["name"]
                ])["id"];
            }
        }
        return $artists;
    }



    protected function passedValidation()
    {
        $this->merge(['artists' => AlbumRequest::findOrCreateArtists($this->artists)]);
    }
}
