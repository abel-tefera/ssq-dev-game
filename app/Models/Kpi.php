<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kpi extends Model
{
    protected $fillable = ['email', 'year', 'month', 'value', 'type', 'subtype'];

    use HasFactory;
}
