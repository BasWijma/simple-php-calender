<?php
if(!isset($_GET["m"])) { $month = date("n"); } else { $month = $_GET["m"]; }
if(!isset($_GET["y"])) { $year = date("Y"); } else { $year = $_GET["y"]; }
$month_timestamp = mktime(0,0,0,$month,1,$year);
$title = "Kalender ".date("F Y",$month_timestamp);
?>

<html>
<head>
<title><?php echo $title; ?></title>
<link href="style.css" rel="stylesheet" type="text/css" />
</head>

<body>

<?php
$days_left = date("N",$month_timestamp)-1;
if($days_left > 0) {
	$day = date("t",$month_timestamp-(24*60*60))-($days_left-1);
	$current = false;;
} else {
	$day = 1;
	$current = true;
}

$holidays = array();
$holidays[mktime(0,0,0,1,1,$year)] = "Nieuwjaarsdag";
$holidays[mktime(0,0,0,12,31,$year)] = "Oudjaarsdag";
$holidays[mktime(0,0,0,2,14,$year)] = "Valentijnsdag";
$holidays[mktime(0,0,0,12,5,$year)] = "Sinterklaas";
$holidays[mktime(0,0,0,12,25,$year)] = "Eerste Kerstdag";
$holidays[mktime(0,0,0,12,26,$year)] = "Tweede Kerstdag";
$holidays[mktime(0,0,0,5,5,$year)] = "Bevrijdingsdag";
$holidays[mktime(0,0,0,4,27,$year)] = "Koningsdag";
$holidays[mktime(0,0,0,10,31,$year)] = "Halloween";
$holidays[mktime(0,0,0,10,4,$year)] = "Dierendag";
$holidays[easter_date($year)] = "Eerste Paasdag";
$holidays[easter_date($year)+(24*60*60)] = "Tweede Paasdag";
$holidays[easter_date($year)+(24*60*60*39)] = "Hemelvaart";
$holidays[easter_date($year)+(24*60*60*7*7)] = "Eerste Pinksterdag";
$holidays[easter_date($year)+(24*60*60*7*7+(24*60*60))] = "Tweede Pinksterdag";
$holidays[strtotime("third Sunday of June ".$year)] = "Vaderdag";
$holidays[strtotime("second Sunday of May ".$year)] = "Moederdag";
$holidays[strtotime("last Sunday of March ".$year)] = "Zomertijd";
$holidays[strtotime("last Sunday of October ".$year)] = "Wintertijd";

if($month == 1) { $last_month = 12; $last_year = $year-1; } else { $last_month = $month-1; $last_year = $year; }
if($month == 12) { $next_month = 1; $next_year = $year+1; } else { $next_month = $month+1; $next_year = $year; }

echo "<div id='container'>
		<table cellpadding='0' cellspacing='0'>
		<tr>
			<th><a href='?m=".$last_month."&y=".$last_year."'>&laquo;</a></th>
			<th colspan='5'>".date("F Y",$month_timestamp)."</th>
			<th><a href='?m=".$next_month."&y=".$next_year."'>&raquo;</a></th>
		<tr>
			<th>Ma</th>
			<th>Di</th>
			<th>Wo</th>
			<th>Do</th>
			<th>Vr</th>
			<th>Za</th>
			<th>Zo</th>
		</tr>
	

";
$row = 1;
$f = false;
$events = "<b>'Feest'dagen deze maand:</b><br />";
while($f == false) {
	echo "<tr>";
	$col = 1;
	while($col <= 7) {
		
		if($current == false) { $class = "grey"; } else {
			
			
			$today_timestamp = mktime(0,0,0,$month,$day,$year);

			if($today_timestamp == mktime(0,0,0,date("n"),date("j"),date("Y"))) { $class = "today"; }
			else { $class = "white"; $show = "";}
			
			foreach($holidays as $time => $holiday) {
				if($today_timestamp <= $time && $today_timestamp+(24*60*60) > $time) {
					$events .= date("j",$today_timestamp).": ".$holiday."<br />";
					$class = "holiday";
					$show = $holiday;
				}
			}
			
		}
		
		if($row == 1) { $class = $class." top"; }
		if($col == 7) { $class = $class." right"; }
		
		echo "<td class='".$class."' title='".$show."'>".$day."</td>";
		$day++;
		if($row == 1 && $day > date("t",$month_timestamp-(24*60*60))) { $day = 1; $current = true;}
		if($row > 1 && $day > date("t",$month_timestamp)) { $day = 1; $f = true; $current = false; }
				
		
		
		$col++;
		
		
		
		
	}
	echo "</tr>";
	$row++;
}

echo "</table>";

echo $events;

echo "</div>";


?>

</body>
</html>
