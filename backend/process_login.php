<?php
session_start();
include 'db_connect.php';

function flash(string $type, string $text): void 
{
    $_SESSION['flash'] = [ 
        'type' => $type,   
        'text' => $text    
    ];
}

function redirect_signup(): void 
{
    header("Location: ../signup.php"); 
    exit; 
}

function redirect_login(): void 
{
    header("Location: ../login.php"); 
    exit; 
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') { 
    exit("Invalid access. Open <a href='../login.php'>login.php</a>.");
}

$action = $_POST['action'] ?? '';

if ($action === '') { 
    flash('err', 'No action provided.');
    redirect_login(); 
}

// REGISTRATION
if ($action === 'register') {
    $email = trim($_POST['email'] ?? '');
    $phone_no = trim($_POST['phone_no'] ?? '');
    $password = trim($_POST['password'] ?? '');
    
    if ($email === '' || $phone_no === '' || $password === '') { 
        flash('err', 'Registration failed: email, phone number and password are required.');
        redirect_signup(); 
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        flash('err', 'Registration failed: invalid email format.');
        redirect_signup();
    }

    if (!preg_match('/^09[0-9]{9}$/', $phone_no)) {
        flash('err', 'Registration failed: mobile number must be 11 digits and start with 09.');
        redirect_signup();
    }
    
    if (strlen($password) < 6) { 
        flash('err', 'Registration failed: password must be at least 6 characters.'); 
        redirect_signup();
    }
    
    $hashed = password_hash($password, PASSWORD_ARGON2I);

    $stmt = $conn->prepare("INSERT INTO users (email, phone_no, password) VALUES (?,?,?)"); 
    if (!$stmt) { 
        flash('err', 'Registration failed: database error.'); 
        redirect_signup();
    }

    $stmt->bind_param("sss", $email, $phone_no, $hashed);

    if ($stmt->execute()) { 
        flash('ok', 'Registration successful! You log in now.'); 
    } else { 
        flash('err', 'Registration failed: email or phone number exists already.');
    }

    $stmt->close();
    redirect_login();
}    

// LOGIN
if ($action === 'login') {
    $login_id = trim($_POST['login_id'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($login_id === '' || $password === '') { 
        flash('err', 'Login failed: username and password are required.');
        redirect_login(); 
    }
                        
    $stmt = $conn->prepare("SELECT id, username, email, phone_no, password, role FROM users WHERE username = ? OR email = ? OR phone_no = ? LIMIT 1"); 
    if (!$stmt) { 
        flash('err', 'Login failed: database error.'); 
        redirect_login(); 
    }
    
    $stmt->bind_param("sss", $login_id, $login_id, $login_id); 
    $stmt->execute();
    $result = $stmt->get_result(); 

    if ($row = $result->fetch_assoc()) {
        if (password_verify($password, $row['password'])) {
            session_regenerate_id(true); 

            $_SESSION['user'] = [ 
                'id' => (int)$row['id'], 
                'username' => $row['username'],
                'email' => $row['email'],
                'phone_no' => $row['phone_no'],
                'role' => $row['role']
            ];

            flash('ok', 'Login successful!'); 
            if($row['role'] === 'admin'){
                header("Location: ../pages/admin/dashboard.php");
                exit;
            }else{
                header("Location: ../index.php");
                exit;
            }
            exit;
        } else { 
            flash('err', 'Login failed: invalid username or password.'); 
            redirect_login();
        }
    } else { 
        flash('err', 'Login failed: invalid username or password.'); 
        redirect_login();
    }

    $stmt->close();
}
?>