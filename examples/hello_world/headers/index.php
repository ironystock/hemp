<?php 
declare(strict_types=1);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once( "../../../system/HEMP.php" ); 
$HEMP = HEMP::getInstance( config_location: "../../../config/HEMP.ini" );
$Headers = $HEMP->getHeaders();
?><article><header><h1>HTMX Headers</h1></header><ol><?php
foreach ( $Headers as $Name => $Val )
{
	?><li><em>HX-<?= $Name ?></em>: <?= $Val ?></li><?php
}?></ol></article>