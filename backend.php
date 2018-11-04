<?php

$sym =(isset($_GET['symbol']))?$_GET['symbol']:null;
$conn=mysqli_connect("localhost","root","","flutura");
//echo $sym;
$sql=  "SELECT * from stock_data where symbol = '".$sym."'";
$res=mysqli_query($conn, $sql);
//var_dump($res);
echo "<h2 style =\"text-align: center; \"><u>Details of the Stock: $sym </u></h2>";
while($opt=mysqli_fetch_row($res))
{
	echo "<table style=\"float: left; margin: 0.6em;\"><tr><td><b>Symbol: </b></td><td>".$opt[0]."</td></tr><tr><td><b>Name: </b></td><td>".$opt[1]."</td></tr><tr><td><b>MarketCap: </b></td><td>".$opt[2]."</td></tr><tr><td><b>Sector: </b></td><td>".$opt[3]."</td></tr><tr><td><b>Industry: </b></td><td>".$opt[4]."</td></tr></table><table style=\" margin: 0.6em;\">";
}
$api = "https://www.alphavantage.co/query?function=GLOBAL_QUOTE&symbol=".$sym."&apikey=S9LGM2V6PT50AYJQ";
//echo "$api";
$dat = json_decode(file_get_contents($api));
//var_dump($dat);
foreach ($dat as $key => $value) {
	
	foreach ($value as $key1 => $value1) {
		# code...
		echo "<tr><td><b>".$key1.": </b></td><td> ".$value1."</td></tr>";
		
	}
	echo "</table>";
}
?>