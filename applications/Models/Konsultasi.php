<?php
namespace App\Models;
use Model;

class Konsultasi extends Model
{
    static $table = "konsultasi";

    function items()
    {
    	return $this->hasMany(KonsultasiItem::class,['id_konsultasi'=>'id']);
    }

    function user()
    {
    	return $this->hasOne(User::class,['id'=>'id_user']);
    }
}