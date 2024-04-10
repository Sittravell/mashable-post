<?php

namespace App\Transformers;

use App\Models\Post;
use Flugg\Responder\Transformers\Transformer;

class PostTransformer extends Transformer
{
    public function transform(Post $post): array
    {
        return [
            'title' => $post->title,
            'link' => $post->link,
            'date' => $post->published_date,
        ];
    }
}
