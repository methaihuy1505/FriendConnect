<div class="mb-3">
    <label for="<?php echo $prefix?>Email" class="form-label">Email</label>
    <input type="email" class="form-control" id="<?php echo $prefix?>Email" name="email"
        value="<?php echo htmlspecialchars($user ? $user->getEmail() : '')?>" required />
</div>