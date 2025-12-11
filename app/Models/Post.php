<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'concert_name',
        'location',
        'city',
        'description',
        'concert_date',
        'concert_time',
        'spots_available',
        'cover_image',
        'cover_color',
    ];

    protected $casts = [
        'concert_date' => 'datetime',
        'concert_time' => 'datetime:H:i',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function requests()
    {
        return $this->hasMany(PostRequest::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function acceptedMembers()
    {
        return $this->hasManyThrough(
            User::class,
            PostRequest::class,
            'post_id',
            'id',
            'id',
            'user_id'
        )->where('post_requests.status', 'accepted');
    }

    public function spotsFilledCount()
    {
        return $this->requests()->where('status', 'accepted')->count() + 1;
    }

    public function spotsLeftCount()
    {
        return max(0, $this->spots_available - $this->spotsFilledCount());
    }
}
