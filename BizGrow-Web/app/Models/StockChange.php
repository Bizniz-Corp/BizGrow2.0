<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StockChange extends Model
{
    use HasFactory;

    protected $table = 'stock_changes';
    protected $primaryKey = 'stock_change_id';
    protected $fillable = ['product_id', 'changes_date', 'changes_quantity'];
}
