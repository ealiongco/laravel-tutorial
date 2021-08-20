<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory;
    use SoftDeletes;

    // protected $table = "posts";
    // protected $primaryKey = "id";

    public $directory = "/images/";

    protected $dates = [
        'deleted_at'
    ];

    protected $fillable = [
        'title',
        'content',
        'path'
    ];

    public function user()
    {
        return $this->belongsTo(User::class); // inverse method
    }

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'Taggable');
    }

    public static function scopeLatestOrder($query)
    {
        return $query->orderBy('id', 'desc')->get();
    }

    public function getPathAttribute($value)
    {
        return $this->directory . $value;
    }
}
