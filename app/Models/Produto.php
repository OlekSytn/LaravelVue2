<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    use HasFactory;
    protected $primaryKey = 'CD_PRODUTO';
    protected $fillable = [
        'NM_PRODUTO',
        'VL_PRODUTO'
    ];
}
