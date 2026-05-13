<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = ['type', 'status', 'employee_id', 'from_warehouse_id', 'to_warehouse_id'];

    public function details()
    {
        return $this->hasMany(TransactionDetail::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    // แก้ไขชื่อฟังก์ชันให้ตรงกับใน Controller (image_3c9717.png บรรทัดที่ 19)
    public function fromWarehouse()
    {
        return $this->belongsTo(Warehouse::class, 'from_warehouse_id');
    }

    public function toWarehouse()
    {
        return $this->belongsTo(Warehouse::class, 'to_warehouse_id');
    }
}