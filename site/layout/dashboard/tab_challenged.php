<div class="tab-pane fade" id="challenged">
    <h3>Đã thử thách</h3>
    <?php if (! empty($attempts)) {?>
    <p>Kết quả các thử thách bạn đã tham gia.</p>
    <div class="explore-section">

        <div class="slider-wrap">
            <button class="scroll-btn left-btn">⟨</button>
            <button class="scroll-btn right-btn">⟩</button>

            <div class="user-scroll">
                <?php foreach ($attempts as $attempt): ?>
                <?php $owner = $repo->findByChallengeId($attempt->getChallengeId()); ?>
                <div class="user-card">
                    <img src="upload/<?php echo htmlspecialchars($owner->getAvatarUrl() ?: 'default.png'); ?>"
                        alt="User" />
                    <h5 class="mt-2">
                        <?php echo htmlspecialchars($owner->getName()); ?>,
                        <?php echo date_diff(date_create($owner->getBirthDate()), date_create('today'))->y ?>
                    </h5>

                    <!-- Sở thích -->
                    <?php
                        $interests = $owner->getInterests();
                            $names     = array_map(function ($i) {return $i->getName();}, $interests);
                            $shown  = array_slice($names, 0, 3);
                            $hidden = array_slice($names, 3);
                        ?>
                    <div class="mb-2">Sở thích:
                        <?php foreach ($shown as $name): ?>
                        <span class="badge bg-secondary me-1"><?php echo $name; ?></span>
                        <?php endforeach; ?>
                        <?php if (! empty($hidden)): ?>
                        <span class="badge bg-light text-dark" data-bs-toggle="tooltip"
                            title="<?php echo implode(', ', $hidden); ?>">
                            +<?php echo count($hidden); ?> sở thích khác
                        </span>
                        <?php endif; ?>
                    </div>

                    <!-- Thông tin thử thách -->
                    <div class="challenge-info mb-2">
                        <span class="badge bg-success me-2">Điểm:                                                                     <?php echo $attempt->getScore(); ?></span>
                        <span class="badge bg-info">Số lần thử thách:                                                                             <?php echo $attempt->getAttemptCount(); ?></span>
                    </div>

                    <!-- Nút hành động -->
                    <div class="actions">
                        <form action="index.php?c=follow&a=toggle" method="POST" class="d-inline">
                            <input type="hidden" name="id" value="<?php echo $owner->getId(); ?>">
                            <button type="submit" class="btn btn-outline-primary btn-sm">
                                <?php echo $owner->isFollowedBy($currentUser) ? 'Hủy theo dõi' : 'Theo dõi'; ?>
                            </button>
                        </form>
                        <a href="index.php?c=challenge&user=<?php echo $owner->getId(); ?>"
                            class="btn btn-challenge btn-sm">Thử thách</a>
                        <a href="index.php?c=user&a=profile&id=<?php echo $owner->getId(); ?>"
                            class="btn btn-secondary btn-sm">Xem profile</a>
                    </div>
                </div>
                <?php endforeach; ?>

            </div>
        </div>
    </div>
    <?php } else {
            echo "<p>Bạn chưa tham gia thử thách nào</p>";
    }?>
</div>