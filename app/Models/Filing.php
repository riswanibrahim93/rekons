<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Filing extends Model
{
    use HasFactory;
    protected $fillable = ['file', 'ld', 'from', 'notification_id'];
}
