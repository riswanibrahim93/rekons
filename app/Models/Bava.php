<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bava extends Model
{
    use HasFactory;
    protected $fillable = ['ld', 'branch_code','file'];

    public function branch(){
        return $this->hasOne(Branch::class,'ld','branch_code');
    }
}
