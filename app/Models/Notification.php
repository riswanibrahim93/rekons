<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    protected $fillable = [
        'for',
        'from',
        'filing_id',
    ];

    public function filing(){
        return $this->hasOne(Filing::class);
    }
}
