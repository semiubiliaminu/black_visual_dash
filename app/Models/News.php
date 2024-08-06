<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        //'name',
        'end_year',
            'citylng',
            'citylat',
            'intensity',
            'sector',
            'topic',
            'insight',
            'swot',
            'url',
            'region',
           'start_year',
            'impact',
           'added',
            'published',
            'city',
            'country',
            'relevance',
            'pestle',
            'source',
            'title',
            'likelihood'
    ];

}
