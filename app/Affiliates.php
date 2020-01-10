<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class Affiliates extends Model implements Sortable
{
    use Sluggable;

    protected $fillable = [
        'name', 'city', 'region', 'address', 'tel', 'short_description1', 'short_description2', 'short_description3', 'picture1', 'picture2', 'picture3', 'picture4',
        'picture5', 'picture6', 'picture7', 'picture8', 'description1', 'special_code','language','active'
    ];
    protected $table = 'affiliates';

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
        return static::query()->where('language', $this->language);
    }

    public $sortable = [
        'order_column_name' => 'queue',
        'sort_when_creating' => true,
    ];
}
