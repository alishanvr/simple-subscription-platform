<?php

namespace App\Http\Controllers\api\v1;

use App\Events\PostCreated;
use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $posts = Post::with('site_subscriptions')->get();

        return $this->success_response($request, 'All Posts', $posts);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $validator = Validator::make($request->all(),[
            'user_id' => 'exists:users,id', // @todo: the owner/creator of the post. For now we assumes 0 (no one)
            'site_id' => 'required|exists:sites,id',
            'status' => 'required|in:published,draft',
            'is_password_protected' => 'required|int|in:0,1',
            'password' => 'min:4|max:50',
            'title' => 'required|min:1|max:50',
            'description' => 'required|min:1|max:3000',
            'short_description' => 'max:100',
            'tag_id' => 'required|exists:tags,id',
        ]);

        try{
            if ($validator->fails()){
                $this->validator_fails($validator);
            }
        }catch (QueryException $ex){
            $this->handle_query_exception($ex);
        }

        try{

            $data = $request->all();
            $data['slug'] = time(); // @todo: create proper slug in next version.
            $data['featured_image'] = 'https://via.placeholder.com/850'; // @todo: get and upload image in next version.

            $post = Post::create($data);
            $post = Post::with('subscribers')->where('id', $post->id)->get();

            // @Post Created -- Event
            \event(new PostCreated($post));

        }catch (\Exception $exception){
            $this->handle_query_exception($exception);
        }

        return $this->success_response($request, 'Post (' . $request->title . ') is created successfully!', $post);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        //
        $post = Post::with('site_subscriptions')->where('id', $request->id)->first();

        if (empty($post)){
            return $this->general_fails('Sorry, No post found.');
        }

        return $this->success_response($request, 'Post Information', $post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
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
