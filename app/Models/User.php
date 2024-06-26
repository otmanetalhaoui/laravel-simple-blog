<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Post;
use App\Models\Social;
use App\Models\Comment;
use App\Models\Like;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'image',
        'banner',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * User - Post relationship
     */
    public function posts() {
        return $this->hasMany(Post::class);
    }

    /**
     * User - Comment relationship
     */
    public function comments() {
        return $this->hasMany(Comment::class);
    }

    /**
     * User - Social relationship
     */
    public function social() {
        return $this->hasOne(Social::class);
    }

    /**
     * Like - User relationship
     */
    public function likes() {
        return $this->hasMany(Like::class);
    }
}
