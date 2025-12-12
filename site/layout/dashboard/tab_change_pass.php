<div class="tab-pane fade" id="change-pass">
    <h3>Đổi mật khẩu</h3>
    <div class="profile-form profile-form-inner">
        <div class="container">

            <!-- Hiển thị thông báo lỗi/thành công -->
            <?php if (! empty($_SESSION['error'])): ?>
            <div class="alert alert-danger">
                <?php
                    echo htmlspecialchars($_SESSION['error']);
                    unset($_SESSION['error']); // clear sau khi hiển thị
                 ?>
            </div>
            <?php endif; ?>

            <?php if (! empty($_SESSION['success'])): ?>
            <div class="alert alert-success">
                <?php
                    echo htmlspecialchars($_SESSION['success']);
                    unset($_SESSION['success']); // clear sau khi hiển thị
                 ?>
            </div>
            <?php endif; ?>

            <form id="changePassForm" action="?c=user&a=updatePass" method="POST" class="mt-3">
                <div class="form-group">
                    <label for="currentPassword">Mật khẩu hiện tại</label>
                    <input type="password" class="form-control" id="currentPassword" name="currentPassword" required>
                </div>
                <div class="form-group">
                    <label for="newPassword">Mật khẩu mới</label>
                    <input type="password" class="form-control" id="newPassword" name="newPassword" required>
                </div>
                <div class="form-group">
                    <label for="confirmPassword">Xác nhận mật khẩu mới</label>
                    <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required>
                </div>
                <div id="errorMsg" class="text-danger mb-2" style="display:none;">
                    Mật khẩu xác nhận không trùng khớp!
                </div>
                <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('changePassForm').addEventListener('submit', function(e) {
    const newPass = document.getElementById('newPassword').value;
    const confirmPass = document.getElementById('confirmPassword').value;
    const errorMsg = document.getElementById('errorMsg');

    if (newPass !== confirmPass) {
        e.preventDefault(); // chặn submit
        errorMsg.style.display = 'block';
    } else {
        errorMsg.style.display = 'none';
    }
});
</script>