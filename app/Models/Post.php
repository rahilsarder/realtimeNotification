<?php

namespace App\Models;

use App\Events\PostCreated;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;


    // Fields => ['chat_id','name', 'slug', 'chat_room_id']
    protected $guarded = [];

    protected $dispatchEvents = [
        'created' => PostCreated::class,
    ];

    protected $casts = [
        'chat_id' => 'string',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
