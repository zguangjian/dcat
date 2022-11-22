<?php

use Illuminate\Support\Facades\Route;

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

    $host = '127.0.0.1:8801';
    $client = new \App\Grpc\UserGrpc($host, [
        'credentials'=>\Grpc\ChannelCredentials::createInsecure()
    ]);
    $request = new \UserProto\listRequest();
    $request->setSize("赵光健");
    $request->setKeyword("zgj");
    $call = $client->userList($request);
    list($response, $status) = $call->wait();
    dd($response);
    dd($response);
    return view('welcome');
});



