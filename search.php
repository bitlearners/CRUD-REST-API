    <?php

    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');


    // Connect to your MySQL database
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "himalayan";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get the search term from the query string parameter
    $term = $_GET["term"];

    // Prepare the SQL statement to search for suggestions
    $sql = "SELECT * FROM blog WHERE BName LIKE '%$term%' LIMIT 10";
    $result = $conn->query($sql);

    $suggestions = array(); 

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $suggestion = array(
                "slug" => $row["slug"],
                "BName" => $row["BName"]
            );
            $suggestions[] = $suggestion;
        }
    }

    // Return the suggestions as a JSON response
    header("Content-Type: application/json");
    echo json_encode($suggestions);

    // Close the database connection
    $conn->close();
    ?>