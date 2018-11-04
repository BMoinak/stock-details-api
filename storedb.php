<?php
require_once  'Classes/PHPExcel.php';
$conn=mysqli_connect("localhost","root","","flutura");
$res=mysqli_query($conn, "SELECT * from stock_data");
// echo $res->num_rows; 
if($res->num_rows > 0)
{
	header("Location: storedb.php");
}

$inputFileName = 'stocks.xlsx';
$conn=mysqli_connect("localhost","root","","flutura");
//  Read your Excel workbook
try {
    $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
    $objPHPExcel = $objReader->load($inputFileName);
} catch(Exception $e) {
    die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
}

//  Get worksheet dimensions
$sheet = $objPHPExcel->getSheet(0); 
$highestRow = $sheet->getHighestRow(); 
echo "$highestRow";
$highestColumn = "E";
//  Loop through each row of the worksheet in turn
$sql=$conn->prepare("INSERT INTO stock_data(symbol, name, marketcap, sector, industry) values(?, ?, ?, ?, ?)");
$sql->bind_param("ssdss", $symbol,$name,$marketcap,$sector,$industry);
for ($row = 2; $row <= $highestRow; $row++){ 
    //  Read a row of data into an array
    $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
                                    NULL,
                                    TRUE,
                                    FALSE);
    //  Insert row data array into your database of choice here
    $symbol=$rowData[0][0];
    $name= $rowData[0][1];
    $marketcap=$rowData[0][2];
    $sector=$rowData[0][3];
    $industry=$rowData[0][4];
   	//echo "$symbol $name $marketcap $sector $industry<br>";
    $sql->execute();
    //var_dump($rowData);
    //echo "<br><br>";
}
header("Location: index.php");
?>