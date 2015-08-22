<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\SnipRequest;
use App\Language;
use App\Reply;
use App\Thread;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class SnipController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('snips.create')->with(['categories' => Category::all(), 'languages' => Language::all()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(SnipRequest $request)
    {
        $thread = new Thread;
        $reply = new Reply;

        $thread->title = $request->title;
        $thread->language_id = $request->language_id;
        $reply->user_id = user()->id;
        $reply->code = $request->code;
        $reply->message = $request->message;

        $thread->save();
        $reply->thread_id = $thread->id;
        $reply->save();

        return $thread;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
