<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
	public function destroy($id)
    {
        $hapus = Product::where('id_product', $id)->delete();
        if ($hapus) 
        {
            return Response()->json(['status' => 1]);
        } 
        
        else 
        {
            return Response()->json(['status' => 0]);
        }      
    }

    public function update($id, Request $request)
	{
		$validator=Validator::make($request->all(),
			[
    			'nama_product'  => 'required',
    			'jenis_product' => 'required'
			]
		);

		if ($validator->fails()) 
		{
			return Response()->json($validator->errors());
		}

		$ubah = Product::where('id_product', $id)->update
		(
			[
				'nama_product'  => $request->nama_product,
				'jenis_product'	=> $request->jenis_product
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

	public function show()
	{
		$data_product = Product::all();	  

		return Response()->json($data_product);
	}

	public function detail($id)
	{
		if (Product::where('id_product', $id)->exists()) 
		{
			$data_product = Product::all()
						  ->where('id_product', '=', $id);

			return Response()->json($data_product);
		} 

		else 
		{
			return Response()->json(['message' => '!!Data Tidak Ditemukan!!']);
		}
		
	}
	   
	public function store(Request $request)
	{
			$validator=Validator::make($request->all(),
    		[
    			'nama_product'  => 'required',
    			'jenis_product' => 'required'
    		]
		);

		if ($validator->fails()) {
			return Response()->json($validator->errors());
		}

		$simpan = Product::create([
				'nama_product'  => $request->nama_product,
				'jenis_product'	=> $request->jenis_product			
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
}    