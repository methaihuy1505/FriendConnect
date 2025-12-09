<div class="mb-3">
    <label class="form-label">Tìm kiếm</label>
    <?php $intent = $user ? $user->getRelationshipIntent() : ''; ?>
    <select class="form-select" name="relationship_intent" required>
        <option value="friends"                                <?php echo $intent === 'friends' ? 'selected' : '' ?>>Bạn mới</option>
        <option value="serious"                                <?php echo $intent === 'serious' ? 'selected' : '' ?>>Mối quan hệ nghiêm túc</option>
        <option value="unsure"                               <?php echo $intent === 'unsure' ? 'selected' : '' ?>>Không xác định</option>
    </select>
</div>