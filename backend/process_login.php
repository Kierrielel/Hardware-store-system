<?php
session_start();
include 'db_connect.php';

// Allow only POST request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { 
    exit("Invalid access. Open <a href='../login.php'>login.php</a>.");
}

// Get form action
$action = $_POST['action'] ?? '';

// If no action, go back
if ($action === '') { 
    header("Location: ../login.php?error=noaction");
    exit; 
}

// ================= REGISTER =================
if ($action === 'register') {

    // Get and clean inputs
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone_no = trim($_POST['phone_no'] ?? '');
    $password = trim($_POST['password'] ?? '');

    // Check empty fields
    if ($username === '' || $email === '' || $phone_no === '' || $password === '') { 
        header("Location: ../signup.php?error=inputrequired");
        exit;  
    }

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        flash('err', 'Registration failed: invalid email format.');
        header("Location: ../signup.php?error=wrongformat");
        exit;
    }

    // Validate phone number
    if (!preg_match('/^09[0-9]{9}$/', $phone_no)) {
        header("Location: ../signup.php?error=wrongformat");
        exit;
    }

    // Check password length
    if (strlen($password) < 6) { 
        header("Location: ../signup.php?error=tooshort");
        exit;
    }

    // Hash password
    $hashed = password_hash($password, PASSWORD_ARGON2I);

    // Insert new user
    $stmt = $conn->prepare("INSERT INTO users (username, email, phone_no, password) VALUES (?,?,?,?)"); 

    // Check query
    if (!$stmt) { 
        flash('err', 'Registration failed: database error.'); 
        header("Location: ../signup.php?error=dberror");
        exit;
    }

    // Bind values
    $stmt->bind_param("ssss", $username, $email, $phone_no, $hashed);

    // Execute insert
    if ($stmt->execute()) { 
        
    } else { 
        // If duplicate
        flash('err', 'Registration failed: email or phone number exists already.');
        header("Location: ../signup.php?error=exist");
        exit;
    }

    $stmt->close();

    // Redirect after success
    header("Location: ../login.php?success=created");
    exit; 
}    


// ================= LOGIN =================
if ($action === 'login') {

    // Get login input
    $login_id = trim($_POST['login_id'] ?? '');
    $password = trim($_POST['password'] ?? '');

    // Check empty fields
    if ($login_id === '' || $password === '') { 
        header("Location: ../login.php?error=inputrequired");
        exit; 
    }

    // Find user (username/email/phone)
    $stmt = $conn->prepare("SELECT id, username, email, phone_no, password, role FROM users WHERE username = ? OR email = ? OR phone_no = ? LIMIT 1"); 

    // Check query
    if (!$stmt) { 
        header("Location: ../login.php?error=dberror");
        exit; 
    }

    // Bind input
    $stmt->bind_param("sss", $login_id, $login_id, $login_id); 
    $stmt->execute();
    $result = $stmt->get_result(); 

    // If user found
    if ($row = $result->fetch_assoc()) {

        // Verify password
        if (password_verify($password, $row['password'])) {

            // Secure session
            session_regenerate_id(true); 

            // Save user session
            $_SESSION['user'] = [ 
                'id' => (int)$row['id'], 
                'username' => $row['username'],
                'email' => $row['email'],
                'phone_no' => $row['phone_no'],
                'role' => $row['role']
            ];

            // Redirect by role
            if($row['role'] === 'admin'){
                header("Location: ../pages/admin/dashboard.php");
            }else{
                header("Location: ../index.php");
            }
            exit;

        } else { 
            // Wrong password
            header("Location: ../login.php?error=invalid");
            exit;
        }

    } else { 
        // User not found
        header("Location: ../login.php?error=invalid");
        exit;
    }

    $stmt->close();
}


// ================= SIGN OUT =================
if ($action === 'signout') { 

    // Remove session
    unset($_SESSION['user']); 

    // Regenerate session ID
    session_regenerate_id(true); 

    // Redirect to login
    header("Location: ../login.php?success=logout");
    exit;
}
?>