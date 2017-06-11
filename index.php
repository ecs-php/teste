<?php
  require 'database.php';


  // get the HTTP method, path and body of the request
  $method = $_SERVER['REQUEST_METHOD'];
  $request = explode('/', trim($_SERVER['PATH_INFO'],'/'));
  $input = json_decode(file_get_contents('input.json'),true);

  // connect to the sqlite database
  $db = new MyDB();
   
  // retrieve the table and key from the path
  $table = preg_replace('/[^a-z0-9_]+/i','',array_shift($request));
  $key = array_shift($request)+0;
   
  // escape the columns and values from the input object
  $columns = preg_replace('/[^a-z0-9_]+/i','',array_keys($input));
  $values = array_values($input);
   
  // build the SET part of the SQL command
  $set = '';
  for ($i=0;$i<count($columns);$i++) {
    $set.=($i>0?',':'').'`'.$columns[$i].'`=';
    $set.=($values[$i]===null?'NULL':'"'.$values[$i].'"');
  }

  $insValues = "'" . implode("','", $values) . "'";
   
  // create SQL based on HTTP method and execute SQL statement
  $result = null;
  switch ($method) {
    case 'GET':
      $sql = "select * from `$table`".($key?" WHERE id=$key":''); 
      $result = $db->query($sql);
      break;
    case 'PUT':
      $sql = "update `$table` set $set, alter_date = CURRENT_TIMESTAMP where id=$key"; 
      $result = $db->exec($sql);
      break;
    case 'POST':
      $sql = "insert into `$table` values ($insValues, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)"; 
      $result = $db->exec($sql);
      break;
    case 'DELETE':
      $sql = "delete from `$table` where id=$key"; 
      $result = $db->exec($sql);
      break;
  }
      
  // print results, insert id or affected row count
  if ($method == 'GET') {
    if (!$key) echo '[';
    $array = array();
    while($row = $result->fetchArray(SQLITE3_ASSOC) ){
      $array[] = $row;
    }
    echo json_encode($array);
    if (!$key) echo ']';
  } else {
    echo json_encode('OK');
  }
   
  // close sqlite connection
  $db->close();