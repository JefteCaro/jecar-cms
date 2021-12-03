<?php

namespace Jecar\Cms\Models;

use Jecar\Core\Models\Model;
use Illuminate\Support\Str;

class Page extends Model
{

    protected $fillable = [
        'name',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'meta_image',
        'published',
    ];

    protected $casts = [
        'published' => 'boolean',
    ];

}
