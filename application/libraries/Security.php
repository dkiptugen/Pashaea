<?php
class MY_Security extends CI_Security
	{
		public function __construct()
			{
				parent::__construct()
			}
		public function csrf_show_error()
			{
			# code...
				header('location:'.htmlspecialchars($_SERVER['REQUEST_URI']));
			}
	}