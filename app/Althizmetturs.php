<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class Althizmetturs extends Model implements Sortable
{
    use Sluggable;

    public function Althizmetturs(){
        return $this->hasMany(althizmettur::class);
    }

    public  function hizmettur(){
        return $this->belongsTo(Hizmetturs::class,'hiz_id');
    }
    public  function localization(){
        return $this->belongsTo(Localizations::class,'language');
    }
    protected $fillable = [
        'hiz_id','title', 'short_description', 'photo',  'photo_alt','queue', 'language', 'mainpage','active'
    ];

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
