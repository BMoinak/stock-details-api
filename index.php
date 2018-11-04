<?php
session_start();
if(isset($_SESSION['name'])==false)
{
	header("Location: login.php");
}
$us=$_SESSION['name'];
echo "Hi $us";
$conn=mysqli_connect("localhost","root","","flutura");
$res=mysqli_query($conn, "SELECT * from stock_data");
// echo $res->num_rows; 
if($res->num_rows == 0)
{
	header("Location: storedb.php");
}

?>
<html>
<head>
	<title>Stock Prices</title>
	<style type="text/css">
		table,td
		{
			border: solid;
			text-align: center;
		}
		.modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    padding-top: 100px; /* Location of the box */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content */
.modal-content {
    background-color: #fefefe;
    margin: auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
}

	</style>
</head>
<body>
	<a href="logout.php" style="float: right;">Logout</a>
	<h2 style="text-align: center;">Stock Info</h2>
	<form>
	<table style="margin: auto;">
		<?php $count=0; 
		while($row=mysqli_fetch_row($res)){ 

			  if($count==0)
			  	echo "<tr>";
			  $val=$row[0];
			  echo "<td onclick=\"check(this)\">$val</td>";
			  $count++;
			  if($count==15)
			  {
			  	echo "</tr>";
			  	$count=0;
			  }

			}
			 
		?>
	</table>
</form>
<div id="myModal" class="modal">

  <div class="modal-content">
    <span id="bgdata"></span>
  </div>

</div>
</body>
<script>
	var req;
	var modal = document.getElementById('myModal');
	function check(data)
	{
		var symbol= data.innerHTML;
		try{
		req=new XMLHttpRequest();
		req.onreadystatechange= outdat;
		req.open("GET","backend.php?symbol="+symbol,true);
		req.send();
	}
	catch(e)
	{
		alert(e);
		//alert(symbol);
	}

	}
	function outdat()
	{
		if(req.readyState==4 && req.status==200)
		{
			document.getElementById("bgdata").innerHTML= req.responseText;
			modal.style.display = "block";

		}
	}
	window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>
</html>