<?php
namespace App\Models;
use Model;

class ShippingItem extends Model
{
    static $table = "shipping_item";

    function shipping()
    {
    	return $this->hasOne(Shipping::class,['id'=>'id_shipping']);
    }
}