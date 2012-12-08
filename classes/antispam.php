<?php
/**
 * FuelPHP Antispam package
 *
 * @package    Fuel
 * @author     Shiina, Yuji
 * @license    MIT License
 * @copyright  2012 Shiina, Yuji
 * @link       http://github.com/web2citizen/antispam
 */

namespace Antispam;

class Antispam
{
	/**
	 * Antispam driver forge.
	 *
	 * @param   array            $custom  config array
	 * @return  Antispam_Driver  one of the Antispam drivers
	 */
	public static function forge($custom = array())
	{
		$default = \Config::get('antispam', array());
		$config = array_merge($default, $custom);
		
		return new Antispam_Driver($config);
	}

	/**
	 * Init, config loading.
	 */
	public static function _init()
	{
		\Config::load('antispam', true);
	}
}
