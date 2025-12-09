<div class="mb-3">
    <label class="form-label">Ảnh đại diện</label>
    <?php if ($user && $user->getAvatarUrl()): ?>
    <img src="upload/<?php echo htmlspecialchars($user->getAvatarUrl()) ?>" alt="Avatar hiện tại" class="mt-2"
        style="max-width:100px;">
    <?php endif; ?>
    <input type="file" class="form-control" name="avatar_url" accept="image/*"<?php echo $user ? '' : 'required' ?> />

</div>