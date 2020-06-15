<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comments';
    public $fillable = ['user_id','article_id','content','published_at','user_name'];
    /**
     * @var mixed
     */
}
