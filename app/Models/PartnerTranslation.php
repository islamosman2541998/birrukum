<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PartnerTranslation extends Model
{
    use HasFactory;

    protected $fillable = [
        'partner_id',
        'locale',
        'title',
        'description',
    ];
}