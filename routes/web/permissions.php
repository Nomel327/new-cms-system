<?php


Route::get('/permissions', 'PermissionController@index')->name('permissions.index');

Route::post('/permissions', 'PermissionController@store')->name('permissions.store');

Route::delete('/permissions/{permission}/destroy', 'PermissionController@destroy')->name('permissions.destroy');

Route::get('/permissions/{permission}/edit', 'PermissionController@edit')->name('permissions.edit');

Route::put('/permissions/{permission}/update', 'PermissionController@update')->name('permissions.update');

Route::put('/permissions/{permission}/attach', 'PermissionController@attach_permission')->name('permission.role.attach');

Route::put('/permissions/{permission}/detach', 'PermissionController@detach_permission')->name('permission.role.detach');