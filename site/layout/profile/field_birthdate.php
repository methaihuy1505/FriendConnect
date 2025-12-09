<div class="mb-3">
    <label class="form-label">Ngày sinh</label>
    <div class="d-flex gap-2">
        <?php
            $birthDate = $user ? $user->getBirthDate() : null;
            $monthSel  = $daySel  = $yearSel  = null;
            if ($birthDate) {
                [$yearSel, $monthSel, $daySel] = explode('-', $birthDate);
            }
        ?>

        <select class="form-select" name="birthMonth" required>
            <option value="">Tháng</option>
            <?php for ($m = 1; $m <= 12; $m++): ?>
            <?php $val = sprintf('%02d', $m); ?>
            <option value="<?php echo $val ?>"<?php echo($monthSel === $val) ? 'selected' : '' ?>>
                <?php echo $val ?>
            </option>
            <?php endfor; ?>
        </select>

        <select class="form-select" name="birthDay" required>
            <option value="">Ngày</option>
            <?php for ($d = 1; $d <= 31; $d++): ?>
            <?php $val = sprintf('%02d', $d); ?>
            <option value="<?php echo $val ?>"<?php echo($daySel === $val) ? 'selected' : '' ?>>
                <?php echo $val ?>
            </option>
            <?php endfor; ?>
        </select>

        <select class="form-select" name="birthYear" required>
            <option value="">Năm</option>
            <?php for ($y = date("Y"); $y >= 1900; $y--): ?>
            <option value="<?php echo $y ?>"<?php echo($yearSel == $y) ? 'selected' : '' ?>>
                <?php echo $y ?>
            </option>
            <?php endfor; ?>
        </select>
    </div>
</div>