<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Post extends Model
{
    protected $table = 'posts';

    protected $fillable = [
        'user_id',
        'content',
        'created_at',
        'updated_at',
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
