<?php

namespace App\Http\Controllers;

use App\Feed;
use Illuminate\Http\Request;

class FeedController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $feeds = Feed::all();

        return $feeds;
    }

    public function getForUser(Request $request){
        $feeds = Feed::where('user_id', '=', $request->input('user'))->get();
        return $feeds;
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return Feed::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Feed  $feed
     * @return \Illuminate\Http\Response
     */
    public function show(Feed $feed)
    {

        return $feed;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Feed  $feed
     * @return \Illuminate\Http\Response
     */
    public function edit(Feed $feed)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Feed  $feed
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Feed $feed)
    {
        //$feed = Feed::where('id' , $request-> id)->first();

        $feed ->update($request->all());
        $feed ->save();
        return $feed;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Feed  $feed
     * @return \Illuminate\Http\Response
     */
    public function destroy(Feed $feed)
    {

        //$blog = \DB::table('feeds')->where('id',4);
        $headquote = \App\Feed::find(4);

        $headquote->delete();

        //$result = Feed::find($feed)->delete();
        //return $result;
        return response()->json("ok", 200);
    }

    public function search()

    {
        $param = \request()->input('oq');

        if($param == '' || $param == "" || $param == null)
        {
            return response()->json(null, 204);
        }

        $feeds = Feed::latest()
            ->search($param)->get();
        return $feeds;
    }
}
