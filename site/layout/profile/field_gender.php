<div class="mb-3">
    <label class="form-label">Giới tính</label>
    <?php $gender = $user ? $user->getGender() : ''; ?>
    <div class="form-check">
        <input class="form-check-input" type="radio" name="gender" id="<?php echo $prefix ?>Man" value="man"
            <?php echo $gender === 'man' ? 'checked' : '' ?> required />
        <label class="form-check-label" for="<?php echo $prefix ?>Man">Nam</label>
    </div>
    <div class="form-check">
        <input class="form-check-input" type="radio" name="gender" id="<?php echo $prefix ?>Woman" value="woman"
            <?php echo $gender === 'woman' ? 'checked' : '' ?> />
        <label class="form-check-label" for="<?php echo $prefix ?>Woman">Nữ</label>
    </div>
    <div class="form-check">
        <input class="form-check-input" type="radio" name="gender" id="<?php echo $prefix ?>Other" value="other"
            <?php echo $gender === 'other' ? 'checked' : '' ?> />
        <label class="form-check-label" for="<?php echo $prefix ?>Other">Khác</label>
    </div>
</div>