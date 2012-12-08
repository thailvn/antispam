<?php

namespace Fuel\Tasks;

class Spamcheck
{
	public static function set_black_ips($table_name = null)
	{
		if(empty($table_name))
			return \Cli::color("Usage Spamcheck table_name", 'green');

		$count = \Antispam::forge()->set_black_ip($table_name);
		return \Cli::color($count."ips insert into black iplist", 'green');
	}
	
	public static function set_black_words($table_name = null, $column_name = null)
	{
		if(empty($table_name) or empty($column_name))
			return \Cli::color("Usage Spamcheck table_name column_name", 'green');

		$count = \Antispam::forge()->set_black_word($table_name, $column_name);
		return \Cli::color($count."words insert into black iplist", 'green');
	}
}
