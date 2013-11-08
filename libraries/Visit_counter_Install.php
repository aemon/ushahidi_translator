<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Performs install/uninstall methods for the Mark Plugin
 *

 */
class Mark_Install {
	
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
        $this->db->query("CREATE TABLE IF NOT EXISTS `".Kohana::config('database.default.table_prefix')."marks` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `name` varchar(50) NOT NULL,
        PRIMARY KEY (`id`)
        ) ENGINE=InnoDB ".$this->character);
        // ****************************************		
        $this->db->query("CREATE TABLE IF NOT EXISTS `".Kohana::config('database.default.table_prefix')."marks_to_units` (
        `id_marks` int(11) NOT NULL,
        `id_units` int(11) NOT NULL
        ) ENGINE=InnoDB ".$this->character);
        // ****************************************
    }

	/**
	 * Drops the table
	 */
	public function uninstall()
	{
        $this->db->query("DROP TABLE `".Kohana::config('database.default.table_prefix')."marks`;");
		$this->db->query("DROP TABLE `".Kohana::config('database.default.table_prefix')."marks_to_units`;");
	}
}