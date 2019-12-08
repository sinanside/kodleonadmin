<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class carousel_alt extends Model implements Sortable
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

    public  function carousel(){
        return $this->belongsTo(carousel::class,'carousel_id');
    }

    protected $fillable = [
        'title', 'carousel_id', 'color', 'delay', 'x1', 'x2', 'x3', 'x4', 'y1', 'y2', 'y3', 'y4', 'fontsize1', 'fontsize2','fontsize3', 'fontsize4', 'lineheight1', 'lineheight2', 'lineheight3', 'lineheight4',
        'fontweight1', 'fontweight2', 'fontweight3', 'fontweight4','visibility1', 'visibility2', 'visibility3', 'visibility4', 'active'
    ];
}
