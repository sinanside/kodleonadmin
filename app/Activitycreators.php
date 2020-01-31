<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class Activitycreators extends Model implements Sortable
{
    use Sluggable;

    protected $fillable = [
        'tur', 'activity_id', 'name', 'short_description1', 'short_description2', 'youtube_link', 'video_link', 'picture_link', 'language', 'active'
    ];

    public  function activity(){
        return $this->belongsTo(Activities::class,'activity_id');
    }
    public  function localization(){
        return $this->belongsTo(Localizations::class,'language');
    }



    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    use SortableTrait;

    public function buildSortQuery()
    {
        return static::query()->where('activity_id', $this->activity_id);
    }

    public $sortable = [
        'order_column_name' => 'queue',
        'sort_when_creating' => true,
    ];
}
