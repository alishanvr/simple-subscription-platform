<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Site;
use App\Models\SiteSubscriptions;
use App\Models\Subscriber;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubscriberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $subscribers = Subscriber::with('site_subscriptions')->get();

        return $this->success_response($request, 'All Subscribers', $subscribers);
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

        if (isset($request->email)){
            $subscriber = Subscriber::where('email', $request->email)->first();
            if (! empty($subscriber)){

                $site = Site::where('id', $request->site_id)->first();

                if (empty($site)){
                    return $this->general_fails('Provided site ID (' . $request->site_id . ') is not valid Or the site not found.');
                }

                // check if not already subscribed
                $ss = SiteSubscriptions::where('site_id', $site->id)->where('subscriber_id', $subscriber->id)->first();

                if (empty($ss)){
                    try{
                        $ss = SiteSubscriptions::create([
                            'site_id' => $site->id,
                            'subscriber_id' => $subscriber->id
                        ]);

                        $subscriber = Subscriber::where('id', $subscriber->id)->with('site_subscriptions')->get();

                    }catch (\Exception $exception){
                        $this->handle_query_exception($exception);
                    }

                    return $this->success_response($request, 'Subscriber (' . $request->email . ') has successfully scribed the website!', $subscriber);
                }else {
                    return $this->success_response($request, 'Subscriber (' . $request->email . ') has successfully scribed the website.', $subscriber);
                }
            }

            unset($subscriber);
        }

        $validator = Validator::make($request->all(),[
            'email' => 'required|email|unique:subscribers',
            'site_id' => 'required|int'
        ]);

        try{
            if ($validator->fails()){
                $this->validator_fails($validator);
            }
        }catch (QueryException $ex){
            $this->handle_query_exception($ex);
        }

        $site = Site::where('id', $request->site_id)->first();

        if (empty($site)){
            return $this->general_fails('Provided site ID (' . $request->site_id . ') is not valid Or the site not found.');
        }

        try{
            $subscriber = Subscriber::create($request->all());

            $ss = SiteSubscriptions::create([
                'site_id' => $site->id,
                'subscriber_id' => $subscriber->id
            ]);

            $subscriber = Subscriber::where('id', $subscriber->id)->with('site_subscriptions')->get();

        }catch (\Exception $exception){
            $this->handle_query_exception($exception);
        }

        return $this->success_response($request, 'Subscriber (' . $request->email . ') is created successfully and successfully subscribed for the website!', $subscriber);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Subscriber  $subscriber
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        //
        $subscriber = Subscriber::with('site_subscriptions')->where('id', $request->id)->first();

        if (empty($subscriber)){
            return $this->general_fails('Sorry, No Subscriber found.');
        }

        return $this->success_response($request, 'Subscriber Information', $subscriber);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Subscriber  $subscriber
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subscriber $subscriber)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Subscriber  $subscriber
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subscriber $subscriber)
    {
        //
    }
}
