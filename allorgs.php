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

	<h1>Welcome to Org Viewer</h1>



	<?php 
	include 'functions.php';


	if(isset($_GET["entries"])){

	$limit = (int)$_GET["entries"];
}


else{
	$limit = '';
		}

		// finds limit and sets to 0 if not found
		?>


	<h3>Select Number of Entries Per Page:</h3>

	<form method="get"
		action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
		<select name="en<html>

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

	<h1>Welcome to Org Viewer</h1>









	<?php 
	include 'functions.php';


	if(isset($_GET["entries"])){

	$limit = (int)$_GET["entries"];
}


else{
	$limit = '';
		}
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
		
		<h1>Welcome to Org Viewer</h1>
		
		
		
		
		
		
		
		
		
		<?php
		include 'functions.php';
		
		
		if(isset($_GET["entries"])){
		
			$limit = (int)$_GET["entries"];
		}
		
		
		else{
			$limit = '';
		}
		
		// finds limit and sets to 0 if not found
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
					<option value="1"
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
		
		
				$files = [];
				$new_dir = [];
				$maindir = "/usr/local/rwhoisd/";
				$maindir = scandir($maindir);
		
		
				for($i = 0; $i< count($maindir);$i++){
		
					$net = $maindir[$i];
					if (preg_match('/net/',$net)){
		
		
		
		
						$dir = "/usr/local/rwhoisd/$net/data/org/";
		
							
		
		
						if (is_dir($dir)){
							if ($dh = opendir($dir)){
		
		
		
									
		
									
								// initializes extraction variables
								$dir = scandir($dir);
									
								for ($k = 0; $k<count($dir);$k++){
									$file = $dir[$k];
		
		
									if (preg_match('/.txt/',$file)){
		
		
		
											
											
		
		
										if(!in_array($file,$new_dir)){
											//echo $file;
		
											array_push($new_dir,$file);
										}
											
									}
								}
		
		
									
		
								//var_dump($new_dir);
									
								echo "<br>";
									
									
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
		
		
		
					if($string = @file_get_contents('/usr/local/rwhoisd/net-192.168.192.0-19/data/org/' . $files[$j])){
		
					}
		
		
		
					else{
							
						$string = @file_get_contents('/usr/local/rwhoisd/net-10.0.0.0-8/data/org/' . $files[$j]);
					}
		
		
					// gets file depending on page
		
					preg_match_all("/((.+): (.+))/",$string,$matches2);
		
					$string = test_input($string);
		
					// extracts data from file
		
		
					$string= str_replace(" ","\n ",$string);
		
		
					//var_dump($matches2);
					$org_mark = $matches2[3][0];
		
		
		
					$org_mark = test_input($org_mark);
		
					//provides org name and ip for links to process
		
		
		
					echo "<td><a href = \"deleteorg.php?org=$org_mark\">Delete This Org! </a></td>";
		
					echo "<td>$org_mark </td>";
		
		
		
		
					echo "<td><a href = \"vieworg.php?org=$org_mark\">View This Org! </a></td>";
		
		
		
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
		
					elseif( $page == 0 and count($files) < count($new_dir) ) {
					$page = $page + 1;
		
					$offset = $limit*$page;
					echo "<a href = \"$self?page=$page&offset=$offset&entries=$limit\">Next </a>";
					}
		
		
					// pagination calculation
		
			}
		
		
		
		
		
			?>
		
		</body>
		</html>
				
		// finds limit and sets to 0 if not found
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
			<option value="1"
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


		$files = [];
		$new_dir = [];
		$maindir = "/usr/local/rwhoisd/";
		$maindir = scandir($maindir);


		for($i = 0; $i< count($maindir);$i++){

			$net = $maindir[$i];
			if (preg_match('/net/',$net)){




				$dir = "/usr/local/rwhoisd/$net/data/org/";

					


				if (is_dir($dir)){
					if ($dh = opendir($dir)){



							

							
						// initializes extraction variables
						$dir = scandir($dir);
							
						for ($k = 0; $k<count($dir);$k++){
							$file = $dir[$k];


							if (preg_match('/.txt/',$file)){



									
									


								if(!in_array($file,$new_dir)){
									//echo $file;

									array_push($new_dir,$file);
								}
									
							}
						}


							

						//var_dump($new_dir);
							
						echo "<br>";
							
							
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



			if($string = @file_get_contents('/usr/local/rwhoisd/net-192.168.192.0-19/data/org/' . $files[$j])){

			}



			else{
					
				$string = @file_get_contents('/usr/local/rwhoisd/net-10.0.0.0-8/data/org/' . $files[$j]);
			}


			// gets file depending on page

			preg_match_all("/((.+): (.+))/",$string,$matches2);

			$string = test_input($string);

			// extracts data from file


			$string= str_replace(" ","\n ",$string);


			//var_dump($matches2);
			$org_mark = $matches2[3][0];



			$org_mark = test_input($org_mark);

			//provides org name and ip for links to process



			echo "<td><a href = \"deleteorg.php?org=$org_mark\">Delete This Org! </a></td>";

			echo "<td>$org_mark </td>";




			echo "<td><a href = \"vieworg.php?org=$org_mark\">View This Org! </a></td>";



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

			elseif( $page == 0 and count($files) < count($new_dir) ) {
			$page = $page + 1;

			$offset = $limit*$page;
			echo "<a href = \"$self?page=$page&offset=$offset&entries=$limit\">Next </a>";
			}


			// pagination calculation

	}





	?>

</body>
</html>
		tries">
			<option value="2"
			<?php if ( $limit == 2 ) { echo ' selected="selected"'; };?>>2</option>
			<option value="5"
			<?php if ( $limit == 5 ) { echo ' selected="selected"'; };?>>5</option>
			<option value="7"
			<?php if ( $limit == 7 ) { echo ' selected="selected"'; };?>>7</option>
			<option value="1"
			<?php if ( $limit == 10) { echo ' selected="selected"'; };?>>10</option>
		</select> <input name="add" type="submit" id="add" value="Submit">

	</form>



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

	<h1>Welcome to Org Viewer</h1>









	<?php 
	include 'functions.php';


	if(isset($_GET["entries"])){

	$limit = (int)$_GET["entries"];
}


else{
	$limit = '';
		}

		// finds limit and sets to 0 if not found
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
			<option value="1"
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


		$files = [];
		$new_dir = [];
		$maindir = "/usr/local/rwhoisd/";
		$maindir = scandir($maindir);


		for($i = 0; $i< count($maindir);$i++){

			$net = $maindir[$i];
			if (preg_match('/net/',$net)){




				$dir = "/usr/local/rwhoisd/$net/data/org/";

					


				if (is_dir($dir)){
					if ($dh = opendir($dir)){



							

							
						// initializes extraction variables
						$dir = scandir($dir);
							
						for ($k = 0; $k<count($dir);$k++){
							$file = $dir[$k];


							if (preg_match('/.txt/',$file)){



									
									


								if(!in_array($file,$new_dir)){
									//echo $file;

									array_push($new_dir,$file);
								}
									
							}
						}


							

						//var_dump($new_dir);
							
						echo "<br>";
							
							
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



			if($string = @file_get_contents('/usr/local/rwhoisd/net-192.168.192.0-19/data/org/' . $files[$j])){

			}



			else{
					
				$string = @file_get_contents('/usr/local/rwhoisd/net-10.0.0.0-8/data/org/' . $files[$j]);
			}


			// gets file depending on page

			preg_match_all("/((.+): (.+))/",$string,$matches2);

			$string = test_input($string);

			// extracts data from file


			$string= str_replace(" ","\n ",$string);


			//var_dump($matches2);
			$org_mark = $matches2[3][0];



			$org_mark = test_input($org_mark);

			//provides org name and ip for links to process



			echo "<td><a href = \"deleteorg.php?org=$org_mark\">Delete This Org! </a></td>";

			echo "<td>$org_mark </td>";




			echo "<td><a href = \"vieworg.php?org=$org_mark\">View This Org! </a></td>";



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

			elseif( $page == 0 and count($files) < count($new_dir) ) {
			$page = $page + 1;

			$offset = $limit*$page;
			echo "<a href = \"$self?page=$page&offset=$offset&entries=$limit\">Next </a>";
			}


			// pagination calculation

	}





	?>

</body>
</html>
	
	<?php

	$self= $_SERVER['PHP_SELF'];

	if (!empty($_GET["entries"]) or isset($_GET['add'])) {



		$limit = (int)$_GET["entries"];


		$offset = (isset($_GET['offset'])) ? $_GET['offset'] : 0;


		$offset = (int)$offset;
		$offset = test_input($offset);


		$files = [];
		$new_dir = [];
		$maindir = "/usr/local/rwhoisd/";
		$maindir = scandir($maindir);


		for($i = 0; $i< count($maindir);$i++){

			$net = $maindir[$i];
			if (preg_match('/net/',$net)){




				$dir = "/usr/local/rwhoisd/$net/data/org/";

					


				if (is_dir($dir)){
					if ($dh = opendir($dir)){



							

							
						// initializes extraction variables
						$dir = scandir($dir);
							
						for ($k = 0; $k<count($dir);$k++){
							$file = $dir[$k];


							if (preg_match('/.txt/',$file)){



									
									


								if(!in_array($file,$new_dir)){
									//echo $file;

									array_push($new_dir,$file);
								}
									
							}
						}


							

						//var_dump($new_dir);
							
						echo "<br>";
							
							
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



			if($string = @file_get_contents('/usr/local/rwhoisd/net-192.168.192.0-19/data/org/' . $files[$j])){

			}



			else{
					
				$string = @file_get_contents('/usr/local/rwhoisd/net-10.0.0.0-8/data/org/' . $files[$j]);
			}


			// gets file depending on page

			preg_match_all("/((.+): (.+))/",$string,$matches2);

			$string = test_input($string);

			// extracts data from file


			$string= str_replace(" ","\n ",$string);


			//var_dump($matches2);
			$org_mark = $matches2[3][0];



			$org_mark = test_input($org_mark);

			//provides org name and ip for links to process



			echo "<td><a href = \"deleteorg.php?org=$org_mark\">Delete This Org! </a></td>";

			echo "<td>$org_mark </td>";




			echo "<td><a href = \"vieworg.php?org=$org_mark\">View This Org! </a></td>";



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

			elseif( $page == 0 and count($files) < count($new_dir) ) {
			$page = $page + 1;

			$offset = $limit*$page;
			echo "<a href = \"$self?page=$page&offset=$offset&entries=$limit\">Next </a>";
			}


			// pagination calculation

	}





	?>

</body>
</html>
