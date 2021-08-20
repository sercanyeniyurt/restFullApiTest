<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class missions extends Model
{
    protected $table = 'capsule_missions';
    protected $guarded = ['id'];
    public $timestamps = true;
}
