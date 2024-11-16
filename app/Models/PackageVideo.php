<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackageVideo extends Model
{
    use HasFactory;

    protected $table = 'package_videos';

    protected $fillable = [
        'package_id',
        'video_id',
    ];
}

?>