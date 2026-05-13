<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = ['code', 'name'];

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
