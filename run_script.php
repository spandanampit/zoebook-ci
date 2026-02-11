<?php
// Set the correct path to your shell script
$scriptPath = '/var/www/bit73.mydevfactory.com/abhisek/zoebook/permission.sh';

// Execute the shell script
$output = shell_exec("bash $scriptPath 2>&1");

// Output the result (for debugging purposes)
echo $output;
?>
