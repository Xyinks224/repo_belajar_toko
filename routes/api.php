<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('/register', 'UserController@register');
Route::post('/login', 'UserController@login');

Route::group(['middleware' => ['jwt.verify']], function() 
	{    
		Route::group(['middleware' => ['api.superadmin']], function()
			{
				Route::delete('/customers/{id_customers}', 'CustomersController@destroy');
				Route::delete('/product/{id_product}', 'ProductController@destroy');
				Route::delete('/orders/{id_orders}', 'OrdersController@destroy');
			}
		);

		Route::group(['middleware' => ['api.admin']], function()
			{
				Route::post('/customers', 'CustomersController@store');
				Route::put('/customers/{id_customers}', 'CustomersController@update');

				Route::post('/product', 'ProductController@store');		
				Route::put('/product/{id_product}', 'ProductController@update');

				Route::post('/orders', 'OrdersController@store');		
				Route::put('/orders/{id_orders}', 'OrdersController@update');				
			}
		);
		
		Route::get('/customers', 'CustomersController@show');
		Route::get('/customers/{id_customers}', 'CustomersController@detail');


		Route::get('/product', 'ProductController@show');
		Route::get('/product/{id_product}', 'ProductController@detail');
		

		Route::get('/orders', 'OrdersController@show');
		Route::get('/orders/{id_orders}', 'OrdersController@detail');
}
);