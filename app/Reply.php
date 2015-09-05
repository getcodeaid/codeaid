<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Reply extends Model
{

    /**
     * A reply belongs to a user
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    /**
     * A Reply has many votes
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function votes()
    {
        return $this->hasMany('App\Vote', 'reply_id');
    }

    /**
     * Calculate the Reply's vote count
     *
     * @return float
     */
    public function voteCount()
    {
        /** @var int $up */
        $up = $this->votes()->where('type', '+')->count();
        /** @var int $down */
        $down = $this->votes()->where('type', '-')->count();

        /** @var float $score */
        $score = $up - $down;

        return $score;
    }

    /**
     * Get the user's vote
     *
     * @return object
     */
    public function userVote()
    {
        if(Auth::check()) {
            return $this->votes()->where('user_id', user()->id)->first();
        }else{
            return null;
        }
    }

    public function badges()
    {
        $badges = "";

        if ($this->modification) {
            $badges .= "<span class=\"label label-success\"><i class=\"fa fa-pencil\"></i> Modification</span> ";

            if ($this->accepted) {
                $badges .= "<span class=\"label label-success\">Accepted</span> ";
            } else {
                $badges .= "<span class=\"label label-danger\">Unaccepted</span> ";
            }
        }

        return $badges;
    }
}
