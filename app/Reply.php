<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
        return $this->votes()->where('user_id', user()->id)->first();
    }
}
