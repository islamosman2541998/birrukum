<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PageContentTranslation extends Model
{
    use HasFactory;

    protected $fillable = [
        'page_content_id',
        'locale',
        'title',
        'description',
    ];
}