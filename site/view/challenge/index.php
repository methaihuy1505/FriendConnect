<?php require "layout/header.php"; ?>

<body class="challenge_form">
    <div class="container mt-3 ">
        <?php if (! empty($challenges)) {?>

        <?php if (empty($challengeId)): ?>
        <h3>Danh sách thử thách của<?php echo " " . $user->getName(); ?></h3>
        <?php foreach ($challenges as $c): ?>
        <?php $questionCount = count($questionRepo->findByChallenge($c->getId()));
            $participantCount            = count($challengeAttemptRepo->findByChallenge($c->getId())); ?>
        <div class="card mb-3">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="card-title"><?php echo htmlspecialchars($c->getTitle()); ?></h5>
                    <p class="card-text text-muted"><?php echo htmlspecialchars($c->getDescription()); ?></p>
                    <small>
                        Ngày tạo:                                     <?php echo $c->getCreatedAt(); ?> |
                        Số câu hỏi:                                         <?php echo $questionCount; ?> |
                        Số người tham gia:                                                <?php echo $participantCount; ?>
                    </small>
                </div>
                <div>
                    <button class="btn btn-primary btn-sm select-btn" data-id="<?php echo $c->getId(); ?>">
                        Chọn
                    </button>
                </div>
            </div>
        </div>
        <!-- Form ds câu hỏi thử thách (ẩn mặc định) -->
        <div class="challenge-form d-none" id="challenge-<?php echo $c->getId(); ?>">
            <form id="challengeForm-<?php echo $c->getId(); ?>" method="POST" action="?c=challenge&a=submit">
                <input type="hidden" name="challenge_id" value="<?php echo $c->getId(); ?>">
                <?php foreach ($questionRepo->findByChallenge($c->getId()) as $q): ?>
                <div class="question-box mb-3">
                    <label class="form-label fw-bold">
                        <?php echo htmlspecialchars($q->getContent()); ?>
                    </label>
                    <?php $options = $optionRepo->findByQuestion($q->getId()); ?>
                    <?php foreach ($options as $opt): ?>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="answers[<?php echo $q->getId(); ?>]"
                            value="<?php echo $opt->getId(); ?>">
                        <label class="form-check-label">
                            <?php echo htmlspecialchars($opt->getContent()); ?>
                        </label>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endforeach; ?>

                <div id="errorMsg-<?php echo $c->getId(); ?>" class="text-secondary mb-2" style="display:none;">
                    Vui lòng trả lời tất cả câu hỏi trước khi nộp!
                </div>

                <div class="text-end mt-3">
                    <button type="submit" class="btn btn-success mb-3">Hoàn thành</button>
                    <button type="button" class="btn btn-secondary back-btn mb-3">Quay về danh sách</button>
                </div>
            </form>
        </div>
        <?php endforeach; ?>

        <?php else: ?>
        <?php
            // chỉ hiển thị form của challenge có id trùng
                foreach ($challenges as $c) {
                    if ($c->getId() == $challengeId) {
                    ?>
        <h3>Thử thách:<?php echo htmlspecialchars($c->getTitle()); ?></h3>
        <div class="challenge-form" id="challenge-<?php echo $c->getId(); ?>">
            <form id="challengeForm-<?php echo $c->getId(); ?>" method="POST" action="?c=challenge&a=submit">
                <input type="hidden" name="challenge_id" value="<?php echo $c->getId(); ?>">
                <?php foreach ($questionRepo->findByChallenge($c->getId()) as $q): ?>
                <div class="question-box mb-3">
                    <label class="form-label fw-bold">
                        <?php echo htmlspecialchars($q->getContent()); ?>
                    </label>
                    <?php $options = $optionRepo->findByQuestion($q->getId()); ?>
                    <?php foreach ($options as $opt): ?>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="answers[<?php echo $q->getId(); ?>]"
                            value="<?php echo $opt->getId(); ?>">
                        <label class="form-check-label">
                            <?php echo htmlspecialchars($opt->getContent()); ?>
                        </label>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endforeach; ?>

                <div id="errorMsg-<?php echo $c->getId(); ?>" class="text-secondary mb-2" style="display:none;">
                    Vui lòng trả lời tất cả câu hỏi trước khi nộp!
                </div>

                <div class="text-end mt-3">
                    <button type="submit" class="btn btn-success mb-3">Hoàn thành</button>
                    <a href="index.php?c=challenge&user=<?php echo $user->getId(); ?>"
                        class="btn btn-secondary mb-3">Quay về danh sách</a>
                </div>
            </form>
        </div>
        <?php
            }
                }
            ?>
        <?php endif; ?>

        <?php } else {
                echo "<h3>Người này chưa tạo thử thách cho bản thân</h3>";
        }?>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('form[id^="challengeForm-"]').forEach(form => {
            const errorMsg = form.querySelector('[id^="errorMsg-"]');
            form.addEventListener('submit', function(e) {
                let allAnswered = true;
                const questionBoxes = form.querySelectorAll('.question-box');
                questionBoxes.forEach(box => {
                    const radios = box.querySelectorAll('input[type="radio"]');
                    const checked = Array.from(radios).some(r => r.checked);
                    if (!checked) {
                        allAnswered = false;
                    }
                });
                if (!allAnswered) {
                    e.preventDefault();
                    if (errorMsg) errorMsg.style.display = 'block';
                } else {
                    if (errorMsg) errorMsg.style.display = 'none';
                }
            });
        });
    });
    </script>
</body>