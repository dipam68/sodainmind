<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;
    // public $timestamps = false;
    public function getSubsciption(){
        return $this->hasOne('\App\Model\Subscription');
    }
}
