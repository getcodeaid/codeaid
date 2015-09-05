<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\ReplyRequest;
use App\Http\Requests\SnipRequest;
use App\Language;
use App\Reply;
use App\Thread;
use App\Vote;
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
        $vote = new Vote;

        $thread->title = $request->title;
        $thread->language_id = $request->language_id;
        $thread->category_id = $request->category_id;
        $reply->user_id = user()->id;
        $reply->code = $request->code;
        $reply->message = $request->message;
        $reply->modification = true;

        $thread->save();
        $reply->thread_id = $thread->id;
        $reply->save();

        $vote->type = "+";
        $vote->user_id = user()->id;
        $vote->reply_id = $reply->id;
        $vote->save();

        return $thread;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($slug)
    {
        $thread = Thread::findBySlugOrFail($slug);
        return view('snips.show')->with(compact('thread'));
    }


    public function reply($slug, Request $request)
    {
        if ($request->modification == "true") {
            // Validation rules for modification
            $this->validate($request, [
                'code' => 'required',
                'message' => 'required',
            ]);
        } elseif ($request->modification == "false"){
            // Validation rules for comment
            $this->validate($request, [
                'message' => 'required',
            ]);
        } else {
            // Type is incorrect or missing
            abort(404);
        }

        $thread = Thread::findBySlugOrFail($slug);
        $reply = new Reply;
        $reply->message = $request->message;
        if ($request->modification == "true"){
            $reply->modification = true;
            $reply->code = $request->code;
        }else{
            $reply->modification = false;
        }
        $reply->thread_id = $thread->id;
        $reply->user_id = user()->id;
        $reply->save();
        return $reply;
    }

    /**
     * Mark a reply as accepted
     *
     * @param $id Reply Id
     */
    public function accept($id)
    {
        $reply = Reply::findOrFail($id);
        if ($reply->user_id == user()->id) {
            $reply->accepted = true;
            $reply->save();
            return $reply;
        } else {
            return abort(403);
        }
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
