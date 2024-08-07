<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$servername = "localhost";
$username = "root";
$password = "password";
$dbname = "ashis";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = ""; // Initialize the message variable

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $messageText = isset($_POST['message']) ? $_POST['message'] : '';

    if (empty($name) || empty($email) || empty($messageText)) {
        $message = "Please fill in all fields.";
    } else {
        $sql = "INSERT INTO contacts (name, email, message) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);

        if ($stmt === false) {
            die("Error preparing statement: " . $conn->error);
        }

        $stmt->bind_param("sss", $name, $email, $messageText);

        if ($stmt->execute() === false) {
            $message = " Thank you, Your message has been received.";
        } else {
            $message = "There was an issue with your submission. Please try again..";
        }

        $stmt->close();
    }
}

$conn->close();

// Output the message as JSON
echo json_encode(array("message" => $message));
?>
