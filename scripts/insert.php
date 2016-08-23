<?php

header('Content-type: application/json');


$servername = "localhost";
$username = "root";
$password = "";

try {
    $conn = new PDO("mysql:host=$servername;dbname=moviemap", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $nowFormat = date('Y-m-d H:i:s');
    $imdb_id = $_GET['imdb_id'];

    //check if movie is already listed in db
    $query = "SELECT COUNT(*) FROM watched WHERE imdb_id='$imdb_id'";
    $result = $conn->prepare($query);
    $result->execute();
    $num_rows = $result->fetchColumn();


    if($num_rows > 0) {
       $response_array['status'] = "error";
       $response_array['error_reason'] = "movie_already_watched";
       echo json_encode($response_array);
    }
    else {
        $query = "INSERT INTO watched (username, imdb_id, datetime_watched) VALUES (:username, :imdb_id, :datetime_watched)";
        $user = "simen";

        $stmt = $conn->prepare($query);
        $stmt->bindParam(':username', $user, PDO::PARAM_STR);
        $stmt->bindParam(':imdb_id', $imdb_id, PDO::PARAM_STR);
        $stmt->bindParam(':datetime_watched', $nowFormat, PDO::PARAM_STR);

        $stmt->execute();

        $response_array['status'] = "success";
        echo json_encode($response_array);
    }
}
catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>