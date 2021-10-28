<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{
    use HasFactory;

    protected $fillable = ['email', 'first_name', 'last_name'];

    public function site_subscriptions(){
        return $this->hasMany(SiteSubscriptions::class, 'subscriber_id', 'id');
    }
}
