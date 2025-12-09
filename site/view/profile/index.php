<?php require "layout/header.php"?>

<body class="profile-page position-relative">
    <a href="index.php?c=dashboard&a=index" class="btn btn-secondary position-absolute" style="top: 5px; left: 5px;">
        ⬅ Quay về Dashboard
    </a>
    <div class="container mt-5 ">

        <div class="card shadow-lg p-4">
            <div class="row">
                <!-- Avatar -->
                <div class="col-md-4 text-center">
                    <img src="upload/<?php echo htmlspecialchars($user->getAvatarUrl() ?: 'default.png'); ?>"
                        alt="Avatar" class="rounded-circle mb-3"
                        style="width: 200px; height: 200px; object-fit: cover" />
                    <h3><?php echo htmlspecialchars($user->getName()); ?></h3>
                    <p>Tuổi:                               <?php echo date_diff(date_create($user->getBirthDate()), date_create('today'))->y; ?></p>
                    <div class="d-flex justify-content-center gap-2 mt-3">
                        <?php if ($user->getId() === $_SESSION['user_id']): ?>
                        <span class="badge bg-secondary">
                            <?php echo $user->getFollowerCount(); ?> Followers
                        </span>
                        <?php else: ?>
                        <form action="index.php?c=follow&a=toggle" method="POST">
                            <input type="hidden" name="id" value="<?php echo $user->getId(); ?>">
                            <button type="submit" class="btn btn-outline-primary">
                                <?php echo $user->isFollowedBy($currentUser) ? 'Hủy theo dõi' : 'Theo dõi'; ?>
                            </button>
                        </form>
                        <a href="index.php?c=challenge&user=<?php echo $user->getId(); ?>" class="btn btn-challenge">Thử
                            thách</a>
                        <?php endif; ?>
                    </div>

                </div>

                <!-- Thông tin chi tiết -->
                <div class="col-md-8">
                    <h4>Thông tin cá nhân</h4>
                    <ul class="list-group mb-3">
                        <li class="list-group-item">
                            <strong>Email:</strong>                                                    <?php echo htmlspecialchars($user->getEmail()); ?>
                        </li>
                        <li class="list-group-item">
                            <strong>Giới tính:</strong>                                                           <?php echo htmlspecialchars($user->getGender()); ?>
                        </li>
                        <li class="list-group-item">
                            <strong>Xu hướng tính dục:</strong>                                                                      <?php echo htmlspecialchars($user->getOrientation()); ?>
                        </li>
                        <li class="list-group-item">
                            <strong>Quan tâm đến:</strong>                                                               <?php echo htmlspecialchars($user->getInterestedIn()); ?>
                        </li>
                        <li class="list-group-item">
                            <strong>Tìm kiếm:</strong>                                                          <?php echo htmlspecialchars($user->getRelationshipIntent()); ?>
                        </li>
                    </ul>

                    <h4>Sở thích</h4>
                    <div class="d-flex flex-wrap gap-2">
                        <?php foreach ($user->getInterests() as $interest): ?>
                        <span class="badge bg-secondary"><?php echo htmlspecialchars($interest->getName()); ?></span>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>