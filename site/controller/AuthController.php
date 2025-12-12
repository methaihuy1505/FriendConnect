<?php

class AuthController
{
    public function profileSetup()
    {
        $repo      = new InterestRepository();
        $interests = $repo->getAll();
        require "view/profilesetup/index.php";
    }
    public function login()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $email    = $_POST["email"] ?? '';
            $password = $_POST["password"] ?? '';

            $userRepo = new UserRepository();
            $user     = $userRepo->findByEmail($email);

            if ($user && password_verify($password, $user->getPasswordHash())) {
                $_SESSION['user_id'] = $user->getId();
                $_SESSION['role']    = $user->getRole();
                header("Location: index.php?c=dashboard");
                exit;
            } else {
                $_SESSION['login_error'] = "Sai email hoặc mật khẩu";
                header("Location: index.php");
                exit;
            }
        } else {
            header("Location: index.php?c=home");
        }

    }

    public function register()
    {
        $userRepo = new UserRepository();
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $name     = $_POST['name'] ?? '';
            $email    = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            if (! empty($userRepo->findByEmail($email))) {
                $_SESSION['register_error'] = 'Email đã tồn tại';
                header("Location: index.php?c=auth&a=profileSetup");
                exit;
            }
            $birthDay   = $_POST['birthDay'] ?? '';
            $birthMonth = $_POST['birthMonth'] ?? '';
            $birthYear  = $_POST['birthYear'] ?? '';
            $birthDate  = null;
            if ($birthDay && $birthMonth && $birthYear) {
                $birthDate = sprintf("%04d-%02d-%02d", (int) $birthYear, (int) $birthMonth, (int) $birthDay);
            }

            $gender             = $_POST['gender'] ?? null;
            $orientation        = $_POST['orientation'] ?? null;
            $interestedIn       = $_POST['interested_in'] ?? null;
            $relationshipIntent = $_POST['relationship_intent'] ?? null;
            $avatarUrl          = null;
            if (! empty($_FILES['avatar_url']['name'])) {
                $targetDir = "upload/";
                if (! is_dir($targetDir)) {
                    mkdir($targetDir, 0777, true);
                }
                $fileName   = time() . "_" . basename($_FILES["avatar_url"]["name"]);
                $targetFile = $targetDir . $fileName;
                if (move_uploaded_file($_FILES["avatar_url"]["tmp_name"], $targetFile)) {
                    $avatarUrl = $fileName;
                }
            }
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            $user         = new User(
                null,
                $name,
                $email,
                $passwordHash,
                $birthDate,
                $gender,
                $orientation,
                $interestedIn,
                $relationshipIntent,
                $avatarUrl,
                null
            );

            $userRepo = new UserRepository();
            $userId   = $userRepo->save($user);
            if (! empty($_POST['interests'])) {
                $userRepo->saveUserInterests((int) $userId, $_POST['interests']);
            }
            $_SESSION['register_success'] = 'Đăng ký thành công! Bạn có thể đăng nhập.';
            header("Location: index.php?c=home&a=index");
            exit;
        } else {
            $_SESSION['register_error'] = 'Đăng ký thất bại, vui lòng thử lại.';
            header("Location: index.php?c=auth&a=profileSetup");
            exit;
        }
    }

    public function logout()
    {
        session_unset();
        session_destroy();

        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        header('Location: index.php?c=home');
        exit;
    }
}
