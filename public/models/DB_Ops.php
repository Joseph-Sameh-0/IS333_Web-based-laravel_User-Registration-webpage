<?php

class DBModel
{
    private static $user = "developer_2025";
    private static $host = "localhost";
    private static $pass = "@web2025";
    private static $db = "user_management";
    private static $conn = null;

    public static function connectDB()
    {
        if (self::$conn === null) {
            self::$conn = new mysqli(self::$host, self::$user, self::$pass, self::$db);

            // Check for connection errors
            if (self::$conn->connect_error) {
                die("Database Connection Failed: " . self::$conn->connect_error);
            }
            return self::$conn;
            //     echo "Database connected successfully!<br>";
            // } else {
            //     echo "Already connected!<br>";
            // }
        }
        return null;
    }


    // Close the connection
    private static function closeConnection()
    {
        if (self::$conn !== null) {
            mysqli_close(self::$conn);
            self::$conn = null;// Reset connection to null
            // echo "Database connection closed!<br>";
        }
        // else {
        //     echo "No active connection to close!<br>";
        // }
    }


    // Function to check if the table exists
    public static function tableExists($tableName)
    {
        self::connectDB();
        if (self::$conn === null) {
            echo "No active database connection!<br>";
            return false;
        }
        $query = "SHOW TABLES LIKE '$tableName'";
        $result = self::$conn->query($query);
        self::closeConnection();
        return $result->num_rows > 0; // If rows exist, table exists
    }

    // Function to create the users table if it doesn't exist
    public static function createUsersTable()
    {
        if (self::tableExists("users")) {
            echo "Table 'users' already exists.<br>";
            return false;
        }
        self::connectDB();
        if (self::$conn === null) {
            echo "No active database connection!<br>";
            return false;
        }
        $sql = "CREATE TABLE `users` (
            `user_id` int(11) NOT NULL AUTO_INCREMENT,
            `user_name` varchar(50) NOT NULL,
            `full_name` varchar(255) NOT NULL,
            `phone` varchar(20) NOT NULL,
            `whatsup_number` varchar(20) NOT NULL,
            `address` text NOT NULL,
            `password` varchar(255) NOT NULL,
            `email` varchar(255) NOT NULL,
            `User_img` varchar(255) NOT NULL,
            `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
            PRIMARY KEY (`user_id`),
            UNIQUE KEY `Unique_User` (`user_name`),
            UNIQUE KEY `Unique_email` (`email`)
        ) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";

        if (self::$conn->query($sql) === TRUE) {
            echo "Table 'users' created successfully.<br>";
            self::closeConnection();
            return true;
        } else {
            echo "Error creating table: " . self::$conn->error . "<br>";
            self::closeConnection();
            return false;
        }
    }

    public static function checkUsernameExists($username)
    {
        self::connectDB();
        if (self::$conn === null) {
            echo "No active database connection!<br>";
            return false;
        }
        $stmt = self::$conn->prepare("SELECT user_id FROM users WHERE user_name = ?");
        $stmt->execute([$username]); //Executes the query by passing $username given by user into the placeholder (?).
        $stmt->store_result();
        self::closeConnection();
        return $stmt->num_rows > 0; //If rowCount() > 0, it means a username exists, so it returns true.

    }

    public static function checkPhoneExists($phone)
    {
        self::connectDB();
        if (self::$conn === null) {
            echo "No active database connection!<br>";
            return false;
        }
        $stmt = self::$conn->prepare("SELECT user_id FROM users WHERE phone = ?");
        $stmt->execute([$phone]);
        $stmt->store_result();
        self::closeConnection();
        return $stmt->num_rows > 0;
    }

    public static function checkEmailExists($email)
    {
        self::connectDB();
        if (self::$conn === null) {
            echo "No active database connection!<br>";
            return false;
        }
        $stmt = self::$conn->prepare("SELECT user_id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $stmt->store_result();
        self::closeConnection();
        return $stmt->num_rows > 0;
    }

    public static function isValidImageExtension($fileName)
    {
        $validExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION)); // Get the extension from image
        return in_array($ext, $validExtensions);
    }

    public static function saveUser($user_name, $full_name, $phone, $whatsup_number, $address, $password, $email, $User_img)
    {
        self::connectDB();

        if (self::$conn === null) {
            echo "No active database connection!<br>";
            return false;
        }

        $stmt = self::$conn->prepare("INSERT INTO `users` (`user_name`, `full_name`, `phone`, `whatsup_number`, `address`, `password`, `email`, `User_img`)
                                VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

        if ($stmt === false) {
//            die("Error in preparing statement: " . self::$conn->error);
            echo "Error in preparing statement: " . self::$conn->error;
            return false;
        }

        // Hash password
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $imagePath = 'public/uploads/' . $User_img;

        // Bind the parameters to the SQL statement
        $stmt->bind_param("ssssssss", $user_name, $full_name, $phone, $whatsup_number, $address, $hashedPassword, $email, $imagePath);
        if ($stmt->execute()) {
//            echo "User registered successfully!";
            self::closeConnection();
            return true;
        } else {
            echo "Error: " . $stmt->error;
            self::closeConnection();
            return false;
        }
    }
}

// if (DBModel::checkUsernameExists("amany11")) {
//     echo "Username exists!<br>";
// } else {
//     echo "Username does not exist!<br>";
// }

/////////////////////////////////////////////////////////////////////////////////////////

//  RUN THIS FUNCTION   to create table user in  your Mysql server
//DBModel::createUsersTable();
