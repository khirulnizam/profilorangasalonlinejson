<?php 
// http://khirulnizam.com/training/1listorangasal.php
//access dari ionic client
header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
	header("Access-Control-Allow-Methods: GET");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include "connect.php";

//filename aduanlisting.php for ionic json db connectivity

//keyword

if(!isset($_GET['key'])){
	$key=null;
}
else {
	$key=$_GET['key'];
}

//generate JSON from table

$orangasal= array();
$response["orangasal"]=array();

$sql="SELECT id,nokp,nama, pendapatan
FROM orangasal
WHERE nama  LIKE '%$key%' ";

//run query

$rs=mysqli_query($db,$sql);

if($rs==false){
	echo mysqli_error($rs);
}
//no record found
if (mysqli_num_rows($rs)==0){
}

else{//found some records
	while($rec=mysqli_fetch_array($rs)){
		//capture one record
		$orangasal=array();
		$orangasal["id"] = $rec["id"];
		$orangasal["nokp"] = $rec["nokp"];
		$orangasal["nama"] = $rec["nama"];
		$orangasal["pendapatan"] = $rec["pendapatan"];

		//push to response 
		array_push($response["orangasal"], $orangasal);

	}//end while
	

}//end found records
//simpan data dalam format json
echo json_encode($response,JSON_PRETTY_PRINT);


?>