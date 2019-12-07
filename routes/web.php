<?php

use Illuminate\Support\Facades\Redis;

Route::get('/', function(){
    return "Hello Everybody";
});

Route::get('mail', 'MailController@index');

