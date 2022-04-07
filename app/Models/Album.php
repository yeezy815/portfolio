<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        "name",
        "year"
    ];

    protected $hidden= ["pivot"];

    public function artists()
    {
        return $this->belongsToMany(Artist::class);
    }

    public function artistsWithFilter(){
        return $this->belongsToMany(Artist::class)->wherePivot('artist_id','=',10);
    }

    public function dairies()
    {
        return $this->hasMany(Dairy::class);
    }
}
