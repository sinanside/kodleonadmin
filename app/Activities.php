<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class Activities extends Model implements Sortable
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
    protected $fillable = [
    'title', 'meta_title', 'meta_description', 'meta_keywords', 'description1','description2','description3','description4', 'short_content', 'content', 'photo1', 'photo1_alt', 'photo2', 'photo2_alt', 'photo3', 'photo3_alt','photo4', 'photo4_alt', 'active'
];

    use SortableTrait;

    public $sortable = [
    'order_column_name' => 'queue',
    'sort_when_creating' => true,
];
}
