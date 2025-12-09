<div class="tab-pane fade" id="my-challenges">
    <h3>Thử thách của tôi</h3>
    <?php if (! empty($userChallenges)) {?>

    <p>Danh sách các thử thách bạn đã tạo.</p>
    <div class="challenge-list">
        <?php foreach ($userChallenges as $challenge): ?>
        <?php $questionCount = count($questionRepo->findByChallenge($challenge->getId()));
            $participantCount            = count($challengeAttemptRepo->findByChallenge($challenge->getId())); ?>
        <div class="card mb-3">
            <div class="card-body d-flex justify-content-between align-items-start">
                <div>
                    <h5 class="card-title">
                        <?php echo htmlspecialchars($challenge->getTitle()); ?>
                    </h5>
                    <p class="card-text">
                        <?php echo nl2br(htmlspecialchars($challenge->getDescription())); ?>
                    </p>
                    <small class="text-muted">
                        Tạo lúc:                                    <?php echo htmlspecialchars($challenge->getCreatedAt()); ?>
                    </small>
                    <div class="mt-2">
                        <span class="badge bg-info me-2">
                            Số câu hỏi:                                             <?php echo $questionCount ?>
                        </span>
                        <span class="badge bg-success">
                            Số người tham gia:                                                    <?php echo $participantCount ?>
                        </span>
                    </div>
                </div>

                <div class="btn-group d-flex flex-column justify-content-center" role="group">
                    <form method="POST" action="?c=dashboard" class="d-inline">
                        <input type="hidden" name="challenge_id" value="<?php echo $challenge->getId(); ?>">
                        <button type="submit" class="btn btn-md btn-warning m-2">Edit</button>
                    </form>

                    <form method="POST" action="?c=challenge&a=delete" class="m-0">
                        <input type="hidden" name="challenge_id" value="<?php echo $challenge->getId(); ?>">
                        <button type="submit" class="btn btn-md btn-danger m-2">Delete</button>
                    </form>
                </div>

            </div>
        </div>

        <?php endforeach; ?>
    </div>
    <?php } else {?>
    <p>Bạn chưa có thử thách nào.</p>
    <a href="#create" class="btn btn-primary nav-link" data-toggle="pill">Tạo ngay</a>
    <?php }?>
</div>