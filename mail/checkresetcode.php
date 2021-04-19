<?php

	if(isset($_POST['email'])){
		$email_address=$_POST['email'];
		$resetcode=$_POST['resetcode'];
	}

	$link = mysqli_connect("localhost", "hilanpro_andry", "answer", "hilanpro_mysecfile"); 
	if($link === false){	
    	die("ERROR: Could not connect. " . mysqli_connect_error());
	}

	$sql = "SELECT * from resetform where email='".$email_address."' and resetcode='".$resetcode."'";
	$result = mysqli_query($link, $sql);
	if (mysqli_num_rows($result) > 0) {
	    // output data of each row
	    echo "1";
	} else {
	    echo "0";
	}


	mysqli_close($link);
?>
