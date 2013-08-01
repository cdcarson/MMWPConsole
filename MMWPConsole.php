<?php
/*
Plugin Name: Modern Media WordPress Console
Plugin URI: http://modernmedia.co
Description:
Author: Chris Carson
Version: 1.0
Author URI: http://modernmedia.co
*/
MMWPConsole::inst();
class MMWPConsole {

	/**
	 * @var MMWPConsole
	 */
	private static $instance = null;

	/**
	 * Singleton pattern
	 *
	 * @return MMWPConsole
	 */
	public static function inst(){
		if (! self::$instance instanceof MMWPConsole){
			self::$instance = new MMWPConsole();
		}
		return self::$instance;
	}

	private $log = array();

	private function __construct(){
		$this->log = array();
		add_action('wp_footer', array($this, '_action_wp_footer'), 100);
	}

	public function _action_wp_footer(){
		echo PHP_EOL .'<script type="text/javascript">' . PHP_EOL;
		printf(
			'if(typeof(console) === \'undefined\') {
				var console = {}
				console.log = console.error = console.info = console.debug = console.warn = console.trace = console.dir = console.dirxml = console.group = console.groupEnd = console.time = console.timeEnd = console.assert = console.profile = function() {};
			}
			console.log(%s);',
			json_encode($this->log)
		);
		echo PHP_EOL .'</script>' . PHP_EOL;
	}



	public function add($label, $data){
		$this->log[] = array(
			'label' => $label,
			'data' => $data
		);
	}

	public function get_log(){
		return $this->log;
	}

}