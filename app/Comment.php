<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comment';
    protected $fillable = ['user_id','article_id','content','published_at','user_name'];
    /**
     * @var mixed
     */
}
