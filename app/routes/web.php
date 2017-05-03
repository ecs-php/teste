<?php


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix' => 'api/v1', 'middleware' => 'auth:api'] ,function()
{   
    
    Route::post('employees', 'EmployeeController@listAll');
    Route::post('employee/create', 'EmployeeController@create');
    Route::post('employee/{id}', 'EmployeeController@item');
   
    
    Route::post('employee/update/{id}', 'EmployeeController@update');
    Route::post('employee/remove/{id}', 'EmployeeController@remove');

});
