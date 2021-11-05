<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Data extends Model
{
    use HasFactory;
    protected $fillable = ['ld', 'full_name', 'branch_code','product', 'plafond', 'atr', 'outstanding', 'owner', 'reconciled_data_id','date', 'product_code', 'branch_name', 'payment_status'];

    public function renconciledDatas()
    {
        return $this->hasOne(ReconciledData::class, 'reconciled_data_id');
    }

}
