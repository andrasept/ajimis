<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Line extends Model
{
    use HasFactory;

    protected $fillable=["line_code","line_name","line_category","tonase","updated_by" ];
    protected $table = "delivery_lines";
}
