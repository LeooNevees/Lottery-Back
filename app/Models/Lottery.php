<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lottery extends Model
{
    use HasFactory;

    protected $table = 'lottery';
    
    /**
     * The attributes that are mass assignable.
     */
    
    protected $fillable = [
        'name',
        'numbers',
        'sortition_id',
        'ticketCode',
        'situation_id',
    ];
}
