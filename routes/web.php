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
use App\Majlis;

Route::get('/', 'PagesController@home');
Route::get('users/register', 'Auth\RegisterController@showRegistrationForm');
Route::post('users/register', 'Auth\RegisterController@register');
Route::get('home', 'PagesController@home');
Route::get('test', 'PagesController@test');

Route::get('members/create', 'MembersController@create');
Route::post('members/create', 'MembersController@insert');
Route::get('members/index', 'MembersController@index');
Route::get('/member/{id?}', 'MembersController@show');
Route::get('/member/{id?}/edit','MembersController@edit');
Route::post('/member/{id?}/edit','MembersController@update');
Route::post('/member/{id?}/delete','MembersController@destroy');

Route::get('/rates/index','AnnualRateController@index');
Route::get('/rates/update','AnnualRateController@create');
Route::post('/rates/update','AnnualRateController@store');

Route::get('/Subscriptions/index','SubscriptionController@index');
Route::get('/Subscriptions/create','SubscriptionController@create');
Route::post('/Subscriptions/create','SubscriptionController@store');
Route::get('/Subscription/{id?}', 'SubscriptionController@show');
Route::get('/Subscription/{id?}/edit','SubscriptionController@edit');
Route::post('/Subscription/{id?}/edit','SubscriptionController@update');
Route::post('/Subscription/{id?}/delete','SubscriptionController@destroy');

Route::get('/Receipts/index','ReceiptController@index');
Route::get('/Receipts/create','ReceiptController@create');
Route::post('/Receipts/create','ReceiptController@store');
Route::get('/Receipt/{id?}','ReceiptController@show');
Route::get('/Receipt/{id?}/edit','ReceiptController@edit');
Route::post('/Receipt/{id?}/edit','ReceiptController@update');
Route::post('/Receipt/{id?}/delete','ReceiptController@destroy');
Route::get('/Receipts/approve','ReceiptController@unapprovedList');
Route::post('/Receipts/approve','ReceiptController@approve');


Route::get('/JamathReceipts/create','JamathReceiptController@create');
Route::post('/JamathReceipts/create','JamathReceiptController@store');
Route::get('/JamathReceipts/index','JamathReceiptController@index');
Route::get('/JamathReceipt/{id?}','JamathReceiptController@show');
Route::get('/JamathReceipt/{id?}/edit','JamathReceiptController@edit');
Route::post('/JamathReceipt/{id?}/edit','JamathReceiptController@update');
Route::post('/JamathReceipt/{id?}/delete','JamathReceiptController@destroy');

Route::get('Jamath/getMembers/{id}',array('as'=>'jamath.getMembers','uses'=>'MembersController@membersAjax'));

Route::get('Payment/memberPending/{jamath}/{year}','PendingPaymentsController@memberIndex');
Route::get('Payment/jamathPending/{year}','PendingPaymentsController@jamathIndex');

Route::get('Test','TestController@test');

Route::get('sendemail', function () {

    $data = array(
        'name' => "Learning Laravel",
    );

    Mail::send('emails.welcome', $data, function ($message) {

        $message->from('nishanahmad@gmail.com', 'Learning Laravel');

        $message->to('nishanahmad@gmail.com')->subject('Learning Laravel test email');

    });

    return "Your email has been sent successfully";

});
Auth::routes();
