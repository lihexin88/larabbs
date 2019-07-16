<?php

namespace App\Transformers;

use App\Models\Link;
use League\Fractal\TransformerAbstract;

class LinkTransformer extends TransformerAbstract
{
    /**
     * 向请求的数据中添加额外信息
     * @param Link $link
     * @return array
     */
    public function transform(Link $link)
    {
        return [
            'id'    => $link->id,
            'title' => $link->title,
            'link'  => $link->link,
        ];
    }
}
