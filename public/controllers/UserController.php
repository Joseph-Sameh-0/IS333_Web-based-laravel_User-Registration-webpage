<?php

include '../models/DB_Ops.php';

class UserController
{
    public static function register()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            header('Content-Type: application/json'); // Ensure JSON response

            // Handle full registration
            $errors = [];

            // Get Form Data
            $fullName = trim($_POST['FullName']);
            $username = trim($_POST['signUpName']);
            $phone = trim($_POST['phone']);
            $whatsappCountryCode = trim($_POST['whatsappCountryCode']);
            $whatsapp = trim($_POST['whatsapp']);
            $address = trim($_POST['address']);
            $email = trim($_POST['signUpEmail']);
            $password = $_POST['signUpPassword'];
            $confirmPassword = $_POST['signUpRePassword'];
            $userImage = $_FILES['userImage']['name'];

            // Server-side Validations
            if (strlen($fullName) < 3 || !preg_match("/^[a-zA-Z\s]+$/", $fullName)) {
                $errors['FullName'] = "Minimum 3 characters, only letters and spaces allowed.";
            }


            // Username validation and suggestion
            if (strlen($username) < 3 || !preg_match("/^[a-zA-Z0-9]+$/", $username)) {
                $errors['name'] = "Minimum 3 characters, only letters A-Z and numbers 0-9 allowed.";
            } else {
                if (DBModel::checkUsernameExists($username)) {
                    $suggestions = [];
                    $baseUsername = $username; // Keep the original username as base

                    // Function to generate random alphanumeric characters
                    function generateRandomChars($length = 3) {
                        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
                        $randomChars = '';
                        for ($i = 0; $i < $length; $i++) {
                            $randomChars .= $chars[rand(0, strlen($chars) - 1)];
                        }
                        return $randomChars;
                    }

                    // Generate 3 suggestions by appending random alphanumeric characters
                    for ($i = 0; $i < 3; $i++) {
                        $suggestion = $baseUsername . generateRandomChars(3); // Append 3 random alphanumeric characters
                        while (DBModel::checkUsernameExists($suggestion)) {
                            $suggestion = $baseUsername . generateRandomChars(3);
                        }
                        $suggestions[] = $suggestion;
                    }

                    $errors['name'] = "Username already exists. Suggestions: " . implode(", ", $suggestions);
                }
            }

            if (!preg_match("/^\d{10,15}$/", $phone)) {
                $errors['phone'] = "Enter a valid phone number (10-15 digits).";
            }

            if (DBModel::checkPhoneExists($phone)) {
                $errors['phone'] = "Phone number already in use.";
            }

            if ($whatsappCountryCode == null){
                $errors['whatsapp'] = "Enter a valid WhatsApp country code";
            }

            //TODO: Use APIController to check the whatsapp number
//            if (true) {
//                $errors['whatsapp'] = "This is not whatsapp number";
//            }

            if (!DBModel::isValidImageExtension($_FILES["userImage"]["name"])) {
                $errors['userImage'] = "Only JPG, PNG, JPEG, and GIF are allowed.";
            }

            if (!preg_match("/^\d{10,15}$/", $whatsapp)) {
                $errors['whatsapp'] = "Enter a valid WhatsApp number (10-15 digits).";
            }

            if (DBModel::checkPhoneExists($whatsappCountryCode.$whatsapp)) {
                $errors['whatsapp'] = "WhatsApp number already in use.";
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = "Invalid email format.";
            }

            if (DBModel::checkEmailExists($email)) {
                $errors['email'] = "Email already in use.";
            }

            if ((strlen($password) < 8) || !preg_match("/\d/", $password) || !preg_match("/[^a-zA-Z0-9]/", $password)) {
                $errors['password'] = "Password must be at least 8 characters, with one number and one special character.";
            }

            if ($password !== $confirmPassword) {
                $errors['repassword'] = "Passwords do not match.";
            }

            if ($confirmPassword == null) {
                $errors['repassword'] = "Confirm passwords can't be empty";
            }

            // TODO: Not handled
//            if($userImage == null){
//                $errors["userImage"] = "There is no Image Uploaded";
//            }

            // If there are errors, return them without refreshing the page
            if (!empty($errors)) {
                echo json_encode(["status" => "error", "errors" => $errors]);
                exit;
            }

            // Save user
            if (DBModel::saveUser($username, $fullName, $phone, $whatsappCountryCode.$whatsapp, $address, $password, $email, $userImage)) {
                move_uploaded_file($_FILES['userImage']['tmp_name'], "../../public/uploads/" . $userImage);
                echo json_encode(["status" => "success", "message" => "Registration successful!"]);
            } else {
                echo json_encode(["status" => "error", "message" => "Registration failed."]);
            }
            exit;

            // For now, just return a success message
            echo json_encode(["status" => "success", "message" => "Registration successful!"]);
            exit;

        }
    }
}

// Handle AJAX requests
if (isset($_POST['action']) && $_POST['action'] == "register") {
    UserController::register();
}