<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WebpostController extends Controller
{
     public function index()
    {
        $posts = Post::where('user_id', Auth::id())->latest()->get();
        return view('home', compact('posts'));
    }

    public function create()
    {
        return view('posts.create');
    }
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('posts', 'public');
        }
        $data['user_id'] = Auth::id(); 
        $post = Post::create($data);

        if ($request->ajax()) {
            return response()->json(['status' => 'success', 'post' => $post]);
        }
    return redirect('/home')->with('success', 'Post created successfully!');
    }

    public function edit(Post $post)
    {
        abort_if($post->user_id !== Auth::id(), 403);
        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        abort_if($post->user_id !== Auth::id(), 403);

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('posts', 'public');
        }

        $post->update($data);
        return  redirect('/home')->with('success', 'Post updated');
    }

    public function destroy(Post $post)
    {
        abort_if($post->user_id !== Auth::id(), 403);
        $post->delete();

        if (request()->ajax()) {
            return response()->json(['status' => 'deleted']);
        }

        return  redirect('/home')->with('success', 'Post deleted');
    }


}
