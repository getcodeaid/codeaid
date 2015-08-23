<?php

namespace App;

use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract, SluggableInterface
{
    use Authenticatable, CanResetPassword, EntrustUserTrait, SluggableTrait;

    /**
     * Define Slug
     *
     * @var array
     */
    protected $sluggable = [
        'build_from' => 'name',
        'save_to'    => 'slug',
    ];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * A user has many threads
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function thread(){
        return $this->hasMany('App\Thread');
    }

    /**
     * Get either a Gravatar URL or complete image tag for a specified email address. 
     * @param $email
     * @param int $s Size in pixels, defaults to 80px [ 1 - 2048 ]
     * @param bool $img True to return a complete IMG tag False for just the URL
     * @param array $atts Optional, additional key/value attributes to include in the IMG tag
     * @return string The URL to the image, or the comple img tag
     * @internal param string $d Default imageset to use [ 404 | mm | identicon | monsterid | wavatar ]
     * @internal param string $r Maximum rating (inclusive) [ g | pg | r | x ]
     */
    public function avatar( $s = 80, $img = false, $atts = array() ) {
        $email = $this->email;
        $d = 'identicon';
        $r = 'g';
        $url = 'http://www.gravatar.com/avatar/';
        $url .= md5( strtolower( trim( $email ) ) );
        $url .= "?s=$s&d=$d&r=$r";
        if ( $img ) {
        $url = '<img src="' . $url . '"';
        foreach ( $atts as $key => $val )
            $url .= ' ' . $key . '="' . $val . '"';
            $url .= ' />';
        }
        return $url;
    }
}
