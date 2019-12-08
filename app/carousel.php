<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class carousel extends Model implements Sortable
{
    use SortableTrait,Sluggable;

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'carousel_title'
            ]
        ];
    }

    public $sortable = [
        'order_column_name' => 'queue',
        'sort_when_creating' => true,
    ];

    protected $fillable = [
        'carousel_title', 'image', 'image_alt', 'image_x', 'image_y', 'queue', 'active'
    ];

    protected $table = 'carousel';
}
