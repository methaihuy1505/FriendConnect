<?php require "layout/header.php"; ?>

<body class="challenge_form">
    <div class="container mt-5 d-flex justify-content-center">
        <div class="card shadow-lg" style="max-width: 800px; width:100%;">
            <div class="card-body bg-light">
                <h3 class="card-title text-center mb-4 text-primary">
                    Kết quả thử thách:                                              <?php echo htmlspecialchars($challenge->getTitle()); ?>
                </h3>
                <p class="text-center fs-5">
                    Điểm: <strong><?php echo $lastResult['score']; ?></strong>
                </p>

                <?php foreach ($questions as $q): ?>
                <div class="question-box mb-3 p-3 rounded
                    <?php echo in_array($q->getId(), $lastResult['wrong'])
                        ? 'border border-danger bg-white'
                        : 'border border-success bg-white'; ?>">
                    <label class="form-label fw-bold">
                        <?php echo htmlspecialchars($q->getContent()); ?>
                    </label>
                    <?php foreach ($optionRepo->findByQuestion($q->getId()) as $opt): ?>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" disabled
                            <?php echo $opt->isCorrect() ? 'checked' : ''; ?>>
                        <label class="form-check-label">
                            <?php echo htmlspecialchars($opt->getContent()); ?>
                        </label>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endforeach; ?>

                <div class="mt-4 text-center">
                    <a href="index.php?c=dashboard#challenged" class="btn btn-primary">
                        ← Trở về trang đã thử thách
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>