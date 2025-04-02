<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HeroSection extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'achievement',
        'heading',
        'subheading',
        'path_video',
        'banner'
    ];
}
