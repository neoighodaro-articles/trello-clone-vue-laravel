<?php

Route::get('/{any}', 'SinglePageController@index')->where('any', '.*');
