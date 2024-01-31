<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory, HasUuids;

    protected $guarded = [];

//    protected $fillable = ['user_id', 'uuid', 'context'];
    protected $primaryKey = 'uuid';
    protected $casts = [
        'context' => 'array'
    ];
}
