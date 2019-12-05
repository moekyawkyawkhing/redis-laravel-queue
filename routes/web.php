<?php

Route::get('/', function(){
    return "Hello Everybody";
});

Route::get('mail', 'MailController@index');

