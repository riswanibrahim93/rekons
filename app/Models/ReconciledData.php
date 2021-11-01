<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReconciledData extends Model
{
    use HasFactory;
    protected $fillable = ['data_id', 'status', 'description'];
    public function data(){
        return $this->hasOne(Data::class, 'id', 'data_id');
    }
}
