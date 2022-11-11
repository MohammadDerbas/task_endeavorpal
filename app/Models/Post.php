<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

/**
 * @mixin Builder
 */

class Post extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','post_content'];
    public function user()
    {
        return $this -> belongsTo(User::class);
    }
    public function comments()
    {
        return $this -> hasMany(Comment::class);
    }
}
