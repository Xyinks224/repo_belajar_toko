<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    protected $table = 'orders';
    public $timestamps = false;

    protected $fillable = ['id_customers', 'id_product', 'tanggal_pesan', 'tanggal_datang', 'Pembayaran'];
}
