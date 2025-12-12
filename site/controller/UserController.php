<?php
class UserController
{

    public function update()
    {

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $userRepo = new UserRepository();

            $id = $_POST['id'] ?? '';

            $name  = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';

            // Ghép ngày sinh 
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
            // Xử lý upload ảnh
            // Lấy avatar cũ từ DB 
            $user      = $userRepo->find($id);
            $oldAvatar = $user->getAvatarUrl();

            $avatarUrl = $oldAvatar; // mặc định giữ nguyên

            if (! empty($_FILES['avatar_url']['name'])) {
                $targetDir = "upload/";
                if (! is_dir($targetDir)) {
                    mkdir($targetDir, 0777, true);
                }

                $fileName   = time() . "_" . basename($_FILES["avatar_url"]["name"]);
                $targetFile = $targetDir . $fileName;

                if (move_uploaded_file($_FILES["avatar_url"]["tmp_name"], $targetFile)) {
                    $avatarUrl = $fileName; // lưu tên file mới

                    // Xóa file cũ nếu tồn tại
                    if ($oldAvatar && file_exists($targetDir . $oldAvatar)) {
                        unlink($targetDir . $oldAvatar);
                    }
                }
            }

            $user = new User(
                $id,
                $name,
                $email,
                null,
                $birthDate,
                $gender,
                $orientation,
                $interestedIn,
                $relationshipIntent,
                $avatarUrl,
                null
            );
            $userRepo->update($user);

            $userRepo->updateUserInterests((int) $id, $_POST['interests']);

        }
        header("Location: index.php?c=dashboard#edit");
    }
    public function updatePass()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $currentPassword = $_POST["currentPassword"] ?? '';
            $newPassword     = $_POST["newPassword"] ?? '';
            $confirmPassword = $_POST["confirmPassword"] ?? '';

            $userRepo = new UserRepository();
            $user     = $userRepo->find($_SESSION['user_id']);

            // Kiểm tra mật khẩu hiện tại
            if (! $user || ! password_verify($currentPassword, $user->getPasswordHash())) {
                $_SESSION['error'] = "Mật khẩu hiện tại không đúng";
                header("Location: index.php?c=dashboard#change-pass");
                exit;
            }

            // Kiểm tra mật khẩu mới trùng khớp
            if ($newPassword !== $confirmPassword) {
                $_SESSION['error'] = "Mật khẩu mới không trùng khớp";
                header("Location: index.php?c=dashboard#change-pass");
                exit;
            }

            // Hash mật khẩu mới và update
            $user->setPasswordHash(password_hash($newPassword, PASSWORD_DEFAULT));
            $userRepo->updatePassword($user);

            $_SESSION['success'] = "Đổi mật khẩu thành công";
            header("Location: index.php?c=dashboard#change-pass");
            exit;
        } else {
            header("Location: index.php?c=home");
            exit;
        }
    }
    public function profile()
    {
        if (empty($_SESSION['user_id'])) {
            header("Location: index.php");
        }
        $userId        = $_GET['id'];
        $userRepo      = new UserRepository();
        $user          = $userRepo->find($userId);
        $currentUserId = $_SESSION['user_id'];
        $currentUser   = $userRepo->find($currentUserId);
        require "view/profile/index.php";
    }
}
