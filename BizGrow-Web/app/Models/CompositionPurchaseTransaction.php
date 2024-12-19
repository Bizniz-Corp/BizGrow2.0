<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CompositionPurchaseTransaction extends Model
{
    use HasFactory;

    protected $table = 'composition_purchase_transactions';
    protected $primaryKey = 'composition_purchase_id';
    protected $fillable = ['composition_id', 'composition_purchase_date', 'composition_purchase_quantity','composition_price_per_item', 'total'];

}
