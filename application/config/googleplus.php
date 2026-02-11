<?php
/*$config['googleplus']['application_name'] = 'Zoebook';
$config['googleplus']['client_id'] = '257773956940-labeo57ja32ckd5mvq1bkpfhh0qu0nnk.apps.googleusercontent.com';
$config['googleplus']['client_secret'] = 'QlSzugssFbxHEGZ6JWTrrWRM';
$config['googleplus']['redirect_uri'] = 'http://localhost/zoeybooks_004312/google_signup_action.html';  // google_signup_action.html
$config['googleplus']['api_key'] = '';*/
?>
<?php
$CI =& get_instance();

$config['googleplus']['application_name'] = $CI->config->item('GOOGLE_APPLICATIONNAME');
$config['googleplus']['client_id'] = $CI->config->item('GOOGLE_CLIENTID');
$config['googleplus']['client_secret'] = $CI->config->item('GOOGLE_CLIENTSECRET');
$config['googleplus']['redirect_uri'] = $CI->config->item('site_url').'google_signup_action.html';  // google_signup_action.html
$config['googleplus']['api_key'] = '';
?>
