<?php

class Model {
		public $mysqli;
		function __construct() {
			$this->mysqli = new mysqli("127.0.0.1","root","","blog");
			$this->mysqli->query('set names utf8');
		}
}