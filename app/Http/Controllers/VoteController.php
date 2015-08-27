<?php

namespace App\Http\Controllers;

use App\Reply;
use App\Vote;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class VoteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Handles voting
     *
     * @param $id
     * @param $type
     * @return Vote
     */
    public function vote($id, $type)
    {
        $reply = Reply::findOrFail($id);

        switch ($type){
            case ("up"):
                $type = "+";
                break;
            case ("down"):
                $type = "-";
                break;
            default:
                abort(404);
                break;
        }

        $userVote = $reply->userVote();

        if ($userVote == null){
            $vote = new Vote;
            $vote->user_id = user()->id;
            $vote->reply_id = $reply->id;
            $vote->type = $type;
            $vote->save();
            return $vote;
        }else{
            $userVote->type = $type;
            $userVote->save();
            return $userVote;
        }
    }

    public function score($id)
    {
        $reply = Reply::findOrFail($id);
        return $reply->voteCount();
    }
}
