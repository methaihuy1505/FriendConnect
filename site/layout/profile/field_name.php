<div class="mb-3">
    <label for="<?php echo $prefix?>Name" class="form-label">Tên</label>
    <input type="text" class="form-control" id="<?php echo $prefix?>Name" name="name"
        value="<?php echo htmlspecialchars($user ? $user->getName() : '')?>" required />
</div>