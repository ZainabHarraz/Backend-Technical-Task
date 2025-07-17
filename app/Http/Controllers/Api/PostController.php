<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    //• Get a list of all posts (Pagination)
  public function index()
{
    $posts = Post::paginate(10);
    return response()->json([
        'posts' => PostResource::collection($posts->items()), 
        'current_page' => $posts->currentPage(),
        'last_page' => $posts->lastPage(),
        'total' => $posts->total(),
    ]);
}

//• Get a single post by ID
 public function show($id)
{
    $post = Post::find($id);
    if (!$post) {
        return response()->json(['message' => 'Post not found'], 404);
    }
    return new PostResource($post);
}

//• Users can view only their posts. (authenticated users only).
    public function userPosts()
{
    if (!Auth::check()) {
        return response()->json([
            'message' => 'Unauthorized. Please login first.'
        ], 401);
    }
    try {
        $posts = Post::where('user_id', Auth::id())->get();
        return response()->json([
            'posts' => PostResource::collection($posts)
        ]);
    } catch (\Throwable $e) {
        return response()->json([
            'message' => 'Something went wrong.',
            'error' => $e->getMessage()
        ], 500);
    }

}
//Create a new post (authenticated users only).
    public function store(Request $request)
{
    if (!Auth::check() || !Auth::user()->is_verified) {
        return response()->json(['message' => 'Unauthorized or email not verified.'], 403);
    }
    $validator = Validator::make($request->all(), [
        'title' => 'required|string|max:255',
        'body' => 'required|string',
        'image' => 'nullable|image|mimes:jpeg,png,jpg'
    ]);
    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }
    $imagePath = null;
    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('posts', 'public');
    }
    $post = Post::create([
        'title' => $request->title,
        'body' => $request->body,
        'image' => $imagePath,
        'user_id' => Auth::id(),
    ]);
    return response()->json([
        'message' => 'Post created successfully.',
        'post' => new PostResource($post)
    ], 201);
}


    public function update(Request $request, $id)
{
    $user = Auth::user();
    if (!$user || !$user->is_verified) {
        return response()->json(['message' => 'Unauthorized or email not verified.'], 403);
    }
    $post = Post::where('id', $id)->where('user_id', $user->id)->first();
    if (!$post) {
        return response()->json(['message' => 'Post not found or not authorized.'], 404);
    }
    $validator = Validator::make($request->all(), [
        'title' => 'sometimes|required|string|max:255',
        'body' => 'sometimes|required|string',
        'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
    ]);
    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }
    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('posts', 'public');
        $post->image = $imagePath;
    }
    $post->fill($request->only('title', 'body'))->save();
    return response()->json([
        'message' => 'Post updated successfully.',
        'post' => new PostResource($post)
    ]);
}


    public function destroy($id)
{
    $user = Auth::user();
    if (!$user || !$user->is_verified) {
        return response()->json(['message' => 'Unauthorized or email not verified.'], 403);
    }
    $post = Post::where('id', $id)->where('user_id', $user->id)->first();
    if (!$post) {
        return response()->json(['message' => 'Post not found or not authorized.'], 404);
    }
    $post->delete();
    return response()->json(['message' => 'Post deleted successfully.']);
}



    
   public function stats()
    {
        $totalUsers = User::count();
        $totalPosts = Post::count();
        $usersWithNoPosts = User::doesntHave('posts')->count();
        return response()->json([
            'total_users' => $totalUsers,
            'total_posts' => $totalPosts,
            'users_with_no_posts' => $usersWithNoPosts,
        ]);
    }

}











