<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class Post extends Model implements Sortable
{
    use Sluggable;

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    use SortableTrait;

    public $sortable = [
        'order_column_name' => 'queue',
        'sort_when_creating' => true,
    ];

    public  function user(){
        return $this->belongsTo(User::class,'user_id');
    }
    public  function category(){
        return $this->belongsTo(Categories::class,'cat_id');
    }

    protected $fillable = [
        'title', 'cat_id', 'user_id', 'meta_title', 'meta_description', 'meta_keywords', 'short_content', 'content', 'photo1', 'photo1_alt', 'photo2', 'photo2_alt', 'photo3', 'photo3_alt','photo4', 'photo4_alt', 'mainpage', 'active'
    ];
}
