<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html>
<head>
<title>CD Collection</title>
<style type="text/css">
body {
	font-family: verdana, arial;
	font-size: 90%;
}
.thisCD {
	border: 1px solid #999;
	padding: 10px;
	margin-top:10px;
	/*
	height: 150px;*/
	width: 400px;
	
}
.displayCategory {

	font-weight: bold;
	color: #009;
}
.displayInfo{

	font-weight: normal;
	color: #900;
}
.cdImage {
	float: right;
}
.displayDescription {
	font-size: 85%;
	padding: 7px;
}
.clearFix {
	clear: both;
}
#main{
	width: 500px;
	float:left;
	
	
}
#rightcol{
	
	float:left;
	top: 0px;
	border: 1px solid #900;	
	width: 400px;
	
	padding: 7px;
}
</style>

</head>
<body>

 <div id="main">
<?php
require("mysql_connect.php");


// DEFAULT QUERY: RETRIEVE EVERYTHING
//$result = mysql_query("SELECT * FROM cd_catalog_class") or die (mysql_error());

// FILTERING YOUR DB!!!!!!!!!!!
$year = $_GET['year'];
$genre = $_GET['genre'];
$label = $_GET['label'];
$queryAppend = array(); // create array


if ($year != ""){
	array_push($queryAppend,"year LIKE '$year'"); 
}
if ($genre != ""){
	array_push($queryAppend,"genre LIKE '$genre'");
}
if ($label != ""){
	array_push($queryAppend,"label LIKE '$label'");
}

foreach ($queryAppend as $k => $v) {
	if ($k == 0){
		$queryFilter .= " WHERE " .$v; 
	}else{
		$queryFilter .= " AND " .$v; 
	}
}

echo "<p>$queryFilter </p>";

$result = mysqli_query($con,"SELECT * FROM cd_catalog_class $queryFilter");
	
	


/************************** ECHO OUT YOUR RESULTS

*************************************************/
while ($row = mysqli_fetch_array($result)) {
	$cd_id = ($row['cd_id']);
	$thisArtist = ($row['artist']);
	$thisTitle = ($row['title']);
	$thisYear = ($row['year']);
	$thisGenre = ($row['genre']);
	$thisLabel = ($row['label']);
	$artwork = $row['artwork'];
	$thisDescription = nl2br($row['description']);
	echo "<div class=\"thisCD\">\n";
	if($displayby == "cd_id"){
		$artImage = "<img src=\"artwork/thumbs150/$artwork\" class=\"cdImage\" />";	
	}else{
	
		$artImage = "<img src=\"artwork/thumbs100/$artwork\" class=\"cdImage\" />";
	}
	echo $artImage;

	echo "<span class=\"displayCategory\">Title:</span> <span class=\"displayInfo\">". $thisTitle ."</span><br />\n";
echo "<span class=\"displayCategory\">Artist:</span> <span class=\"displayInfo\">". $thisArtist ."</span><br />\n";
echo "<span class=\"displayCategory\">Year:</span> <span class=\"displayInfo\">". $thisYear ."</span><br />\n";
echo "<span class=\"displayCategory\">Genre:</span> <span class=\"displayInfo\">". $thisGenre ."</span><br />\n";
echo "<span class=\"displayCategory\">Label:</span> <span class=\"displayInfo\">". $thisLabel ."</span><br />\n";
	
	// IF WE SEE A SINGLE ITEM VIEW, THEN SHOW ALL INFO
	if($displayby == "cd_id"){
		echo "<div class=\"displayDescription\">$description</div>\n";
	}else{
		echo "<a href=\"display.php?displayby=cd_id&displayvalue=$cd_id\">more..</a>";
	}
echo "<div class=\"clearFix\"></div>\n";
echo "\n</div>\n";
}

?>
</div>
<div id="rightcol">
<h2>Multiple Filter</h2>
<a href="<?php echo $_SERVER['PHP_SELF']; ?>">ALL</a>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">
	Decade:
	<select name="year">
		<option value="">Any</option>
		<option value="195%" <?php if($year == "195%"){echo "selected=\"selected\"";}?>>1950's</option>
		<option value="196%" <?php if($year == "196%"){echo "selected=\"selected\"";}?>>1960's</option>
		<option value="197%" <?php if($year == "197%"){echo "selected=\"selected\"";}?>>1970's</option>
		<option value="198%" <?php if($year == "198%"){echo "selected=\"selected\"";}?>>1980's</option>
		<option value="199%" <?php if($year == "199%"){echo "selected=\"selected\"";}?>>1990's</option>
		<option value="200%" <?php if($year == "200%"){echo "selected=\"selected\"";}?>>2000's</option>
	</select><br />
	Genre:
	<select name="genre">
		<option value="">Any</option>
		<option <?php if($genre == "Rock"){echo "selected=\"selected\"";}?>>Rock</option>
		<option <?php if($genre == "Pop"){echo "selected=\"selected\"";}?>>Pop</option>
		<option <?php if($genre == "Jazz"){echo "selected=\"selected\"";}?>>Jazz</option>
		<option <?php if($genre == "Blues"){echo "selected=\"selected\"";}?>>Blues</option>
		<option <?php if($genre == "Alternative Rock"){echo "selected=\"selected\"";}?>>Alternative Rock</option>
		<option <?php if($genre == "Folk"){echo "selected=\"selected\"";}?>>Folk</option>
	</select><br />
	Label:
	<select name="label">
		<option value="">Any</option>
		<option <?php if($label == "Columbia"){echo "selected=\"selected\"";}?>>Columbia</option>
		<option <?php if($label == "RCA"){echo "selected=\"selected\"";}?>>RCA</option>
		<option <?php if($label == "Atlantic"){echo "selected=\"selected\"";}?>>Atlantic</option>
		<option <?php if($label == "Epic"){echo "selected=\"selected\"";}?>>Epic</option>
		<option <?php if($label == "Virgin"){echo "selected=\"selected\"";}?>>Virgin</option>
		<option <?php if($label == "Blue Note"){echo "selected=\"selected\"";}?>>Blue Note</option>
	</select><br />
	<input type="submit" name="submit" />
</form>
<h2>Common Searches</h2>


<a href="<?php echo $_SERVER['PHP_SELF'];?>?year=195%25&genre=Jazz&label=Blue+Note"> 1950's Jazz by Blue Note</a><br />
<a href="<?php echo $_SERVER['PHP_SELF'];?>?year=197%25&genre=Rock&label=Atlantic"> 1970's Rock by Atlantic</a><br />


</div>

</body>
</html>

