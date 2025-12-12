<div class="tab-pane fade<?php echo empty($challenge) ? 'show active' : ''; ?>" id="explore">
    <h3>Khám phá người dùng</h3>
    <div class="filter-wrapper mb-4">
        <button class="btn btn-outline-primary mb-2" type="button" data-toggle="collapse" data-target="#filterCollapse"
            aria-expanded="false" aria-controls="filterCollapse">
            Bộ lọc nâng cao
        </button>

        <div class="collapse" id="filterCollapse">
            <!-- Bộ lọc -->
            <form id="filterForm" method="GET" action="index.php" class="filter-box mb-4">
                <input type="hidden" name="c" value="dashboard">
                <div class="row gy-4 gx-3">

                    <!-- Tuổi -->
                    <div class="col-md-4">
                        <label class="form-label d-block">Tuổi</label>
                        <div class="btn-group flex-wrap w-100" role="group">
                            <?php $ages = ["18-25", "26-35", "36-45", "46+"];
                            $selectedAge                            = $_GET['ageRange'] ?? ''; ?>
                            <?php foreach ($ages as $age): ?>
                            <input type="radio" class="btn-check" name="ageRange" id="age-<?php echo $age ?>"
                                value="<?php echo $age ?>"<?php echo $selectedAge === $age ? 'checked' : '' ?>>
                            <label class="btn btn-outline-primary btn-sm"
                                for="age-<?php echo $age ?>"><?php echo $age ?></label>
                            <?php endforeach; ?>
                            <input type="radio" class="btn-check" name="ageRange" id="age-all" value=""
                                <?php echo $selectedAge === '' ? 'checked' : '' ?>>
                            <label class="btn btn-outline-secondary btn-sm" for="age-all">Tất
                                cả</label>
                        </div>
                    </div>

                    <!-- Giới tính -->
                    <div class="col-md-4">
                        <label class="form-label d-block">Giới tính</label>
                        <?php $genders = ["man" => "Nam", "woman" => "Nữ", "other" => "Khác"];
                        $selectedGender                        = $_GET['gender'] ?? ''; ?>
                        <div class="btn-group flex-wrap w-100" role="group">
                            <?php foreach ($genders as $key => $label): ?>
                            <input type="radio" class="btn-check" name="gender" id="gender-<?php echo $key ?>"
                                value="<?php echo $key ?>"<?php echo $selectedGender === $key ? 'checked' : '' ?>>
                            <label class="btn btn-outline-primary btn-sm"
                                for="gender-<?php echo $key ?>"><?php echo $label ?></label>
                            <?php endforeach; ?>
                            <input type="radio" class="btn-check" name="gender" id="gender-all" value=""
                                <?php echo $selectedGender === '' ? 'checked' : '' ?>>
                            <label class="btn btn-outline-secondary btn-sm" for="gender-all">Tất
                                cả</label>
                        </div>
                    </div>

                    <!-- Xu hướng tính dục -->
                    <div class="col-md-4">
                        <label class="form-label d-block">Xu hướng tính dục</label>
                        <?php
                            $orientations = [
                                "straight" => "Thẳng", "gay"      => "Gay", "lesbian" => "Lesbian",
                                "bisexual" => "Bisexual", "other" => "Khác",
                            ];
                            $selectedOrientation = $_GET['orientation'] ?? '';
                        ?>
                        <div class="btn-group flex-wrap w-100" role="group">
                            <?php foreach ($orientations as $key => $label): ?>
                            <input type="radio" class="btn-check" name="orientation" id="orientation-<?php echo $key ?>"
                                value="<?php echo $key ?>"<?php echo $selectedOrientation === $key ? 'checked' : '' ?>>
                            <label class="btn btn-outline-primary btn-sm"
                                for="orientation-<?php echo $key ?>"><?php echo $label ?></label>
                            <?php endforeach; ?>
                            <input type="radio" class="btn-check" name="orientation" id="orientation-all" value=""
                                <?php echo $selectedOrientation === '' ? 'checked' : '' ?>>
                            <label class="btn btn-outline-secondary btn-sm" for="orientation-all">Tất
                                cả</label>
                        </div>
                    </div>

                    <!-- Sở thích -->
                    <div class="col-12">
                        <label class="form-label d-block mb-2">Sở thích</label>
                        <div class="interest-tags d-flex flex-wrap gap-2">
                            <?php
                                $selectedInterests = $_GET['interests'] ?? [];
                                foreach ($interests as $interest):
                                    $id      = htmlspecialchars($interest->getId());
                                    $name    = htmlspecialchars($interest->getName());
                                    $checked = in_array($id, $selectedInterests);
                                ?>
	                            <input type="checkbox" class="btn-check" name="interests[]" id="interest-<?php echo $id ?>"
	                                value="<?php echo $id ?>"<?php echo $checked ? 'checked' : '' ?>>
	                            <label class="btn btn-outline-secondary btn-sm"
	                                for="interest-<?php echo $id ?>"><?php echo $name ?></label>
	                            <?php endforeach; ?>
                        </div>
                    </div>


                    <!-- Nút -->
                    <div class="col-12 text-end mt-3">
                        <button type="submit" class="btn btn-primary">Lọc</button>
                        <button type="reset" class="btn btn-outline-secondary">Xóa lọc</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- Section: Kết quả lọc -->
    <?php if (! empty($filterUsers)) {?>
    <div class="explore-section mb-4">
        <h4>🔎 Kết quả lọc</h4>
        <div class="slider-wrap">
            <button class="scroll-btn left-btn">⟨</button>
            <button class="scroll-btn right-btn">⟩</button>
            <div class="user-scroll">
                <?php foreach ($filterUsers as $user): ?>
                <div class="user-card">
                    <img src="upload/<?php echo htmlspecialchars($user->getAvatarUrl()) ?>" alt="User" />
                    <h5 class="mt-2">
                        <?php echo htmlspecialchars($user->getName()) ?>,
                        <?php echo date_diff(date_create($user->getBirthDate()), date_create('today'))->y ?>
                    </h5>
                    <?php
                        $userInterest = $user->getInterests();
                            $names        = array_map(function ($i) {return $i->getName();}, $userInterest);
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
                        <form action="?c=follow&a=toggle" method="POST" class="d-inline">
                            <input type="hidden" name="id" value="<?php echo $user->getId(); ?>">
                            <button type="submit" class="btn btn-outline-primary btn-sm">
                                <?php echo $user->isFollowedBy($currentUser) ? 'Hủy theo dõi' : 'Theo dõi'; ?>
                            </button>
                        </form>
                        <a href="?c=challenge&user=<?php echo $user->getId(); ?>" class="btn btn-challenge btn-sm">Thử
                            thách</a>
                        <a href="?c=user&a=profile&id=<?php echo $user->getId(); ?>"
                            class="btn btn-secondary btn-sm">Xem profile</a>
                    </div>
                </div>
                <?php endforeach; ?>

            </div>
        </div>
    </div>
    <?php } else {if ($hasFilter) {echo "<h4>🔎 Không tìm thấy người phù hợp</h4>";} else {?>
    <!-- Section: Phù hợp với bạn -->
    <?php if (! empty($matchedUsers)): ?>
    <div class="explore-section mb-4">
        <h4>✨ Phù hợp với bạn</h4>

        <div class="slider-wrap">
            <button class="scroll-btn left-btn">⟨</button>
            <button class="scroll-btn right-btn">⟩</button>

            <div class="user-scroll">
                <?php foreach ($matchedUsers as $user): ?>
                <div class="user-card">
                    <img src="upload/<?php echo htmlspecialchars($user->getAvatarUrl()) ?>" alt="User" />
                    <h5 class="mt-2">
                        <?php echo htmlspecialchars($user->getName()) ?>,
                        <?php echo date_diff(date_create($user->getBirthDate()), date_create('today'))->y ?>
                    </h5>
                    <?php
                        $userInterest = $user->getInterests();
                            $names        = array_map(function ($i) {return $i->getName();}, $userInterest);
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
                        <form action="?c=follow&a=toggle" method="POST" class="d-inline">
                            <input type="hidden" name="id" value="<?php echo $user->getId(); ?>">
                            <button type="submit" class="btn btn-outline-primary btn-sm">
                                <?php echo $user->isFollowedBy($currentUser) ? 'Hủy theo dõi' : 'Theo dõi'; ?>
                            </button>
                        </form>
                        <a href="?c=challenge&user=<?php echo $user->getId(); ?>" class="btn btn-challenge btn-sm">Thử
                            thách</a>
                        <a href="?c=user&a=profile&id=<?php echo $user->getId(); ?>"
                            class="btn btn-secondary btn-sm">Xem profile</a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <?php endif; ?>
    <!-- Section: Nhiều người theo dõi nhất -->
    <div class="explore-section mb-4">
        <h4>👥 Nhiều người theo dõi nhất</h4>
        <div class="slider-wrap">
            <button class="scroll-btn left-btn">⟨</button>
            <button class="scroll-btn right-btn">⟩</button>
            <div class="user-scroll">
                <?php foreach ($topFollowers as $user): ?>
                <div class="user-card">
                    <img src="upload/<?php echo htmlspecialchars($user->getAvatarUrl()) ?>" alt="User" />
                    <h5 class="mt-2">
                        <?php echo htmlspecialchars($user->getName()) ?>,
                        <?php echo date_diff(date_create($user->getBirthDate()), date_create('today'))->y ?>
                    </h5>
                    <?php
                        $userInterest = $user->getInterests();
                            $names        = array_map(function ($i) {return $i->getName();}, $userInterest);
                            $max    = 3;
                            $shown  = array_slice($names, 0, $max);
                            $hidden = array_slice($names, $max);
                        ?>
                    <?php
                        $userInterest = $user->getInterests();
                            $names        = array_map(function ($i) {return $i->getName();}, $userInterest);
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
                    <p>Số followers:                                       <?php echo $user->getFollowerCount(); ?></p>
                    <div class="actions">
                        <form action="?c=follow&a=toggle" method="POST" class="d-inline">
                            <input type="hidden" name="id" value="<?php echo $user->getId(); ?>">
                            <button type="submit" class="btn btn-outline-primary btn-sm">
                                <?php echo $user->isFollowedBy($currentUser) ? 'Hủy theo dõi' : 'Theo dõi'; ?>
                            </button>
                        </form>
                        <a href="?c=challenge&user=<?php echo $user->getId(); ?>" class="btn btn-challenge btn-sm">Thử
                            thách</a>
                        <a href="?c=user&a=profile&id=<?php echo $user->getId(); ?>"
                            class="btn btn-secondary btn-sm">Xem profile</a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <!-- Section: Được thử thách nhiều nhất -->
    <div class="explore-section mb-4">
        <h4>🔥 Được thử thách nhiều nhất</h4>
        <div class="slider-wrap">
            <button class="scroll-btn left-btn">⟨</button>
            <button class="scroll-btn right-btn">⟩</button>

            <div class="user-scroll">
                <?php foreach ($topChallenged as $item): ?>
                <?php $user = $item['user']; ?>
                <div class="user-card">
                    <img src="upload/<?php echo htmlspecialchars($user->getAvatarUrl()) ?>" alt="User" />
                    <h5 class="mt-2">
                        <?php echo htmlspecialchars($user->getName()) ?>,
                        <?php echo date_diff(date_create($user->getBirthDate()), date_create('today'))->y ?>
                    </h5>

                    <p class="fw-bold">Challenge:                                                  <?php echo htmlspecialchars($item['challenge_title']); ?></p>
                    <p>Số lần người khác đã thử thách:                                                                    <?php echo $item['total_attempts']; ?></p>

                    <div class="actions">
                        <form action="?c=follow&a=toggle" method="POST" class="d-inline">
                            <input type="hidden" name="id" value="<?php echo $user->getId(); ?>">
                            <button type="submit" class="btn btn-outline-primary btn-sm">
                                <?php echo $user->isFollowedBy($currentUser) ? 'Hủy theo dõi' : 'Theo dõi'; ?>
                            </button>
                        </form>
                        <!-- Nút thử thách đi thẳng tới challenge cụ thể -->
                        <a href="?c=challenge&user=<?php echo $user->getId(); ?>&id=<?php echo $item['challenge_id']; ?>"
                            class="btn btn-challenge btn-sm">Thử thách</a>
                        <a href="?c=user&a=profile&id=<?php echo $user->getId(); ?>"
                            class="btn btn-secondary btn-sm">Xem profile</a>
                    </div>
                </div>
                <?php endforeach; ?>

            </div>
        </div>
    </div>
    <?php }}?>
</div>