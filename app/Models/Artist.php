<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Artist extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        "name"
    ];
    protected $hidden= ["pivot"];
    public function albums()
    {
        return $this->belongsToMany(Album::class);
    }
}
