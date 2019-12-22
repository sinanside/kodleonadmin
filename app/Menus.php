<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class Menus extends Model implements Sortable
{
    public function Localizations(){
        return $this->hasMany(localization::class);
    }
    protected $fillable = [
        'ad', 'url','language', 'type', 'active'
    ];

    use SortableTrait;

    public $sortable = [
        'order_column_name' => 'queue',
        'sort_when_creating' => true,
    ];
}
