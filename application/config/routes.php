<?php
$route['default_controller'] = 'api/auth';
$route['api/mail/(:any)'] = 'api/mail';
$route['api/element/(:any)'] = 'api/element';

$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
