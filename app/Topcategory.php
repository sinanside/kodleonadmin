<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class Topcategory extends Model implements Sortable
{
    use Sluggable;

    public function sluggable()
        {
            return [
                'slug' => [
                    'source' => 'name_tc'
                ]
            ];
        }

    protected $fillable = [
        'specialcode_tc', 'name_tc', 'name_tc_web', 'photo1', 'photo1_alt', 'photo2', 'photo2_alt', 'photo3', 'photo3_alt', 'short_description', 'meta_description', 'description', 'menu', 'active', 'queue'
    ];

    use SortableTrait;

    public
    $sortable = [
        'order_column_name' => 'queue',
        'sort_when_creating' => true,
    ];

}