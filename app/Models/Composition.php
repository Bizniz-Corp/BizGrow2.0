<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Composition extends Model
{
    use HasFactory;

    protected $table = 'compositions';
    protected $primaryKey = 'composition_id';
    protected $fillable = ['composition_name','composition_quantity', 'current_composition_price', 'product_id'];
   
}
