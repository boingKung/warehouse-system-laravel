<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ProductBatch extends Model
{
    protected $fillable = ['batch_number', 'product_id', 'mfg_date', 'exp_date'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}