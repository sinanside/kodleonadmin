<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class Activities extends Model implements Sortable
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
    protected $fillable = [
    'start_date','end_date','tur','title', 'meta_title', 'meta_description', 'meta_keywords', 'short_description1', 'short_description2', 'short_description3', 'short_description4', 'short_description5', 'short_description6', 'short_description7', 'short_description8', 'short_description9', 'short_description10', 'link1_text','link1_href', 'link2_text','link2_href', 'link3_text','link3_href', 'link4_text','link4_href', 'link5_text','link5_href', 'link6_text','link6_href','picture1', 'picture1_alt', 'picture2', 'picture2_alt', 'picture3', 'picture3_alt', 'picture4', 'picture4_alt',
        'picture5', 'picture5_alt', 'picture6', 'picture6_alt', 'picture7', 'picture7_alt', 'picture8', 'picture8_alt', 'description1', 'description2', 'description3', 'description4', 'description5', 'description6', 'description7', 'description8',  'active'
];

    public  function localization(){
        return $this->belongsTo(Localizations::class,'language');
    }

    use SortableTrait;

    public $sortable = [
    'order_column_name' => 'queue',
    'sort_when_creating' => true,
];
}
