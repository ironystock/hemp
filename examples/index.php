<?php 
declare(strict_types=1);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once( "../system/HEMP.php" ); 
$HEMP = HEMP::getInstance( config_location: "../config/HEMP.ini" );
?>
<pre><?php print_r( $HEMP ); ?></pre>