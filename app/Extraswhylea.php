<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class Extraswhylea extends Model implements Sortable
{
    protected $fillable = [
        'slug','title', 'picture', 'icon', 'description', 'active'
    ];

    use SortableTrait;

    public $sortable = [
        'order_column_name' => 'queue',
        'sort_when_creating' => true,
    ];
    public function buildSortQuery()
    {
        return static::query()->where('slug', 'whylea');
    }

    protected $table = 'extras';

}
