<BODY BGCOLOR="#f4eda0">
<?php
require("config.inc.php");

$opts = array("house","horse","soldier",
	"boat","fort","siege","power","ord","dragon");

$region = $_GET[q];

if($_POST["power"] == "yes")
	$_POST["power"] = 1;
else
	$_POST["power"] = 0;

$DBlink = mysql_connect($DBhost,$DBuser,$DBpass)
	or die('Could not connect: ' . mysql_error());
mysql_select_db($DBname,$DBlink)
	or die('Could not select database' .  mysql_error());



foreach( $opts as &$val )
	{
	echo "<p>Inserting $val...";
	$query="UPDATE regions SET $val='$_POST[$val]' WHERE name='$region'";
	$result = mysql_query($query,$DBlink) 
		or die('Cannot select: ' . mysql_error());
	
	if($result)
		echo " ok</p>";
	else
		echo " error</p>";

	}

echo "Done\n";
?>
<form action="JavaScript:window.close()">
        <p><input type="submit" value="Close"></p>
</form>

</BODY>

