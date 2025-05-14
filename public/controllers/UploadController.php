<?php
include "../models/DB_Ops.php";

if ($_SERVER['POST']) {
  // Data to use in the saveUser function
  $user_name     = $_POST['signUpName'];
  $full_name     = $_POST['FullName'];
  $phone         = $_POST['phone'];
  $whatsapp_code = $_POST['whatsappCountryCode'];
  $whatsapp      = $_POST['whatsapp'];
  $address       = $_POST['address'];
  $email         = $_POST['signUpEmail'];
  $password      = $_POST['signUpPassword'];

  // Handle Image Upload
  $uploadDir = "../public/uploads/";

  if (isset($_FILES["userImage"]) && $_FILES["userImage"]["error"] === 0) {
    $image = basename($_FILES["userImage"]["name"]);
    $imageFileType = strtolower(pathinfo($image, PATHINFO_EXTENSION));

    // Validate image file
    if (
      in_array($imageFileType, ["jpg", "jpeg", "png", "gif"]) &&
      $_FILES["userImage"]["size"] <= 500000
    ) {
      $uploadPath = $uploadDir . $image;
      if (move_uploaded_file($_FILES["userImage"]["tmp_name"], $uploadPath)) {
        $User_img = $image;
      } else {
        die("Failed to move uploaded file.");
      }
    } else {
      die("Failed to upload image.");
    }
  } else {
    die("No image uploaded.");
  }

  // Save user using DBModel
  $result = DBModel::saveUser($user_name, $full_name, $phone, $whatsup_number, $address, $password, $email, $User_img);

  if ($result) {
    echo "User registered successfully.";
  } else {
    echo "Failed to register user.";
  }
}
