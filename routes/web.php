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

Route::get('/subscriptions/index/{year}','SubscriptionController@index');
Route::get('/subscriptions/update','SubscriptionController@create');
Route::post('/subscriptions/update','SubscriptionController@store');

Route::get('/MemberSubscriptions/index/{year}','MemberSubscriptionController@index');
Route::get('/MemberSubscriptions/create','MemberSubscriptionController@create');
Route::post('/MemberSubscriptions/create','MemberSubscriptionController@store');

Route::get('/Receipts/index/{year}','ReceiptController@index');
Route::get('/Receipts/create','ReceiptController@create');
Route::post('/Receipts/create','ReceiptController@store');
Route::get('/Receipts/approve','ReceiptController@unapprovedList');
Route::post('/Receipts/approve','ReceiptController@approve');

Route::get('/JamathReceipts/create','JamathReceiptController@create');
Route::post('/JamathReceipts/create','JamathReceiptController@store');

Route::get('Majlis/getMembers/{id}',array('as'=>'majlis.getMembers','uses'=>'MembersController@membersAjax'));

Route::get('Payment/memberPending/{jamath}','PendingPaymentsController@memberIndex');
Route::get('Payment/jamathPending','PendingPaymentsController@jamathIndex');

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
