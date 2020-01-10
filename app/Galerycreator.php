<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class Galerycreator extends Model implements Sortable
{
    use Sluggable;

    protected $fillable = [
        'name', 'hiz_id', 'althiz_id','language', 'short_description1', 'short_description2', 'description1', 'picture1', 'picture1_alt', 'language','active'
    ];

    public  function hizmettur(){
        return $this->belongsTo(Hizmetturs::class,'hiz_id');
    }
    public  function althizmettur(){
        return $this->belongsTo(Althizmetturs::class,'althiz_id');
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

    public $sortable = [
        'order_column_name' => 'queue',
        'sort_when_creating' => true,
    ];
}
