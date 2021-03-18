<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;
    protected $primaryKey = 'banner_id';
    protected $fillable = ['banner_img', 'banner_description', 'user_id'];
    protected $hidden = ['created_at', 'updated_at'];
}
