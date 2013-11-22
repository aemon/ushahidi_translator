<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Performs install/uninstall methods for the Translator Plugin
 *

 */
class Translator_Install {
	
	/**
	 * Constructor to load the shared database library
	 */
	public function __construct()
	{
		$this->db = new Database();
        $this->character_set = Kohana::config('database.character_set');
        if (!empty($this->character_set)){
            $this->character = ' DEFAULT CHARSET '.$this->character_set.' ';
        }
        else
            $this->character = '';
	}

	/**
	 * Creates the required tables
	 */
    public function run_install()
    {
        // create database tables
        $this->db->query("CREATE TABLE IF NOT EXISTS `".Kohana::config('database.default.table_prefix')."translator` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `location` varchar(10) NOT NULL,
              `element_id` int(11) NOT NULL,
              `field` varchar(255) NOT NULL,
              `value` text NOT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB  DEFAULT CHARSET=utf8");
     
        // ****************************************
    }

	/**
	 * Drops the table
	 */
	public function uninstall()
	{
        $this->db->query("DROP TABLE `".Kohana::config('database.default.table_prefix')."translator`;");
		}
}
