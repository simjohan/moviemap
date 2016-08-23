<?php



function getCurrent() {
$servername = "localhost";
$username = "root";
$password = "";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=moviemap", $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "Connected successfully";

        $query = "SELECT * FROM track";

        foreach ($conn->query($query) as $row) {
            echo $row['datetime_seen'];
        }

    }
    catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
}

getCurrent();

?>