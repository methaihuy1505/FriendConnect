<?php require "layout/header.php"; ?>

<body class="admin-page">
    <div class="container-fluid p-4">
        <h3>Trang quản trị</h3>
        <hr>

        <!-- Thông báo từ server -->
        <?php if (! empty($_SESSION['error'])): ?>
        <div class="alert alert-danger">
            <?php echo htmlspecialchars($_SESSION['error']);unset($_SESSION['error']); ?>
        </div>
        <?php endif; ?>
        <?php if (! empty($_SESSION['success'])): ?>
        <div class="alert alert-success">
            <?php echo htmlspecialchars($_SESSION['success']);unset($_SESSION['success']); ?>
        </div>
        <?php endif; ?>

        <!-- Nút ngang -->
        <ul class="nav nav-tabs mb-3" id="adminTabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="users-tab" data-toggle="tab" href="#users" role="tab">Quản lý tài
                    khoản</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="stats-tab" data-toggle="tab" href="#stats" role="tab">Thống kê</a>
            </li>
        </ul>

        <!-- Nội dung tab -->
        <div class="tab-content" id="adminTabsContent">
            <!-- Quản lý tài khoản -->
            <div class="tab-pane fade show active" id="users" role="tabpanel">
                <?php if (! empty($editUser)) {?>
                <h4>Chỉnh sửa User</h4>
                <form action="?c=admin&a=updateUser" method="POST">
                    <input type="hidden" name="id" value="<?php echo $editUser->getId(); ?>">
                    <div class="form-group">
                        <label for="name">Tên</label>
                        <input type="text" class="form-control" id="name" name="name"
                            value="<?php echo htmlspecialchars($editUser->getName()); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email"
                            value="<?php echo htmlspecialchars($editUser->getEmail()); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="role">Role</label>
                        <select class="form-control" id="role" name="role">
                            <option value="user"                                                 <?php echo $editUser->getRole() === 'user' ? 'selected' : ''; ?>>User
                            </option>
                            <option value="admin"                                                  <?php echo $editUser->getRole() === 'admin' ? 'selected' : ''; ?>>
                                Admin</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success">Lưu thay đổi</button>
                </form>
                <?php } else {?>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tên</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Ngày tạo</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $u): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($u->getId()); ?></td>
                            <td><?php echo htmlspecialchars($u->getName()); ?></td>
                            <td><?php echo htmlspecialchars($u->getEmail()); ?></td>
                            <td><?php echo htmlspecialchars($u->getRole()); ?></td>
                            <td><?php echo htmlspecialchars($u->getCreatedAt()); ?></td>
                            <td>
                                <a href="?c=admin&a=editUser&id=<?php echo $u->getId(); ?>"
                                    class="btn btn-sm btn-warning">Sửa</a>
                                <a href="?c=admin&a=deleteUser&id=<?php echo $u->getId(); ?>"
                                    class="btn btn-sm btn-danger"
                                    onclick="return confirm('Bạn có chắc muốn xóa user này?');">Xóa</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php }?>
            </div>

            <!-- Thống kê -->
            <div class="tab-pane fade" id="stats" role="tabpanel">
                <h4>Thống kê hệ thống</h4>
                <div class="row">
                    <div class="col-md-4">
                        <div class="card text-center">
                            <div class="card-body">
                                <h5 class="card-title">Tổng số User</h5>
                                <p class="card-text display-4"><?php echo $totalUsers; ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-center">
                            <div class="card-body">
                                <h5 class="card-title">Tổng số Thử thách</h5>
                                <p class="card-text display-4"><?php echo $totalChallenges; ?></p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</body>

</html>