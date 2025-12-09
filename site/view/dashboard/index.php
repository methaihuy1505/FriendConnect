<?php require "layout/header.php"?>

<body class="dashboard">
    <div class="container-fluid">
        <div class="row">
            <div class="main-layout ">
                <!-- Sidebar -->
                <div class="col-md-3 sidebar">
                    <div class="text-center mb-3">
                        <img src="upload/<?php echo htmlspecialchars($currentUser->getAvatarUrl()) ?>" alt="Avatar"
                            class="avatar-img mb-2" />
                        <h4>Xin chào,                                       <?php echo htmlspecialchars($currentUser->getName()) ?></h4>
                        <p class="text-muted"><?php echo htmlspecialchars($currentUser->getEmail()) ?></p>
                    </div>
                    <hr />
                    <ul class="nav flex-column nav-pills" id="sidebarTabs">
                        <li class="nav-item">
                            <a class="nav-link                                               <?php echo empty($challenge) ? 'active' : ''; ?>" data-toggle="pill"
                                href="#explore">Khám phá</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="pill" href="#edit">Chỉnh sửa hồ sơ</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="pill" href="#following">Đang theo dõi</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="pill" href="#followers">Người theo dõi bạn</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="pill" href="#challenged">Đã thử thách</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link                                               <?php echo ! empty($challenge) ? 'active' : ''; ?>" data-toggle="pill"
                                href="#create">Thiết kế thử thách</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="pill" href="#my-challenges">Thử thách của tôi</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="?c=user&a=profile&id=<?php echo $currentUser->getId(); ?>">Hồ
                                sơ của tôi</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="?c=auth&a=logout">Đăng xuất</a>
                        </li>
                    </ul>
                </div>
                <!-- Main content -->
                <div class="col-md-9 p-4 content">
                    <div class="tab-content">
                        <!-- Explore tab -->
                        <?php require "layout/dashboard/tab_explore.php"?>
                        <!-- Edit profile tab -->
                        <?php require "layout/dashboard/tab_edit.php"?>
                        <!-- Following tab -->
                        <?php require "layout/dashboard/tab_following.php"?>
                        <!-- Followerstab -->
                        <?php require "layout/dashboard/tab_followers.php"?>
                        <!-- Challenged tab -->
                        <?php require "layout/dashboard/tab_challenged.php"?>
                        <!-- Create challenge tab -->
                        <?php require "layout/dashboard/tab_create.php"?>
                        <!-- My challenges tab -->
                        <?php require "layout/dashboard/tab_my_challenges.php"?>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
<script>

</script>

</html>