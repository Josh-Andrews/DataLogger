<?php

/* pres.php
 *
 * php script to convert sensor sql db into json data
 * grabs timestamp and pressure values
 *
 * Sources:
 *
 *   php999.blogspot.in/2015/05/td-p-margin-bottom-0cm-h1-margin-bottom.html
 *   https://stackoverflow.com/questions/1390983/php-json-encode-encoding-numbers-as-strings
 *
 * Written by Josh Andrews  4/28/18
 */

/* Well be returning JSON data so lets tell the browser that */
header('Content-Type: application/json');

/* Connect to the sensor information  database, readonly of course */
$db = new SQLite3('sensor_data.db', SQLITE3_OPEN_READONLY);
if (!$db) {
    echo "Could not connect to Database!\n";
    exit();
}

/* query database for values */
$result = $db->query('SELECT timestamp,pres FROM sens_data');
if (!$result) {
    echo "Could not open database table!\n";
    $db->close();
    exit();
}

/* create a temporary array to store stuff */
$tmp = array();

/* 
 * Loop through each row of the database, line by line. 
 * $rows gets built up so json_encode will format it correctly
 */
while($r = $result->fetchArray(SQLITE3_ASSOC)) {
    $tmp['t'] = $r['timestamp'];
    $tmp['y'] = $r['pres']; 
    $rows['data1'][] = $tmp;
}

/* encode our data into JSON format and then close the connection */
echo json_encode($rows);
$db->close();
?>
