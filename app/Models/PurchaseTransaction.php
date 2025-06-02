<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PurchaseTransaction extends Model
{
    use HasFactory;

    protected $table = 'purchase_transactions';
    protected $primaryKey = 'purchase_id';
    protected $fillable = ['product_id', 'purchase_date', 'purchase_quantity','price_per_item', 'total'];

}
