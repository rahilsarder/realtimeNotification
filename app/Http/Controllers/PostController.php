<?php

namespace App\Http\Controllers;

use App\Events\PostCreated;
use App\Models\Post;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\ChatRooms;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $user;

    public function index()
    {
        $chat_rooms =  ChatRooms::all();

        return view('post.index', ['chat_rooms' => $chat_rooms]);
    }

    public function createRoom(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required|string|max:255|unique:chat_rooms,name',
        ]);
        $chat_room = ChatRooms::create([
            'name' => $request->name,
            'slug' => Str::random(10),
            'chat_id' => Str::uuid(),
        ]);

        return redirect()->back();
    }


    // Get Posts from DB with appropritate room ID from url

    public function apiIndex($roomID)
    {
        return Post::where('chat_room_id', $roomID)->with('user')->get();
    }



    // Get Room Info from Room ID

    public function apiRoomInfo($roomID)
    {

        $chat_room = ChatRooms::where('chat_id', $roomID)->first();

        return $chat_room;
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    // Create Post View
    public function create($roomID)
    {
        $this->user = Auth::user();
        $chat_rooms =  ChatRooms::all();
        $room = ChatRooms::where('chat_id', $roomID)->first();
        $posts = Post::where('chat_room_id', $roomID)->get();
        return view('post.create', ['user' => $this->user, 'posts' => $posts, 'roomID' => $roomID, 'chat_rooms' => $chat_rooms, 'room' => $room]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePostRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $roomID)
    {

        $post = Post::create(['title' => $request->title, 'user_id' => $request->user_id, 'chat_room_id' => $roomID]);
        event(new PostCreated($post, auth()->user(), $roomID));
        return $post ?
            response()->json([
                'message' => 'Post created successfully',
            ]) : response()->json(['message' => 'Post not created'], 500);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePostRequest  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        //
    }
}
