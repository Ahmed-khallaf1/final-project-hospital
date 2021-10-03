<?php

if(!($_SESSION ['user']['type_id']==1)){
    header("location:".url('index.php'));
}



?>