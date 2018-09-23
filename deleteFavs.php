<?php
require 'ConnectionClass.php';
echo $_POST['FullName'];   
$conObj->DeleteFavorite(trim($_POST['FullName'])); 
