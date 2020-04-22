<?php
    require_once('connectvars.php');
    
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    
    $file = './Deliverables/sql.sql';
    
    if($fp = file_get_contents($file)) {
      $var_array = explode(';',$fp);
      foreach($var_array as $value) {
        $value = $value.';';
        mysqli_query($dbc, $value);
      }
    }
    
    $home_url = 'logout.php';
    header('Location: ' . $home_url);
?>