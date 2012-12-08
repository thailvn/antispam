<?php
/**
 * Antispam package Tests
 *
 * @group Antispam
 */

//require_once 'mock_input.php';

class Test_Antispam extends TestCase
{
	public function test_check_post()
	{
		$test = Antispam::forge()->check_post("test");
		$expected = true;
		$this->assertEquals($expected, $test);
	}
	
	public function test_check_ip()
	{
		$test = Antispam::forge()->check_ip();
		$expected = true;
		$this->assertEquals($expected, $test);
	}
	
	public function test_check_contents()
	{
		$test = Antispam::forge()->check_word("test");
		$expected = true;
		$this->assertEquals($expected, $test);
	}
}