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
    public function artists()
    {
        return $this->belongsToMany(Artist::class);
    }
}
