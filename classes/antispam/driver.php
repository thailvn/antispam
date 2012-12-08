<?php
/**
 * Antispam package driver
 *
 * @package    Fuel
 * @author     Shiina, Yuji
 * @license    MIT License
 * @copyright  2012 Shiina, Yuji
 * @link       http://github.com/web2citizen/antispam
 */

namespace Antispam;

class Antispam_Driver
{
	/**
	 * Driver config
	 */
	protected $config = array();
	
	/**
	 * Driver constructor
	 *
	 * @param  array  $config  driver config
	 */
	public function __construct(array $config)
	{
		$this->config = $config;
	}
	

	/**
	 * Check post IP address and words
	 *
	 * @param   string   $contents  post contents
	 * @return  boolean  check resut
	 */
	public function check_post($contents)
	{
		return $this->check_ip() and $this->check_word($contents);
	}

	/**
	 * Check post IP address and words
	 *
	 * @return  boolean  check resut
	 */
	public function check_ip()
	{
		$count_check = \DB::select('ip')
					->from($this->config['black_ip_table_name'])
					->where('ip', '=', \Input::real_ip())
					->where('active', '=', 1)
					->execute($this->config['db_connection'])->count();
		return $count_check === 0;
	}

	/**
	 * Check post contents include black word
	 *
	 * @param   string   $contents  post contents
	 * @return  boolean  check resut
	 */
	public function check_word($contents)
	{
		$black_words = \DB::select('word')
					->from($this->config['black_word_table_name'])
					->where('active', '=', 1)
					->execute($this->config['db_connection']);
		
		foreach ($black_words as $word)
			if(stristr($contents, $word) !== FALSE) return false;

		return true;
	}
	
	/**
	 * auto set black ip from posts.
	 *
	 * @param   string   $table_name  check table name.
	 * @param   int      $activee     0:reserve, 1:active, -1:white list
	 */
	public function set_black_ip($table_name, $active = 0)
	{
		$registed_ips = \DB::select('ip')
					->from($this->config['black_ip_table_name'])
					->execute($this->config['db_connection']);
		
		$ip = $this->config['ip_column_name'];
		$data_time_now = \Date::time()->get_timestamp();
		$query = \DB::select_array(array($ip, \DB::expr('COUNT(*) as count')))
					->from($table_name)
					->where('created_at', '>', $data_time_now - $this->config['post_check_term']);
		if(count($registed_ips) > 0)
			$query->where($ip, 'not in', $registed_ips->as_array());
		$blackip_list = $query->group_by($ip)
					->having('count', '>', $this->config['post_limit_count'])
					->execute();
		
		foreach($blackip_list as $black_ip)
		{
			\DB::insert($this->config['black_ip_table_name'])
				->set(array('ip' => $black_ip[$ip],
							'active' => $active,
							'created_at' => $data_time_now,
							'updated_at' => $data_time_now,
					))
				->execute($this->config['db_connection']);
		}
		return count($blackip_list);
	}
	
	/**
	 * auto set black word from posts
	 *
	 * @param   string   $table_name  check table name
	 * @param   string   $table_column  check column name
	 * @param   int      $activee     0:reserve, 1:active, -1:white list
	 */
	public function set_black_word($table_name, $column_name, $active = 0)
	{
		$registed_words = \DB::select('word')
					->from($this->config['black_word_table_name'])
					->execute($this->config['db_connection']);
		
		$data_time_now = \Date::time()->get_timestamp();
		$query = \DB::select_array(array($column_name, \DB::expr('COUNT(*) as count')))
					->from($table_name)
					->where('created_at', '>', $data_time_now - $this->config['post_check_term']);
		if(count($registed_words) > 0)
			$query->where($column_name, 'not in', $registed_words->as_array());
		$blackword_list = $query->group_by($column_name)
					->having('count', '>', $this->config['post_limit_count'])
					->execute();
		
		foreach($blackword_list as $black_word)
		{
			\DB::insert($this->config['black_word_table_name'])
				->set(array('word' => $black_word[$column_name],
							'active' => $active,
							'created_at' => $data_time_now,
							'updated_at' => $data_time_now,
						))
				->execute($this->config['db_connection']);
		}
		return count($blackword_list);
	}
}