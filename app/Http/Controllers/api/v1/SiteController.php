<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Site;
use http\Exception\BadQueryStringException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SiteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $sites = Site::all();

        return $this->success_response($request, 'All Sites', $sites);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'schema' => 'required|string|max:8|min:7',
            'url' => 'required|string|max:1000|unique:sites',
        ]);

        try{
            if ($validator->fails()){
                $this->validator_fails($validator);
            }
        }catch (QueryException $ex){
            $this->handle_query_exception($ex);
        }

        try{
            $site = Site::create($request->all());
        }catch (\Exception $exception){
            $this->handle_query_exception($exception);
        }

        return $this->success_response($request, 'Site (' . $request->url . ') is created successfully!', $site);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Site  $site
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        //
        $site = Site::where('id', $request->id)->get();

        if ($site->isEmpty()){
            return $this->general_fails('No site found');
        }

        return $this->success_response($request, 'Site data for ID: ' . $request->id, $site);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Site  $site
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Site $site)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Site  $site
     * @return \Illuminate\Http\Response
     */
    public function destroy(Site $site)
    {
        //
    }
}
