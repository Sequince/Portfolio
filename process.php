<?php
$conf = include('config.php');


$servername = $conf->servername;
$username = $conf->username;
$password = $conf->password;
$dbname = $conf->dbname;

    echo "<link rel='icon' href='Mog.ico'>";
    echo "<title>Seq's Adventure</title>";

    echo "<style>";
        echo "@font-face {";
            echo "font-family: myFirstFont;";
            echo "src: url('sazanami-gothic.otf');";
            echo "}";

        echo "#myResults {";
            echo "font-family: myFirstFont;";
            echo "}";
    echo "</style>";

//Verify all values are sent
if (isset($_POST['select_language']) && (strlen($_POST['convertValue'] > 0))) {

    //Create the connection to the database
    $conn = new mysqli($servername, $username, $password, $dbname);

    //Handle connection failures
    if ($conn->connect_error) {
        die("Connection to database failed: " . $conn->connection_error);
    }

    $conValue = $_POST['convertValue'];
    $selLang = $_POST['select_language'];

    //Query to pull selected languages character using the id from romaji
    $sql = "SELECT $selLang from $selLang WHERE id = (select id from romaji where romaji = '$conValue')";
    

    //$result = $conn->query($sql);
    $result = mysqli_query($conn, $sql);
    
    //Get results (will always be 1 result returned at most in this case)
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<h1 id='myResults'>The $selLang of $conValue is: <nobr style='color: red'>" . $row["$selLang"] . "</nobr></h1>";
        }
    }
    else {
        echo "Please select a valid Romaji character(a value from the chart).";
    }

    echo "<form>";
    echo "<input type='button' id='button' value='Try Again' onclick='history.back()'>";
    echo "</form>";
    echo "<script>document.getElementById('button').focus();</script>";

    //Free results from memory
    mysqli_free_result($result);

    //Closing connection
    mysqli_close($conn);

} else {
        echo "No character provided, please try again.";


        echo "<form>";
        echo "<input type='button' id='button' value='Try Again' onclick='history.back()'>";
        echo "</form>";
        echo "<script>document.getElementById('button').focus();</script>";
}

?>