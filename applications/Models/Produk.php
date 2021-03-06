<?php
namespace App\Models;
use Model;

class Produk extends Model
{
    static $table = "produk";

    function kategori()
    {
    	return $this->hasOne(Kategori::class, ['id'=>'id_kategori']);
    }

    function transactions()
    {
    	return $this->hasMany(TransaksiItem::class,['id_produk'=>'id']);
    }
}