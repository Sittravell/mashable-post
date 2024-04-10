<?php

namespace App\Models;

use App\Transformers\PostTransformer;
use Flugg\Responder\Contracts\Transformable;
use Illuminate\Database\Eloquent\Model;

class Post extends Model implements Transformable
{
    protected $table = 'posts';

    protected $fillable = [
        'title',
        'link',
        'published_date',
    ];

    public function transformer()
    {
        return PostTransformer::class;
    }
}
