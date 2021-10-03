<?php 

  $server = "localhost";
  $dbName = "final_hospital_project";
  $dbUser = "root";
  $dbPassword = "";


    $con =  mysqli_connect($server,$dbUser,$dbPassword,$dbName);

    if(!$con){

        die("Error : ".mysqli_connect_error());
    }


?>