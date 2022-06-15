<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatRooms extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $cast = [
        'chat_id' => 'string',
    ];

    /// attributes = ['chat_id','name', 'slug']
}
