<?php
session_start();
include('../include/config.php');
include('../include/header.php');

$formToShow = 'login';
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($email) || empty($password)) {
        $error = "Please fill in all fields.";
    } else {
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? LIMIT 1");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();

            if (password_verify($password, $row['password'])) {
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['admin_user_id'] = $row['id'];
                $_SESSION['admin_role'] = $row['role'];

                header("Location: ./admin.php");
                exit();
            } else {
                $error = "Invalid email or password.";
            }
        } else {
            $error = "Invalid email or password.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Login | Midnight Vogue</title>
    <style>
        :root {
            --bg: #000;
            --card: #0f0f11;
            --muted: #9ca3af;
            --accent: #7C3AED;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'Montserrat', sans-serif;
            background: var(--bg);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 420px;
            width: 100%;
            background: var(--card);
            border-radius: 14px;
            padding: 28px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.6);
        }

        h1 {
            margin: 0 0 8px;
            font-size: 22px;
        }

        p {
            margin: 0 0 18px;
            color: var(--muted);
            font-size: 14px;
        }

        .error {
            color: #f87171;
            margin-bottom: 14px;
            font-size: 14px;
        }

        .success {
            color: #4ade80;
            margin-bottom: 14px;
            font-size: 14px;
        }

        label {
            font-size: 13px;
            color: var(--muted);
            display: block;
            margin-bottom: 6px;
        }

        .input {
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            border: 1px solid #222;
            background: #1a1a1a;
            color: #fff;
            margin-bottom: 14px;
        }

        .input:focus {
            border-color: var(--accent);
            outline: none;
        }

        .btn {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 8px;
            background: var(--accent);
            color: #fff;
            font-weight: 600;
            cursor: pointer;
            margin-top: 6px;
        }

        .btn:hover {
            opacity: 0.9;
        }

        .footer-note {
            margin-top: 12px;
            text-align: center;
            color: var(--muted);
            font-size: 12px;
        }
    </style>
</head>

<body>
    <main class="container">
        <h1>Admin Login</h1>
        <p>Sign in to access the admin panel.</p>

        <?php if ($error): ?><div class="error"><?= $error ?></div><?php endif; ?>
        <?php if ($success): ?><div class="success"><?= $success ?></div><?php endif; ?>

        <form method="post" id="loginForm">
            <label>Email</label>
            <input type="email" name="email" class="input" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>

            <label>Password</label>
            <input type="password" name="password" class="input" required>

            <button type="submit" name="login" class="btn">Sign In</button>
        </form>

        <p class="footer-note">
            By continuing you agree to our
            <a href="#" style="color:var(--accent);text-decoration:none">Terms</a> and
            <a href="#" style="color:var(--accent);text-decoration:none">Privacy</a>.
        </p>
        <p class="text-center"><a href="index.php" style="color:var(--accent);text-decoration:none">Guest</a></p>
    </main>
</body>

</html>
