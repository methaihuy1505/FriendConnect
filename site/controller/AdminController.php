<?php

class AdminController
{
    public function index()
    {
        if ($_SESSION['role'] != 'admin') {
            header("location: index.php?c=dashboard");
            exit;
        }

        $userRepo      = new UserRepository();
        $challengeRepo = new ChallengeRepository();
        $followRepo    = new FollowRepository();

        // Lấy danh sách user
        $users      = $userRepo->getAll();
        $challenges = $userRepo->getAll();
                                               // Các biến thống kê
        $totalUsers      = count($users);      // tổng số user
        $totalChallenges = count($challenges); // tổng số thử thách

        require "view/admin/index.php";
    }

    public function editUser()
    {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $userRepo = new UserRepository();
            $editUser = $userRepo->find($id);
        }
        // load lại view admin với $users và $editUser
        $users = $userRepo->getAll();
        require "view/admin/index.php";
    }

    public function updateUser()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id    = $_POST['id'];
            $name  = $_POST['name'];
            $email = $_POST['email'];
            $role  = $_POST['role'];

            $userRepo = new UserRepository();
            $user     = $userRepo->find($id);
            $user->setName($name);
            $user->setEmail($email);
            $user->setRole($role);

            $userRepo->update($user);
            header("Location: index.php?c=admin");
            exit;
        }
    }
    public function deleteUser()
    {
        if (! empty($_GET['id'])) {
            $id = (int) $_GET['id'];

            $userRepo = new UserRepository();
            $user     = $userRepo->find($id);

            if ($user) {
                $userRepo->delete($id);
                $_SESSION['success'] = "Xóa user thành công";
            } else {
                $_SESSION['error'] = "User không tồn tại";
            }

            header("Location: index.php?c=admin");
            exit;
        } else {
            $_SESSION['error'] = "Thiếu ID user để xóa";
            header("Location: index.php?c=admin");
            exit;
        }
    }

}
