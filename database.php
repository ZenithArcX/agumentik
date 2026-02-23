<?php
$con= new mysqli('localhost','root','','exam')or die("Could not connect to mysql".mysqli_error($con));

mysqli_query($con, "CREATE TABLE IF NOT EXISTS user_ip (
  email VARCHAR(50) NOT NULL,
  ip_address VARCHAR(45) NOT NULL,
  last_seen TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci") or die('Error creating user_ip table');

mysqli_query($con, "CREATE TABLE IF NOT EXISTS ip_lock (
  id INT(11) NOT NULL AUTO_INCREMENT,
  email VARCHAR(50) NOT NULL,
  ip_address VARCHAR(45) NOT NULL,
  locked_by VARCHAR(50) NOT NULL,
  locked_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  UNIQUE KEY uq_email_ip (email, ip_address)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci") or die('Error creating ip_lock table');

if(!function_exists('get_client_ip'))
{
	function get_client_ip()
	{
		if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
			return $_SERVER['HTTP_CLIENT_IP'];
		}
		if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$ipList = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
			return trim($ipList[0]);
		}
		if (!empty($_SERVER['REMOTE_ADDR'])) {
			return $_SERVER['REMOTE_ADDR'];
		}
		return 'UNKNOWN';
	}
}

?>