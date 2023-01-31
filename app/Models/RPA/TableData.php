<?php

namespace App\Models\RPA;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TableData extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'amount'
    ];

    public $timestamps = false;
}
