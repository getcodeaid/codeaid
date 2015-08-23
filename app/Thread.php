<?php

namespace App;

use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;
use Illuminate\Database\Eloquent\Model;

class Thread extends Model implements SluggableInterface
{
    use SluggableTrait;

    protected $sluggable = [
        'build_from' => 'title',
        'save_to'    => 'slug',
    ];

    /**
     * A Thread has many replies
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function replies()
    {
        return $this->hasMany('App\Reply');
    }

    /**
     * Get the first post in the thread
     *
     * @return mixed
     */
    public function firstPost()
    {
        return $this->replies()->first();
    }

    /**
     * Get the language for a thread
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function language()
    {
        return $this->belongsTo('App\Language');
    }

    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    /**
     * Generate the badges for a Thread
     *
     * @return string
     */
    public function badges()
    {
        $badges = "";
        $category = $this->category()->first();
        $badges .= "<span class=\"label label-" . $category->color . "\">";
        if ($category->icon != ""){
            $badges .= "<i class=\"fa fa-" . $category->icon . "\"></i> ";
        }
        $badges .= $category->name . "</span>";

        $badges .= " <span class=\"label label-primary\">" . $this->language->name . "</span>";

        return $badges;

    }
}
