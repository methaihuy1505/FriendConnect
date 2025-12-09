<?php require "layout/header.php"; ?>


<body class="challenge_form">
    <div class="container mt-3">
        <?php if (! empty($challenges)) {?>
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
        <!-- Form ds câu hỏi thử thách -->
        <div class="challenge-form d-none" id="challenge-<?php echo $c->getId(); ?>">
            <form method="POST" action="?c=challenge&a=submit">
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

                <div class="text-end mt-3">
                    <button type="submit" class="btn btn-success mb-3">Hoàn thành</button>
                    <button type="button" class="btn btn-secondary back-btn mb-3">Quay về</button>
                </div>
            </form>
        </div>
        <?php endforeach; ?>
        <?php } else {echo
                "<h3>Người này chưa tạo thử thách cho bản thân</h3>";}?>
    </div>

</body>