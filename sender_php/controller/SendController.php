<?php
/**
 * Socket PHP客户端
 * 
 */
header("Content-Type:text/html;charset=utf8");
include_once($_SERVER['DOCUMENT_ROOT']."nobita/"."config/DB.php");
class SendController{
	public function sendToPython($obj){
		$host = 'tcp://localhost:9999';
		$fp = stream_socket_client ( $host, $errno, $error, 20 );
		if (! $fp)
		{
		     
		    echo "$error ($errno)";
		} else
		{
		    fwrite ( $fp, $obj );
		    while ( ! feof ( $fp ) )
		    {
		 		$resps = fgets ( $fp );
		 		$resps = str_replace("\r","",$resps);
		 		$resps = str_replace("\n","<br/>",$resps);
		        echo $resps; #获取服务器返回的内容
		    }
		    fclose ( $fp );
		}
	}
}

session_start();
$sender = new SendController();
$py_obj = $_POST['py_obj'];
$sender->sendToPython($py_obj);
?>
