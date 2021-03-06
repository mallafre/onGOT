<BODY BGCOLOR="#f4eda0">

<?
require_once("config.inc.php");

$Region = $_GET[q];

echo "<h3>$Region</h3>\n";
echo "<hr>\n";

$DBlink = mysql_connect($DBhost,$DBuser,$DBpass)
	or die('Could not connect: ' . mysql_error());

mysql_select_db($DBname,$DBlink)
	or die('Could not select database' .  mysql_error());

$options = array_merge($Troops,$Figures);
$optionsQuery = $options[0];
			
$first = 1;
foreach ( $options as &$T ) { if ( ! $first) $optionsQuery = "$optionsQuery,$T"; else $first = 0;  }

$query = "SELECT $optionsQuery from regions where name='$Region'";

$result = mysql_query($query,$DBlink) 
	or die('Cannot select: ' . mysql_error());

$row = mysql_fetch_array($result, MYSQL_NUM);

mysql_free_result($result);

echo "<form action='regupdate.php?q=$Region' method='post'>\n";

echo "<table><tbody>\n";

$i = 0;
foreach ( $Troops as &$T) {
	echo "<tr><td><b>$T:</b></td>\n";
	echo "<td><input type='text' value='$row[$i]' name='$T' size='3' maxlength='2'></td></tr>\n";
	$i++;
	}
echo "</tbody></table>\n";

drawHouse($row[$i]);
$i++;
drawPower($row[$i]);
$i++;
drawOrder($row[$i]);

echo "<p><input type=\"submit\" value=\"Update\"></form></p>\n";


function drawHouse($house)
	{
	$sel = array();
	$sel = selectHouse($house);

	echo "<table><tbody><tr>\n";
	echo "<td><b>House:</b></td>\n";
	echo "<td><SELECT size='4' name='house'>\n";
	
	echo "\t<OPTION $sel[0] value='Stark'>Stark</OPTION>\n";
	echo "\t<OPTION $sel[1] value='Lannister'>Lannister</OPTION>\n";
        echo "\t<OPTION $sel[2] value='Baratheon'>Baratheon</OPTION>\n";
	echo "\t<OPTION $sel[3] value='Targaryen'>Targaryen</OPTION>\n";
        echo "\t<OPTION $sel[4] value='Tully'>Tully</OPTION>\n";
	echo "\t<OPTION $sel[5] value='Greyjoy'>Greyjoy</OPTION>\n";
        echo "\t<OPTION $sel[6] value='Martell'>Martell</OPTION>\n";
	echo "\t<OPTION $sel[7] value='Tyrell'>Tyrell</OPTION>\n";
        echo "\t<OPTION $sel[8] value='Arryn'>Arryn</OPTION>\n";
	echo "\t<OPTION $sel[9] value='nobody'>NoBody</OPTION>\n";
	echo "</SELECT></td></tr></tbody></table>\n";

	}

function drawPower($pow)
	{
	if($pow)
	{
	echo "<table><tbody><tr>\n";
	echo "<td><b>Power Token:</b></td>\n";
	echo "<td>yes<input type=\"radio\" name=\"power\" checked value=\"yes\"></td>\n";
	echo "<td>no<input type=\"radio\" name=\"power\" value=\"no\"></td>\n";
	echo "</tr></tbody></table>\n";
        }
	else
	{
	echo "<table><tbody><tr>\n";
	echo "<td><b>Power Token:</b></td>\n";
	echo "<td>yes<input type=\"radio\" name=\"power\" value=\"yes\"></td>\n";
	echo "<td>no<input type=\"radio\" name=\"power\" checked value=\"no\"></td>\n";
	echo "</tr></tbody></table>\n";
	}

	}

function drawOrder($order)
	{
	$sel = array();
	$sel = selectOrder($order); 
	echo "<table><tbody><tr>\n";
	echo "<td><b>Order:</b></td>\n";
	echo "<td><SELECT size='4' name='ord'>\n";
	echo "\t<OPTION $sel[0] value='Marchp2'>March +2</OPTION>\n";
	echo "\t<OPTION $sel[1] value='Marchp1'>March +1</OPTION>\n";
	echo "\t<OPTION $sel[2] value='Marchp0'>March +0</OPTION>\n";
	echo "\t<OPTION $sel[3] value='Marchm1'>March -1</OPTION>\n";
	echo "\t<OPTION $sel[4] value='Defensep3'>Defense +3</OPTION>\n";
	echo "\t<OPTION $sel[5] value='Defensep2'>Defense +2</OPTION>\n";
	echo "\t<OPTION $sel[6] value='Defensep1'>Defense +1</OPTION>\n";
	echo "\t<OPTION $sel[7] value='Supportp2'>Support +2</OPTION>\n";
	echo "\t<OPTION $sel[8] value='Supportp1'>Support +1</OPTION>\n";
	echo "\t<OPTION $sel[9] value='Supportp0'>Support +0</OPTION>\n";
	echo "\t<OPTION $sel[10] value='Supportm1'>Support -1</OPTION>\n";
	echo "\t<OPTION $sel[11] value='Consolide1s'>Consolide star</OPTION>\n";
	echo "\t<OPTION $sel[12] value='Consolide0s'>Consolide nostar</OPTION>\n";
	echo "\t<OPTION $sel[13] value='Raid1s'>Raid star</OPTION>\n";
	echo "\t<OPTION $sel[14] value='Raid0s'>Raid nostar</OPTION>\n";
	echo "\t<OPTION $sel[15] value='none'>None</OPTION>\n";	
	echo "</SELECT></td></tr></tbody></table>\n";

	}

function selectHouse($house)
	{
	$sel = array();
	for($i=0; $i<9; $i++)
		$sel[$i] = " ";
	switch($house)
		{
		case "Stark": $sel[0]="selected";
			break;
		case "Lannister": $sel[1]="selected";
			break;
		case "Baratheon": $sel[2]="selected";
		       	break;
		case "Targaryen": $sel[3]="selected";
		       	break;
		case "Tully": $sel[4]="selected";
		        break;
		case "Greyjoy": $sel[5]="selected";
		        break;
		case "Martell": $sel[6]="selected";
		        break;
		case "Tyrell": $sel[7]="selected";
		        break;
		case "Arryn": $sel[8]="selected";
		        break;
		default: $sel[9]="selected";
		}

	return $sel;	
	}

function selectOrder($order)
	{
	$checked = array();

	for($i=0; $i<16; $i++)
		{
		$checked[$i] = " ";
		}

	switch($order)
		{
		case "Marchp2": $checked[0]="selected";
				break;
                case "Marchp1": $checked[1]="selected";
				break;
		case "Marchp0": $checked[2]="selected";
				break;
		case "Marchm1": $checked[3]="selected";
				break;
		case "Defensep3": $checked[4]="selected";
				break;
		case "Defensep2": $checked[5]="selected";
				break;
		case "Defensep1": $checked[6]="selected";
				break;
		case "Supportp2": $checked[7]="selected";
				break;
		case "Supportp1": $checked[8]="selected";
				break;
		case "Supportp0": $checked[9]="selected";
				break;
		case "Supportm1": $checked[10]="selected";
				break;
		case "Consolide1s": $checked[11]="selected";
				break;
		case "Consolide0s": $checked[12]="selected";
				break;
		case "Raid1s": $checked[13]="selected";
				break;
		case "Raid0s": $checked[14]="selected";
				break;
		default: $checked[15]="selected";

		}

	return $checked;
	}

?>

</BODY>


















