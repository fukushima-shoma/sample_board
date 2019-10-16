<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests\PostRequest;
use App\Post;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


        $q = \Request::query();

        if(isset($q['category_id'])){
        $posts = Post::latest()->where('category_id', $q['category_id'])->paginate(5);
        $posts->load('category', 'user');

      //  dd($posts);

        return view ('posts.index',[
          'posts' => $posts,
          'category_id' => $q['category_id']
        ]);
      } else {

        $posts = Post::latest()->paginate(5);
        $posts->load('category', 'user');

      //  dd($posts);

        return view ('posts.index',[
          'posts' => $posts,
        ]);
      }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      return view ('posts.create',[

      ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {
        if($request->file('image')->isValid()) {

            $post = new Post;
            // $input = $request->only($post->getFillable());
            $post->user_id = $request->user_id;
            $post->category_id = $request->category_id;
            $post->content = $request->content;
            $post->title = $request->title;

            $filename = $request->file('image')->store('public/image');
            $post->image = str_replace('public/', 'storage/', $filename);


          //  if(!isset($input['image'])) {
          //    array_set($input, 'image', basename($filename));
          //  }

            //$post = $post->create($input);
            $post->save();
        }


        return redirect('/');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
      $post->load('category', 'user', 'comments.user');

      return view ('posts.show',[
        'post' => $post,
      ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function search(Request $request)
    {
      $posts = Post::where('title', 'like', "%{$request->search}%")
              ->orWhere('content', 'like', "%{$request->search}%")
              ->paginate(5);

      $search_result = $request->search. 'の検索結果'.$posts->total().'件';

      return view ('posts.index',[
        'posts' => $posts,
        'search_result' => $search_result,
        'search_query' => $request->search
    ]);
    }
}
