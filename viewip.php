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
</style>

</head>

<body>

	<h1>Welcome to Viewer</h1>



	<?php 
	include 'functions.php';

	if(isset($_GET["entries"])){

	$limit = (int)$_GET["entries"];
}


else{
	$limit = 0;
		}


		//gets limit and sets to 0 otherwise
		?>



	<h3>Select Number of Entries Per Page:</h3>

	<form method="get"
		action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
		<select name="entries">
			<option value="2"
			<?php if ( $limit == 2 ) { echo ' selected="selected"'; };?>>2</option>
			<option value="5"
			<?php if ( $limit == 5 ) { echo ' selected="selected"'; };?>>5</option>
			<option value="7"
			<?php if ( $limit == 7 ) { echo ' selected="selected"'; };?>>7</option>
			<option value="10"
			<?php if ( $limit == 10) { echo ' selected="selected"'; };?>>10</option>
		</select> <input name="add" type="submit" id="add" value="Submit">

	</form>













	<?php



	$self= $_SERVER['PHP_SELF'];

	if (!empty($_GET["entries"]) or isset($_GET['add'])) {



		$limit = (int)$_GET["entries"];


		$offset = (isset($_GET['offset'])) ? $_GET['offset'] : 0;


		$offset = (int)$offset;
		$offset = test_input($offset);
		// gets offset and sets to 0 otherwise


		$new_dir = [];
		$files = [];
		$maindir = "/usr/local/rwhoisd/";
		$maindir = scandir($maindir);


		for($i = 0; $i< count($maindir);$i++){

			$net = $maindir[$i];
			if (preg_match('/net/',$net)){

				$ip=explode('-',$net,2)[1];

				$ip = $ip.'.txt';

			


				$dir = "/usr/local/rwhoisd/$net/data/network/";


				if (is_dir($dir)){
					if ($dh = opendir($dir)){

							
						$dir = scandir($dir);
							
						for ($k = 0; $k<count($dir);$k++){
							$file = $dir[$k];
							if (preg_match('/\d+\d/',$file)){
								// filters out non auth area files


								if (preg_match("/$ip/",$file)){
								
									// ignores auth area IP
								}

									
								else{


									array_push($new_dir,$file);

								}
							}

						}



							
							
			
							
						//var_dump($files);
						//var_dump($orgs);
						//var_dump($techs);
						//var_dump($admins);
						closedir($dh);
					}
				}
			}
		}





		$i = $offset;
		$count = 0;
		while($count< $limit and $i<count($new_dir)){


			$file = $new_dir[$i];
			array_push($files,$file);
			$i++;
			$count++;

		}







		if( isset($_GET{'page'} ) ) {
			$page = (int)test_input($_GET{'page'});


		}else {
			$page = 0;

		}

		// finds  current page and sets page accordingly








		echo '<table border="1">';




		echo '<tr>';


		for($j = 0; $j<count($files);$j++){


			if (preg_match('/192.168/',$files[$j])){

				$string = file_get_contents('/usr/local/rwhoisd/net-192.168.192.0-19/data/network/' . $files[$j]);
			}



			else{
					
				$string = file_get_contents('/usr/local/rwhoisd/net-10.0.0.0-8/data/network/' . $files[$j]);
			}


			// gets data depending on type of file

			preg_match_all("/((.+): (.+))/",$string,$matches2);


			// extracts data from file






			$org_mark = $matches2[3][5];
			$ip_mark = test_input($matches2[3][3]);
			$auth_mark = test_input($matches2[3][1]);

			$org_mark = test_input($org_mark);

			//provides org name and ip for links to process



			echo "<td><a href = \"deleteip.php?d_ip=$ip_mark&auth=$auth_mark\">Delete This IP! </a></td>";
			echo "<td>$ip_mark</td>";
			echo "<td>$org_mark</td>";
			echo "<td>$auth_mark</td>";







			//removes crap









			echo "<td><a href = \"more.php?v_ip=$ip_mark&auth=$auth_mark\">View More! </a></td>";
			echo "<td><a href = \"vieworg.php?org=$org_mark&auth=$auth_mark\">View This IP's Org! </a></td>";
			echo "<td><a href = \"updateip.php?u_ip=$ip_mark&auth=$auth_mark\">Update This IP! </a></td>";




			//links to options



			echo"</tr>";


		}



		echo "</table>";

		echo "<br>";



		$count = count($new_dir);

		if( $page!= 0 and $offset+count($files) >= $count) {
		$page = $page -1;
		$offset = $limit*$page;
		echo "<a href = \"$self?page=$page&offset=$offset&entries=$limit\">Prev</a>";
	}
	elseif( $page > 0  ) {
		$last = $page - 1;
		$next = $page + 1;

		$prevoffset = $limit*$last;
		$offset2 = $limit*$next;
		echo "<a href = \"$self?page=$last&offset=$prevoffset&entries=$limit\">Prev</a> |";
		echo "<a href = \"$self?page=$next&offset=$offset2&entries=$limit\">Next</a>";
	}

	elseif( $page == 0 and count($files) < count($new_dir)) {
		$page = $page + 1;

		$offset = $limit*$page;
		echo "<a href = \"$self?page=$page&offset=$offset&entries=$limit\">Next </a>";
	}

	//pagination calculations
	}

	echo "<br>";
	echo "<br>";
	echo "<br>";

	echo "<td><a href = \"allorgs.php\">View all Orgs! </a></td>";
	echo "<br>";
	echo "<td><a href = \"org.php\">New Org! </a></td>";
	echo "<br>";
	echo "<td><a href = \"IP.php\">Insert New IP! </a></td>";


	?>

</body>
</html>
