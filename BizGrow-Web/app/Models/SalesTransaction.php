<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SalesTransaction extends Model
{
    use HasFactory;
    protected $table = 'sales_transactions';
    protected $primaryKey = 'sales_id';
    protected $fillable = ['product_id','sales_date', 'sales_quantity', 'price_per_item', 'total'];

}
