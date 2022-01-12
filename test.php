<?php

$db = new PDO("mysql:host=127.0.0.1;dbname=yeo_4726", "root", "root", array(
    PDO::MYSQL_ATTR_LOCAL_INFILE => true,
));
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

/********************************************************************************/
// Parameters: filename.csv table_name

$argv = $_SERVER[argv];

if($argv[1]) { $file = $argv[1]; }
else {
    echo "Please provide a file name\n"; exit;
}
if($argv[2]) { $table = $argv[2]; }
else {
    $table = pathinfo($file);
    $table = $table['filename'];
}

/********************************************************************************/
// Get the first row to create the column headings

$fp = fopen($file, 'r');
$frow = fgetcsv($fp,null,';');
$columns = '';

//$columns .= "`id` int NOT NULL AUTO_INCREMENT PRIMARY KEY";

foreach($frow as $column) {
    if($columns) $columns .= ', ';
    $columns .= "`$column` varchar(250)";
}

$create = "create table if not exists `{$table}` ({$columns});";

$c = $db->exec($create);

/********************************************************************************/
// Import the data into the newly created table.

$file = $_SERVER['PWD'].'/'.$file;
$enclosed = '"';
$q = "load data local infile '{$file}' into table `{$table}` fields terminated by ';' ignore 1 lines";
$qq = $db->exec($q);
?>


