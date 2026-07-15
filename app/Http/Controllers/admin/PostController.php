<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::with('user')
            ->withCount(['reactions', 'comments'])
            ->orderBy('created_at', 'desc');

        $search = trim((string) $request->input('search'));
        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('content', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($uq) use ($search) {
                      $uq->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $posts = $query->paginate(15)->withQueryString();

        return view('backend.posts.index', compact('posts'));
    }

    public function update(Request $request, Post $post)
    {
        $request->validate([
            'content' => 'nullable|string|max:10000',
            'is_pinned' => 'nullable|boolean',
        ]);

        $post->update([
            'content' => $request->input('content', $post->content),
            'is_pinned' => $request->boolean('is_pinned', $post->is_pinned),
        ]);

        return back()->with('success', 'Post updated successfully!');
    }

    public function destroy(Post $post)
    {
        if ($post->image_path) {
            Storage::disk('public')->delete($post->image_path);
        }

        // Delete related comments and reactions first
        $post->comments()->delete();
        $post->reactions()->delete();

        $post->delete();

        return back()->with('success', 'Post deleted successfully!');
    }
}
