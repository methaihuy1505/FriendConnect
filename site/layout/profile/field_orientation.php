<div class="mb-3">
    <label for="<?php echo $prefix ?>Orientation" class="form-label">Xu hướng tính dục</label>
    <?php $orientation = $user ? $user->getOrientation() : ''; ?>
    <select id="<?php echo $prefix ?>Orientation" name="orientation" class="form-select" required>
        <option value="straight"                                 <?php echo $orientation === 'straight' ? 'selected' : '' ?>>Straight</option>
        <option value="gay"                            <?php echo $orientation === 'gay' ? 'selected' : '' ?>>Gay</option>
        <option value="lesbian"                                <?php echo $orientation === 'lesbian' ? 'selected' : '' ?>>Lesbian</option>
        <option value="bisexual"                                 <?php echo $orientation === 'bisexual' ? 'selected' : '' ?>>Bisexual</option>
        <option value="other"                              <?php echo $orientation === 'other' ? 'selected' : '' ?>>Khác</option>
    </select>
</div>