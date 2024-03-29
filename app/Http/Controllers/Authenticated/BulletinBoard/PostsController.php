<?php

namespace App\Http\Controllers\Authenticated\BulletinBoard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categories\MainCategory;
use App\Models\Categories\SubCategory;
use App\Models\Posts\Post;
use App\Models\Posts\PostComment;
use App\Models\Posts\Like;
use App\Models\Users\User;
use App\Http\Requests\BulletinBoard\PostFormRequest;
use App\Http\Requests\MainCategoryRequest;
use App\Http\Requests\SubCategoryRequest;
use App\Http\Requests\CommentRequest;
use Auth;
use Carbon\Carbon;

class PostsController extends Controller
{
    public function show(Request $request)
    {
        $posts = Post::with('user', 'postComments', 'subCategories')->get();
        $categories = MainCategory::with('subCategories')->get();
        $like = new Like();
        $post_comment = new Post();
        // $date = $posts->created_at->format('Y-m-d');
        if (!empty($request->keyword)) {
            $posts = Post::with('user', 'postComments')
            ->where('post_title', 'like', '%'.$request->keyword.'%')
            ->orWhere('post', 'like', '%'.$request->keyword.'%')->get();
        } elseif ($request->category_word) {
            $sub_category = $request->category_word;
            $sub_category_id = SubCategory::select('id')->where('sub_category', $sub_category)->first();
            // dd($sub_category_id);
            $posts = Post::with('user', 'postComments')
            ->whereHas('subCategories', function ($q) use ($sub_category_id) {
                $q->whereIn('post_sub_categories.sub_category_id', $sub_category_id);
            })->get();
        } elseif ($request->like_posts) {
            $likes = Auth::user()->likePostId()->get('like_post_id');
            $posts = Post::with('user', 'postComments')
            ->whereIn('id', $likes)->get();
        } elseif ($request->my_posts) {
            $posts = Post::with('user', 'postComments', 'subCategories')
            ->where('user_id', Auth::id())->get();
        }
        return view('authenticated.bulletinboard.posts', compact('posts', 'categories', 'like', 'post_comment'));
    }

    public function postDetail($post_id)
    {
        $post = Post::with('user', 'postComments', 'subCategories')->findOrFail($post_id);
        return view('authenticated.bulletinboard.post_detail', compact('post'));
    }

    public function postInput()
    {
        $main_categories = MainCategory::with('subCategories')->get();
        $sub_categories = SubCategory::with('mainCategory')->get();
        return view('authenticated.bulletinboard.post_create', compact('main_categories', 'sub_categories'));
    }

    public function postCreate(PostFormRequest $request)
    {
        $post = Post::create([
            'user_id' => Auth::id(),
            'post_title' => $request->post_title,
            'post' => $request->post_body
        ]);
        // $sub_categories = $request->post_category_id;
        $sub_categories = SubCategory::where('id', $request->post_category_id)->get();
        // dd($sub_categories);
        $posts = Post::findOrFail($post->id);
        $posts->subCategories()->attach($sub_categories);
        return redirect()->route('post.show');
    }

    public function postEdit(PostFormRequest $request)
    {
        Post::where('id', $request->post_id)->update([
            'post_title' => $request->post_title,
            'post' => $request->post_body,
        ]);
        return redirect()->route('post.detail', ['id' => $request->post_id]);
    }

    public function postDelete($id)
    {
        Post::findOrFail($id)->delete();
        return redirect()->route('post.show');
    }
    public function mainCategoryCreate(MainCategoryRequest $request)
    {
        MainCategory::create([
            'main_category' => $request->main_category_name
        ]);
        return redirect()->route('post.input');
    }
    public function subCategoryCreate(SubCategoryRequest $request)
    {
        SubCategory::create([
            'sub_category' => $request->sub_category_name,
            'main_category_id' => $request->main_category_id
        ]);
        return redirect()->route('post.input');
    }

    public function commentCreate(CommentRequest $request)
    {
        PostComment::create([
            'post_id' => $request->post_id,
            'user_id' => Auth::id(),
            'comment' => $request->comment
        ]);
        return redirect()->route('post.detail', ['id' => $request->post_id]);
    }

    public function myBulletinBoard()
    {
        $posts = Auth::user()->posts()->get();
        $like = new Like();
        return view('authenticated.bulletinboard.post_myself', compact('posts', 'like'));
    }

    public function likeBulletinBoard()
    {
        $like_post_id = Like::with('users')->where('like_user_id', Auth::id())->get('like_post_id')->toArray();
        $posts = Post::with('user')->whereIn('id', $like_post_id)->get();
        $like = new Like();
        return view('authenticated.bulletinboard.post_like', compact('posts', 'like'));
    }

    public function postLike(Request $request)
    {
        Auth::user()->likes()->attach($request->post_id);
        return response()->json();
    }

    public function postUnLike(Request $request)
    {
        Auth::user()->likes()->detach($request->post_id);
        return response()->json();
    }
}
