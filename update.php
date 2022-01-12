<?php
set_time_limit(0);
ini_set("memory_limit","-1");

$db = new PDO("mysql:host=127.0.0.1;dbname=yeo_4726", "root", "root", array(
    PDO::MYSQL_ATTR_LOCAL_INFILE => true,
));

$query = "SELECT concat('UPDATE ', TABLE_NAME, ' SET ', COLUMN_NAME, ' = REPLACE(', COLUMN_NAME, ', ''".'"'."'', '''')') as s
FROM INFORMATION_SCHEMA.COLUMNS c
WHERE TABLE_SCHEMA = 'yeo_4726';";
$result = $db->query($query,PDO::FETCH_ASSOC);

foreach($result as $key => $re){
    $new = str_replace(["UPDATE ", " SET "," ="],["UPDATE `","` SET `", "` ="],$re['s']);
    $update = $db->prepare($new);
    $update = $update->execute();
    if($update){
        echo 'y';
    }

}

