<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sortition extends Model
{
    use HasFactory;

    protected $table = 'sortition';
    
    /**
     * The attributes that are mass assignable.
     */
    
    protected $fillable = [
        'situation_id',
    ];
}
