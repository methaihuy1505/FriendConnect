<div class="mb-3">
    <label class="form-label">Quan tâm đến</label>
    <?php $interested = $user ? $user->getInterestedIn() : ''; ?>
    <select class="form-select" name="interested_in" required>
        <option value="man"                            <?php echo $interested === 'man' ? 'selected' : '' ?>>Nam</option>
        <option value="woman"                              <?php echo $interested === 'woman' ? 'selected' : '' ?>>Nữ</option>
        <option value="everyone"                                 <?php echo $interested === 'everyone' ? 'selected' : '' ?>>Mọi người</option>
    </select>
</div>