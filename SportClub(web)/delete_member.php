<?php
$id = $_GET['id'];

require_once 'connect.php';

// Видаляємо відвідування учасника
$sql_delete_visits = "DELETE FROM Visit WHERE FK_Member = ".$id;
if ($conn->query($sql_delete_visits) === TRUE) {
    echo "Visits deleted successfully";
} else {
    echo "Error deleting visits: " . $conn->error;
}

// Видаляємо учасника
$sql_delete_member = "DELETE FROM Members WHERE id = ".$id;
if ($conn->query($sql_delete_member) === TRUE) {
    echo "Member deleted successfully";
} else {
    echo "Error deleting member: " . $conn->error;
}

$conn->close();

header("Location: index.php");
exit;

