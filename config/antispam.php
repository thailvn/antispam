<?php
/**
 * FuelPHPのスパム対策パッケージ
 *
 * @package    Fuel
 * @author     Shiina, Yuji
 * @license    MIT License
 * @copyright  2012 Shiina, Yuji
 * @link       http://github.com/web2citizen/antispam
 */

return array(

	/**
	 * DB connection
	 */
	'db_connection' => null,

	/**
	 * DB table name of blacklist IP table
	 */
	'black_ip_table_name' => 'blackips',
	
	/**
	 * DB table name of contents blacklist table
	 */
	'black_word_table_name' => 'blackwords',
	
	/**
	 * IP column name of check table
	 */
	'ip_column_name' => 'create_user_ip',
	
	/**
	 * black post check term(mili seconds)
	 */
	'post_check_term' => 86400,
	
	/**
	 * black post check count
	 */
	'post_limit_count' => 10,
);
