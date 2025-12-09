<?php require "layout/header.php"?>

<body class="profile-form">
    <div class="container mt-5">
        <h2 class="mb-4">Chuẩn bị hồ sơ</h2>
        <form id="userRegistrationForm" action="?c=auth&a=register" method="POST" enctype="multipart/form-data">
            <!-- Tên -->
            <?php $prefix = '';
            $user                     = null; ?>
            <?php require "layout/profile/field_name.php"; ?>


            <!-- Email -->
            <?php require "layout/profile/field_email.php"; ?>


            <!-- Ngày sinh -->
            <?php require "layout/profile/field_birthdate.php"; ?>



            <!-- Giới tính -->
            <?php require "layout/profile/field_gender.php"; ?>


            <!-- Quan tâm đến -->
            <?php require "layout/profile/field_interested_in.php"; ?>


            <!-- Tìm kiếm -->
            <?php require "layout/profile/field_relationship_intent.php"; ?>


            <!-- Ảnh đại diện -->
            <?php require "layout/profile/field_avatar.php"; ?>


            <!-- Sở thích -->
            <?php require "layout/profile/field_interests.php"; ?>


            <!-- Xu hướng tính dục -->
            <?php require "layout/profile/field_orientation.php"; ?>


            <!-- Mật khẩu & Xác nhận mật khẩu-->
            <?php require "layout/profile/field_password.php"; ?>

            <!-- Khung hiển thị lỗi -->
            <div id="formErrors" class="text-danger mb-3"></div>
            <button type="submit" class="btn btn-primary">Tiếp tục</button>
        </form>

    </div>

</body>

</html>