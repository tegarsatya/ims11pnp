<?php
	date_default_timezone_set('Asia/Jakarta');
	class DBB {
		private $server		= "mysql:host=127.0.0.1; dbname=erpb-trancking";
		private $user		= "root";
		private $pass		= "root";
		private $options	= array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,);
		protected $con;
		public function open() {
			try {
				$this->con = new PDO($this->server, $this->user,$this->pass,$this->options);
				return $this->con;
			} catch (PDOException $e) {
				print_r($e->getMessage());
				// return("error");
			}
		}
		public function close() {
			$this->con = null;
		}
	}
?>