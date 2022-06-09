<?php

namespace App\Models;

use App\Events\PostCreated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $dispatchEvents = [
        'created' => PostCreated::class,
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
