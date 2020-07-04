<?php
namespace App\Models;
use Model;

class Shipping extends Model
{
	static $table = "shipping";

	function items()
	{
		return $this->hasMany(ShippingItem::class,['id_shipping'=>'id']);
	}
}