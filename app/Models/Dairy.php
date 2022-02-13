<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dairy extends Model
{
    use HasFactory;
    use \Znck\Eloquent\Traits\BelongsToThrough;

    protected $fillable= [
        "score",
        "date",
        "album_id",
        "experience",
        "description"
    ];

    protected $hidden = ["created_at", "updated_at", "album_id"];

    public function albums()
    {
        return $this->belongsTo(Album::class,'album_id')->with('artists');
    }

    public function artists()
    {
        return $this->belongsToThrough(Artist::class, Album::class);
    }
}
