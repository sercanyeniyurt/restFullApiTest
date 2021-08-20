<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class capsule extends Model
{
    protected $table = 'capsule';
    protected $guarded = ['id'];
    public $timestamps = true;
}
