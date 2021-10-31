<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Data extends Model
{
    use HasFactory;
    protected $fillable = ['reconciled_data_id','ld', 'full_name', 'branch_code','product', 'plafond', 'atr', 'outstanding', 'owner'];

    public function renconciledDatas()
    {
        return $this->hasOne(ReconciledData::class, 'reconciled_data_id');
    }

}
