<?php 

// Base url to this app
define('BASE_URL', 'http://'.$_SERVER['HTTP_HOST']);

// Url to picast
define('YTC_URL', 'http://127.0.0.1:3000/');

// Google Develop Key 
define('GOOGLE_DEVELOPER_KEY', 'INSERT_YOUR_GOOGLE_DEVELOPER_KEY_HERE');

define('CACHEPATH', __DIR__.'/storage/cache');

define('YTC_CACHEPATH', CACHEPATH.'/ytc_cache');