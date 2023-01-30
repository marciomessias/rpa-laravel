<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RpaTableData extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'amount'
    ];

    public $timestamps = false;
}
