<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

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
