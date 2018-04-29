<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::group(['middleware' => ['admin'], 'namespace' => 'Admin'], function() {
   CRUD::resource('transaction', 'TransactionCrudController');
   CRUD::resource('recurring-transaction', 'RecurringTransactionCrudController');
   CRUD::resource('bank-account', 'BankAccountCrudController');

   Route::get('calendar', 'CalendarController@index')->name('calendar');
});
