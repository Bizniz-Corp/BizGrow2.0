<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CompositionStockChange extends Model
{
    use HasFactory;

    protected $table = 'composition_stock_changes';
    protected $primaryKey = 'composition_stock_changes_id';
    protected $fillable = ['composition_id', 'composition_changes_date', 'composition_changes_quantity', 'total_composition_stock'];

}
