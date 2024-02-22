<?php
include 'config.php';
$connection = mysqli_connect(DBSV, DBUSER, DBPASS, DBNAME);
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

$events = array();

$query = "SELECT * FROM CONTENTS_TABLE";
$result = mysqli_query($connection, $query);

while ($row = mysqli_fetch_assoc($result)) {
    $events[] = array(
        'id' => $row['CONTENT_ID'],
        'title' => $row['CONTENT_TITLE'],
        'start' => $row['CONTENT_START_DATETIME'],
        'end' => $row['CONTENT_END_DATETIME'],
        'description' => $row['CONTENT_TEXT'],
        'location' => $row['CONTENT_PLACE']
    );
}

echo json_encode($events);
?>
