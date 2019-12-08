<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class Extraskampanya extends Model implements Sortable
{
    protected $fillable = [
        'slug','title', 'picture', 'icon', 'short_content1', 'short_content2', 'short_content3', 'description', 'active'
    ];

    use SortableTrait;

    public $sortable = [
        'order_column_name' => 'queue',
        'sort_when_creating' => true,
    ];
    public function buildSortQuery()
    {
        return static::query()->where('slug', 'kampanya');
    }

    protected $table = 'extras';

}
