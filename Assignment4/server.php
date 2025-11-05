<?php
// Database connection
$host = "localhost";   // XAMPP default
$user = "root";        // XAMPP default
$pass = "";            // by default XAMPP root has no password
$db   = "student";     // your database name

$conn = mysqli_connect($host, $user, $pass, $db);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$mode = $_GET['mode'] ?? '';

// READ
if ($mode == "read") {
    $q = mysqli_query($conn, "SELECT * FROM student_data");
    $data = [];
    while ($r = mysqli_fetch_assoc($q)) {
        $data[] = $r;
    }
    echo json_encode($data);
}

// CREATE
if ($mode == "add") {
    $n = mysqli_real_escape_string($conn, $_POST['name']);
    $m = mysqli_real_escape_string($conn, $_POST['marks']);

    $q = "INSERT INTO student_data (name, marks) VALUES ('$n','$m')";
    if (mysqli_query($conn, $q)) {
        echo "Student Added!";
    } else {
        echo "Error inserting: " . mysqli_error($conn);
    }
}

// UPDATE
if ($mode == "edit") {
    $id = intval($_POST['id']);
    $n = mysqli_real_escape_string($conn, $_POST['name']);
    $m = mysqli_real_escape_string($conn, $_POST['marks']);

    $q = "UPDATE student_data SET name='$n', marks='$m' WHERE id=$id";
    if (mysqli_query($conn, $q)) {
        echo "Student Updated!";
    } else {
        echo "Error updating: " . mysqli_error($conn);
    }
}

// DELETE
if ($mode == "remove") {
    $id = intval($_POST['id']);

    $q = "DELETE FROM student_data WHERE id=$id";
    if (mysqli_query($conn, $q)) {
        echo "Student Deleted!";
    } else {
        echo "Error deleting: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>
