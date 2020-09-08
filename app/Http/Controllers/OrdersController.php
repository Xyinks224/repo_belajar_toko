<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Orders;
use Illuminate\Support\Facades\Validator;

class OrdersController extends Controller
{
	public function show()
	{
		$data_orders = Orders::join('customers', 'customers.id_customers', 'orders.id_customers')
					   ->join('product','product.id_product', 'orders.id_product')
					   ->select('orders.id_orders'			,
					   			'orders.id_customers'  		,
    			 				'orders.id_product'			,
    			 				'customers.nama_customers' 	,
    			 				'product.nama_product'		,
    			 				'product.jenis_product'		,
    			 				'orders.tanggal_pesan' 		,
    			 				'orders.tanggal_datang'		,
    			 				'customers.alamat'			,
    			 				'orders.Pembayaran'     	)
					   ->get();

		return Response()->json($data_orders);
	}

	public function store(Request $request)
	{
		    	$validator=Validator::make($request->all(),
    		[
    			'id_customers'   => 'required',
    			'id_product'	 =>	'required',
    			'tanggal_pesan'  => 'required',
    			'tanggal_datang' => 'required',
    			'Pembayaran'	 => 'required'
    		]
		);

		if ($validator->fails()) {
			return Response()->json($validator->errors());
		}

		$simpan = Orders::create([
				'id_customers'   => $request->id_customers	 ,
				'id_product'	 => $request->id_product	 ,
				'tanggal_pesan'  => $request->tanggal_pesan	 ,
				'tanggal_datang' => $request->tanggal_datang ,
				'Pembayaran'	 => $request->Pembayaran
		]);

		if ($simpan) 
		{
			return Response()->json(['status' => 1]);
		}
		else
		{
			return Response()->json(['status' => 0]);	
		}
	}

	public function update($id, Request $request )
	{
		$validator=Validator::make($request->all(),
			[
    			'id_customers'   => 'required',
    			'id_product'	 =>	'required',
    			'tanggal_pesan'  => 'required',
    			'tanggal_datang' => 'required',
    			'Pembayaran'	 => 'required'
			]
		);

		if ($validator->fails()) 
		{
			return Response()->json($validator->errors());
		}

		$ubah = Orders::where('id_orders', $id)->update
		(
			[
				'id_customers'   => $request->id_customers	 ,
				'id_product'	 => $request->id_product	 ,
				'tanggal_pesan'  => $request->tanggal_pesan	 ,
				'tanggal_datang' => $request->tanggal_datang ,
				'Pembayaran'	 => $request->Pembayaran
			]
		);

		if ($ubah) 
		{
			return Respone()->json(['status' => 1]);
		} 

		else 
		{
			return Respone()->json(['status' => 0]);
		}		
	}	
}