<?php
	class City {
		private $db;

		public function __construct($dbConfig) {
			try {
				$this->db = new mysqli($dbConfig['host'], $dbConfig['username'], $dbConfig['password'], $dbConfig['db_name']);
			} catch(Exception $e) {
				die("Błędne połączenie z baządanych: " . $e->getMessage());
			}
		}

		public function getCities() {
			$stmt = $this->db->prepare("SELECT DISTINCT id, name FROM cities ORDER BY name ASC");
			$stmt->execute();
			return $stmt->get_result();
		}

	}