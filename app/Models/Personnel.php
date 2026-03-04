<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Personnel extends Model 
{
   //

    use HasFactory;
    protected $guarded = ['id'];



    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'id');
    }
    
    public function role()
    {
        return $this->user->role();
    }
}
