<div class="mb-3">
    <label for="<?php echo $prefix ?>Interests" class="form-label">Sở thích</label>
    <?php $userInterests = $user ? array_map(function ($i) {return $i->getId();}, $user->getInterests()) : [];
    ?>
    <select id="<?php echo $prefix ?>Interests" name="interests[]" class="form-select" multiple>
        <?php foreach ($interests as $interest): ?>
        <option value="<?php echo htmlspecialchars($interest->getId()) ?>"
            <?php echo in_array($interest->getId(), $userInterests) ? 'selected' : '' ?>>
            <?php echo htmlspecialchars($interest->getName()) ?>
        </option>
        <?php endforeach; ?>
    </select>
</div>