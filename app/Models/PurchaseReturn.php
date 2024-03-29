<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseReturn extends Model
{
    protected $fillable = ['purchase_id','quantity ',' date ','note'];

    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }

}
