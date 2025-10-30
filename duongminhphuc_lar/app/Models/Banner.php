<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
use SoftDeletes;
protected $table = 'banner';
protected $fillable = ['name', 'link', 'image', 'position', 'status'];
}
