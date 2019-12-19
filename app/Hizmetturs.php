<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class Hizmetturs extends Model implements Sortable
{
    use Sluggable;

    protected $fillable = [
        'title', 'short_description', 'photo',  'photo_alt','queue', 'language', 'active'
    ];


    public  function localization(){
        return $this->belongsTo(Localizations::class,'language');
    }

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    use SortableTrait;

    public function buildSortQuery()
    {
        return static::query()->where('language', $this->language);
    }

    public $sortable = [
        'order_column_name' => 'queue',
        'sort_when_creating' => true,
    ];

}
