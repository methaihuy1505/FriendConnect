<div class="tab-pane fade" id="followers">
    <h3>Người theo dõi bạn</h3>

    <?php if (! empty($followerUsers)) {?>
    <p>Danh sách người đang theo dõi bạn.</p>
    <div class="explore-section">
        <div class="slider-wrap">
            <button class="scroll-btn left-btn">⟨</button>
            <button class="scroll-btn right-btn">⟩</button>

            <div class="user-scroll">
                <?php foreach ($followerUsers as $user): ?>
                <div class="user-card">
                    <img src="upload/<?php echo htmlspecialchars($user->getAvatarUrl() ?: 'default.png'); ?>"
                        alt="User" />
                    <h5 class="mt-2">
                        <?php echo htmlspecialchars($user->getName()); ?>,
                        <?php echo date_diff(date_create($user->getBirthDate()), date_create('today'))->y ?>
                    </h5>
                    <?php
                        $interests = $user->getInterests();
                            $names     = array_map(function ($i) {return $i->getName();}, $interests);
                            $max    = 3;
                            $shown  = array_slice($names, 0, $max);
                            $hidden = array_slice($names, $max);
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
                    <div class="actions">
                        <form action="index.php?c=follow&a=toggle" method="POST" class="d-inline">
                            <input type="hidden" name="id" value="<?php echo $user->getId(); ?>">
                            <button type="submit" class="btn btn-outline-primary btn-sm">
                                <?php echo $user->isFollowedBy($currentUser) ? 'Hủy theo dõi' : 'Theo dõi lại'; ?>
                            </button>
                        </form>
                        <a href="index.php?c=challenge&user=<?php echo $user->getId(); ?>"
                            class="btn btn-challenge btn-sm">Thử thách</a>
                        <a href="index.php?c=user&a=profile&id=<?php echo $user->getId(); ?>"
                            class="btn btn-secondary btn-sm">Xem profile</a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <?php } else {
            echo
                "<p>Không có ai đang theo dõi bạn</p>";
    }?>
</div>