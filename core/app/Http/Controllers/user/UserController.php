<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\Post;
use App\Models\User;

class UserController extends Controller
{
     public function contact(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'message' => 'required',
        ]);

        Contact::create($request->all());

        return back()->with('success', 'Message sent successfully!');
    }

    public function user_search(Request $request)
    {
        $query = trim($request->get('query', ''));

        $users = User::where('id', '!=', auth()->id())
            ->when($query !== '', function ($queryBuilder) use ($query) {
                $queryBuilder->where(function ($inner) use ($query) {
                    $inner->where('email', 'LIKE', "%{$query}%")
                          ->orWhere('name', 'LIKE', "%{$query}%");

                    if (is_numeric($query)) {
                        $inner->orWhere('id', $query);
                    }
                });
            })
            ->select('id', 'name', 'email')
            ->limit(10)
            ->get();

        return response()->json($users);
    }

    public function search(Request $request)
    {
        $query = trim((string) $request->get('q', ''));
        $users = collect();
        $posts = collect();

        if ($query !== '') {
            // Search users
            $users = User::where('id', '!=', auth()->id())
                ->where(function ($q) use ($query) {
                    $q->where('name', 'LIKE', "%{$query}%")
                      ->orWhere('email', 'LIKE', "%{$query}%");
                    if (is_numeric($query)) {
                        $q->orWhere('id', $query);
                    }
                })
                ->select('id', 'name', 'email', 'avatar_path')
                ->limit(10)
                ->get();

            // Search posts
            $posts = Post::with('user:id,name,avatar_path')
                ->where(function ($q) use ($query) {
                    $q->where('content', 'LIKE', "%{$query}%");
                })
                ->withCount([
                    'comments',
                    'reactions',
                ])
                ->latest()
                ->limit(20)
                ->get();
        }

        return view('frontend.search', compact('query', 'users', 'posts'));
    }
}
