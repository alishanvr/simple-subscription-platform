<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\tag;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $tags = tag::all();

        return $this->success_response($request, 'All Tags', $tags);
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
            'title' => 'required|string|max:50|min:1|unique:tags',
            'description' => 'required|string|max:3000',
        ]);

        try{
            if ($validator->fails()){
                $this->validator_fails($validator);
            }
        }catch (QueryException $ex){
            $this->handle_query_exception($ex);
        }

        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'slug' => time() // @todo: For now we are using just timestamp. But we will change it to slug.
        ];

        try{
            $tag = tag::create($data);
        }catch (\Exception $exception){
            $this->handle_query_exception($exception);
        }

        return $this->success_response($request, 'Tag (' . $request->title . ') is created successfully!', $tag);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $tag = tag::where('id', $request->id)->get();

        if ($tag->isEmpty()){
            return $this->general_fails('No tag found');
        }

        return $this->success_response($request, 'Tag data for ID: ' . $request->id, $tag);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, tag $tag)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function destroy(tag $tag)
    {
        //
    }
}
