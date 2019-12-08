<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class Kazancplani extends Model implements Sortable
{
    use Sluggable;

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

    protected $fillable = [
        'title', 'short_content1', 'short_content2', 'short_content3', 'content', 'photo1', 'photo1_alt', 'photo3', 'photo3_alt', 'photo3', 'photo3_alt', 'active'
    ];
}
