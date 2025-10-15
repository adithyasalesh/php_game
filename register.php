<?php
if (isset($_POST['register'])) {
    $name   = $_POST['name'];
    $branch = $_POST['branch'];
    $age    = $_POST['age'];
    $phone  = $_POST['phone'];

    // Validate phone number (10 digits only)
    if (!preg_match("/^[0-9]{10}$/", $phone)) {
        echo "<h3 style='color:red;'>Enter a valid phone number</h3>";
    } else {
        echo "<h3 style='color:green;'>Registration Successful!</h3>";
        echo "Name: $name <br>";
        echo "Branch: $branch <br>";
        echo "Age: $age <br>";
        echo "Phone: $phone <br>";
    }
}
?>
