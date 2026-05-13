<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ItemSerial extends Model
{
    protected $fillable = ['serial_number', 'product_id', 'batch_id', 'warehouse_id', 'status'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }
}
