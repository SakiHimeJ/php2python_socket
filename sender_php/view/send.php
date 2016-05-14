<?php
header ( 'Content-type:text/html;charset=utf8' );
?>
<!DOCTYPE HTML>
<html>
	<head>
	    <title>php与python通信测试</title>
	</head>
	<body>
		<form method="POST" action="../controller/SendController.php">
			<label for="py_obj">请输入提交给python的内容,并行用|分开</label><br/><br/>
			<input type="text" name="py_obj" class="text" placeholder="请输入提交给python的内容"><br/><br/>
        	<input type="submit" onclick="" value="提交"><br/><br/>
		</form>
	</body>
<html>