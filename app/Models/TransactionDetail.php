<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    protected $fillable = [
        'transaction_id', 
        'product_id', 
        'batch_id', 
        'serial_id', 
        'quantity'
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // เพิ่มความสัมพันธ์เพื่อให้เรียกใช้ details.serial ได้
    public function serial()
    {
        return $this->belongsTo(ItemSerial::class, 'serial_id');
    }

    // เพิ่มความสัมพันธ์เพื่อให้เรียกใช้ details.batch ได้
    public function batch()
    {
        return $this->belongsTo(ProductBatch::class, 'batch_id');
    }
}