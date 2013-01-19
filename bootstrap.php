<?php

Autoloader::add_core_namespace('Antispam');

Autoloader::add_classes(array(
	/**
	 * Antispam classes.
	 */
	'Antispam\\Antispam'					=> __DIR__.'/classes/antispam.php',
	'Antispam\\Antispam_Driver'				=> __DIR__.'/classes/antispam/driver.php',
	
));
