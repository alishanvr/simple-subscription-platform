<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'site_id',
        'slug',
        'status',
        'is_password_protected',
        'password',
        'title',
        'description',
        'short_description',
        'featured_image',
        'tag_id'
    ];

    // SiteSubscription
    // Subscribers
    // Posts

    public function subscribers(){
        return $this->hasManyThrough(Subscriber::class, SiteSubscriptions::class, 'site_id', 'id', 'site_id', 'subscriber_id');
    }
}
