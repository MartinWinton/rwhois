<html>

<head>
<title>RWHois- Martin Winton</title>
<link rel="icon" type="image/png" href='kMxOTN1.png'>
<link rel="shortcut icon" href="/kMxOTN1.png" />

<style>
a {
	padding: 0px 10px;
	word-wrap: normal;
	display: inline-block;
}

.error {
	color: #FF0000;
}
</style>

</head>

<body>

	<h1>Welcome to Updater</h1>

	<?php

	include 'functions.php';


	$v_ip = test_input($_GET["v_ip"]);
	$auth = test_input($_GET["auth"]);


	$mark = strtolower(test_input($_GET["v_ip"]).'.txt');



	$auth = str_replace("/","-",$auth);
	$mark = str_replace("/","-",$mark);
	$v_ip = str_replace("/","-",$v_ip);

	echo "<h3>Viewing " .$mark."</h3>";

	//var_dump($ipfiles);


	if($string = @file_get_contents("/usr/local/rwhoisd/net-$auth/data/network/" . $mark)){


		preg_match_all("/((.+): (.+))/",$string,$matches);
			

		$id = test_input($matches[3][0]);
		$auth = test_input($matches[3][1]);
		$name = test_input($matches[3][2]);
		$network =  test_input($matches[3][3]);
		$block = test_input($matches[3][4]);
		$org = test_input($matches[3][5]);
		$tech = test_input($matches[3][6]);
		$admin = test_input($matches[3][7]);
		$created = test_input($matches[3][8]);
		$updated = test_input($matches[3][9]);
		$email = test_input($matches[3][10]);
			
			
		//var_dump($matches);


		echo '<table border="1">';



			
			
		$index = array("ID: ", "Auth-Area: ","Network-Name: ","IP-Network: ","IP-Network-Block: ","Organization: ","Tech-Contact: ","Admin-Contact: ","Created: ","Updated: ","Updated-By: ");
			


		$key = array("$id ","$auth ","$name ","$network ","$block ","$org ","$tech ","$admin ","$created ","$updated ","$email");
		for($i = 0; $i<count($key);$i++){
			echo '<tr>';

			echo "<td>$index[$i]</td>";
			echo "<td>$key[$i]</td>";
			echo '</tr>';

		}


	}

	else{
		die("This IP does not exist!");
	}



	?>


</body>
</html>
