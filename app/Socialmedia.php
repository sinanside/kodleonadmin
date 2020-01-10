<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class socialmedia extends Model implements Sortable
{
    use Sluggable;

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    protected $fillable = [
        'icon', 'icon2','name', 'queue', 'active','url'
    ];

    use SortableTrait;

    public $sortable = [
        'order_column_name' => 'queue',
        'sort_when_creating' => true,
    ];
}
