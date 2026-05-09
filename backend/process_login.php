<?php
session_start();
include 'db_connect.php';

/*
---------------------------------------------------
CHECK REQUEST METHOD
---------------------------------------------------
This checks if the page was accessed using POST.

POST is used when submitting forms such as:
- Login form
- Registration form

If someone tries to open this file directly
through the browser, stop the program.
*/
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { 
    exit("Invalid access. Open <a href='../login.php'>login.php</a>.");
}


/*
---------------------------------------------------
GET ACTION FROM FORM
---------------------------------------------------
This gets the value of "action" from the form.

Examples:
- register
- login
- signout

?? '' means:
If action does not exist, use an empty string.
*/
$action = $_POST['action'] ?? '';


/*
---------------------------------------------------
CHECK IF ACTION EXISTS
---------------------------------------------------
If no action is found, redirect back
to login page with an error.
*/
if ($action === '') { 
    header("Location: ../login.php?error=noaction");
    exit; 
}


/*
===================================================
REGISTRATION PROCESS
===================================================
This section handles user registration.
It creates a new account and stores
the user information in the database.
*/
if ($action === 'register') {

    // Get form values and remove extra spaces.
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone_no = trim($_POST['phone_no'] ?? '');
    $password = trim($_POST['password'] ?? '');
    

    /*
    ---------------------------------------------------
    CHECK REQUIRED FIELDS
    ---------------------------------------------------
    If any input field is empty,
    redirect back with an error.
    */
    if ($username === '' || $email === '' || $phone_no === '' || $password === '') { 
        header("Location: ../signup.php?error=inputrequired");
        exit;  
    }


    /*
    ---------------------------------------------------
    VALIDATE EMAIL FORMAT
    ---------------------------------------------------
    Checks if the email is valid.

    Example valid email:
    test@gmail.com
    */
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        flash('err', 'Registration failed: invalid email format.');
        header("Location: ../signup.php?error=wrongformat");
        exit;
    }


    /*
    ---------------------------------------------------
    VALIDATE PHONE NUMBER FORMAT
    ---------------------------------------------------
    Checks if phone number follows
    Philippine mobile format.

    Example valid number:
    09123456789
    */
    if (!preg_match('/^09[0-9]{9}$/', $phone_no)) {
        header("Location: ../signup.php?error=wrongformat");
        exit;
    }
    

    /*
    ---------------------------------------------------
    CHECK PASSWORD LENGTH
    ---------------------------------------------------
    Password must be at least 6 characters.
    */
    if (strlen($password) < 6) { 
        header("Location: ../signup.php?error=tooshort");
        exit;
    }
    

    /*
    ---------------------------------------------------
    HASH PASSWORD
    ---------------------------------------------------
    Convert password into encrypted text.

    Why?
    Passwords should NEVER be saved directly
    in the database for security reasons.

    PASSWORD_ARGON2I is a secure hashing method.
    */
    $hashed = password_hash($password, PASSWORD_ARGON2I);


    /*
    ---------------------------------------------------
    PREPARE INSERT QUERY
    ---------------------------------------------------
    Insert new user data into database.
    */
    $stmt = $conn->prepare("INSERT INTO users (username, email, phone_no, password) VALUES (?,?,?,?)"); 

    // Check if query preparation failed.
    if (!$stmt) { 
        flash('err', 'Registration failed: database error.'); 
        header("Location: ../signup.php?error=dberror");
        exit;
    }


    /*
    ---------------------------------------------------
    BIND USER VALUES
    ---------------------------------------------------
    "ssss" means all values are strings.
    */
    $stmt->bind_param("ssss", $username, $email, $phone_no, $hashed);


    /*
    ---------------------------------------------------
    EXECUTE REGISTRATION
    ---------------------------------------------------
    Save user data into database.
    */
    if ($stmt->execute()) { 
        
    } else { 

        // Handle duplicate email or phone number.
        flash('err', 'Registration failed: email or phone number exists already.');
        header("Location: ../signup.php?error=exist");
        exit;
    }

    // Close statement.
    $stmt->close();

    // Redirect to login page after success.
    header("Location: ../login.php?success=created");
    exit; 
}    


/*
===================================================
LOGIN PROCESS
===================================================
This section checks if the user's
login credentials are correct.
*/
if ($action === 'login') {

    // Get login input and password.
    $login_id = trim($_POST['login_id'] ?? '');
    $password = trim($_POST['password'] ?? '');


    /*
    ---------------------------------------------------
    CHECK EMPTY INPUTS
    ---------------------------------------------------
    Prevent login if fields are empty.
    */
    if ($login_id === '' || $password === '') { 
        header("Location: ../login.php?error=inputrequired");
        exit; 
    }
                        

    /*
    ---------------------------------------------------
    FIND USER ACCOUNT
    ---------------------------------------------------
    User can log in using:
    - Username
    - Email
    - Phone number
    */
    $stmt = $conn->prepare("SELECT id, username, email, phone_no, password, role FROM users WHERE username = ? OR email = ? OR phone_no = ? LIMIT 1"); 

    // Check if query failed.
    if (!$stmt) { 
        header("Location: ../login.php?error=dberror");
        exit; 
    }
    
    
    /*
    ---------------------------------------------------
    BIND LOGIN INPUT
    ---------------------------------------------------
    Same input is checked against:
    username, email, and phone number.
    */
    $stmt->bind_param("sss", $login_id, $login_id, $login_id); 

    // Execute query.
    $stmt->execute();

    // Get result.
    $result = $stmt->get_result(); 


    /*
    ---------------------------------------------------
    CHECK IF USER EXISTS
    ---------------------------------------------------
    If user is found, verify password.
    */
    if ($row = $result->fetch_assoc()) {

        /*
        Verify entered password against
        hashed password stored in database.
        */
        if (password_verify($password, $row['password'])) {

            /*
            Create new session ID for security.
            Prevents session hijacking.
            */
            session_regenerate_id(true); 


            /*
            SAVE USER DATA INTO SESSION
            ---------------------------------------------------
            Session stores important user info
            while the user stays logged in.
            */
            $_SESSION['user'] = [ 
                'id' => (int)$row['id'], 
                'username' => $row['username'],
                'email' => $row['email'],
                'phone_no' => $row['phone_no'],
                'role' => $row['role']
            ];


            /*
            ---------------------------------------------------
            REDIRECT BASED ON ROLE
            ---------------------------------------------------
            Admin goes to dashboard.
            Customer goes to homepage.
            */
            if($row['role'] === 'admin'){
                header("Location: ../pages/admin/dashboard.php");
                exit;
            }else{
                header("Location: ../index.php");
                exit;
            }

            exit;

        } else { 

            // Wrong password.
            header("Location: ../login.php?error=invalid");
            exit;
        }

    } else { 

        // User not found.
        header("Location: ../login.php?error=invalid");
        exit;
    }

    $stmt->close();
}


/*
===================================================
SIGN OUT PROCESS
===================================================
This section logs the user out.
*/
if ($action === 'signout') { 

    /*
    Remove user session data.
    This logs the user out.
    */
    unset($_SESSION['user']); 

    /*
    Generate a new session ID
    for security purposes.
    */
    session_regenerate_id(true); 

    // Redirect to login page.
    header("Location: ../login.php?success=logout");
    exit;
}
?>