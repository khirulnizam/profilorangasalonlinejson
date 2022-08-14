<?php 
header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include "connect.php";
// TAMBAH INFO ORANG ASAL
	$_POST = json_decode(file_get_contents('php://input'), true);
    	$nama = $_POST['nama'];
        $nokp = $_POST['nokp'];
        $pendapatan = $_POST['pendapatan'];
	//$obj = json_decode($json);
  
        $sql = "INSERT IGNORE INTO orangasal (nokp, nama, pendapatan)
            VALUES ('$nokp','$nama','$pendapatan')";
	//echo $sql; 
	//echo file_get_contents('php://input');
        $result = mysqli_query($db,$sql);
        if ($result==true){
            echo '{"success":"true","error":"null"}' ;
                //echo $sql;
                //echo '"}';
  //success message sent back to mobile app
            
        }
	    else {
	        //echo "error_".mysqli_error($db);
	        echo '{"success":"false", "error":"'.mysqli_error($db).'"}';
		    //echo "error";//error message sent back to mobile app
	        
	    }
        //$conn->close();    
    
    ?>