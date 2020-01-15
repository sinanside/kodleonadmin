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

    public  function localization(){
        return $this->belongsTo(Localizations::class,'language');
    }

    public $sortable = [
        'order_column_name' => 'queue',
        'sort_when_creating' => true,
    ];

    public function buildSortQuery()
    {
        return static::query()->where('language', $this->language);
    }

    protected $fillable = [
        'carousel_title', 'image', 'image_alt', 'video', 'image_x', 'image_y', 'type', 'short_description1', 'short_description2', 'short_description3', 'short_description4', 'short_description5', 'short_description6', 'language', 'queue', 'active'
    ];

    protected $table = 'carousel';
}
