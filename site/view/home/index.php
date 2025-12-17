<?php require "layout/header.php"; ?>

<body class="homepage">
    <div class="hero">

        <!-- <h1>Chào mừng đến với ứng dụng kết nối</h1> -->
        <h1>Mè Thái Huy thứ 4 ca 2</h1>
        <?php if (! empty($_SESSION["user_id"])) {?>
        <a href="?c=dashboard" class="btn btn-create">+ Kết nối ngay</a>
        <?php } else {?>
        <p>Tạo tài khoản để bắt đầu hành trình của bạn</p>

        <a href="?c=auth&a=profileSetup" class="btn btn-create">+ Tạo tài khoản</a>
        <a href="#" class="btn btn-create" data-toggle="modal" data-target="#loginModal">
            + Đăng nhập
        </a>
        <?php }?>

        <div class="profile-cards mt-5">
            <?php if (! empty($users)): ?>
            <?php foreach ($users as $user): ?>
            <div class="card">
                <img src="upload/<?php echo htmlspecialchars($user->getAvatarUrl()) ?>"
                    alt="<?php echo htmlspecialchars($user->getName()) ?>" />
                <h5>
                    <?php echo htmlspecialchars($user->getName()) ?>,
                    <?php echo date_diff(date_create($user->getBirthDate()), date_create('today'))->y ?>
                </h5>
                <p>Số followers:                                   <?php echo $user->getFollowerCount(); ?></p>
            </div>
            <?php endforeach; ?>
            <?php else: ?>
            <p class="text-muted">Chưa có người dùng nào.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Modal Đăng nhập -->
    <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="loginModalLabel" style="color: black">
                        Đăng nhập
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Đóng">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <?php
                        $showLoginModal      = false;
                        $showRegisterSuccess = false;

                        if (! empty($_SESSION['login_error'])):
                            $showLoginModal = true;
                        ?>
	                    <div class="alert alert-danger">
	                        <?php echo $_SESSION['login_error']; ?>
	                    </div>
	                    <?php endif;
                            if (! empty($_SESSION['register_success'])):
                                $showRegisterSuccess = true;
                            ?>
	                    <div class="alert alert-success text-center">
	                        <?php echo $_SESSION['register_success']; ?>
	                    </div>
	                    <?php
                            endif;
                        ?>
                    <form id="loginForm" method="POST" action="?c=auth&a=login">
                        <div class="form-group">
                            <label for="loginEmail">Email</label>
                            <input type="email" class="form-control" id="loginEmail" name="email"
                                placeholder="Nhập email" required />
                        </div>
                        <div class="form-group">
                            <label for="loginPassword">Mật khẩu</label>
                            <input type="password" class="form-control" id="loginPassword" name="password"
                                placeholder="Nhập mật khẩu" required />
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">
                            Đăng nhập
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>
<script>
<?php
    $shouldOpenLogin = false;
    if (! empty($showLoginModal) && $showLoginModal === true) {
        $shouldOpenLogin = true;
    }

    if (! empty($showRegisterSuccess) && $showRegisterSuccess === true) {
        $shouldOpenLogin = true;
    }
?>
<?php if ($shouldOpenLogin): ?>
$(document).ready(function() {
    $('#loginModal').modal('show');
});
<?php endif; ?>
</script>


<?php
    unset($_SESSION['login_error']);
    unset($_SESSION['register_success']);
?>

</html>