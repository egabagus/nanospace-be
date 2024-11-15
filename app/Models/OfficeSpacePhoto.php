<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OfficeSpacePhoto extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "office_space_photos";
    public $timestamps = true;
    protected $guarded = [];
}
