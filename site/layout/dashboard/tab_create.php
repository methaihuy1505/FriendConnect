<div class="tab-pane fade<?php echo ! empty($challenge) ? 'show active' : ''; ?>" id="create">
    <h3>Thiết kế thử thách</h3>
    <p class="text-muted">
        Tại đây bạn có thể soạn danh sách câu hỏi và đáp án để thử thách người khác.
    </p>

    <form id="challengeForm" class="mt-3" method="POST" action="?c=challenge&a=save">
        <!-- Hidden ID để biết đang edit hay create -->
        <input type="hidden" id="challengeId" name="challenge_id"
            value="<?php echo ! empty($challenge) ? $challenge->getId() : ''; ?>">

        <!-- Tiêu đề thử thách -->
        <div class="mb-3">
            <label for="challengeTitle" class="form-label">Tiêu đề thử thách</label>
            <input type="text" class="form-control" id="challengeTitle" name="title" placeholder="Nhập tiêu đề" required
                value="<?php echo ! empty($challenge) ? htmlspecialchars($challenge->getTitle()) : ''; ?>">
        </div>

        <!-- Mô tả thử thách -->
        <div class="mb-3">
            <label for="challengeDescription" class="form-label">Mô tả</label>
            <textarea class="form-control" id="challengeDescription" name="description" rows="3"
                placeholder="Giới thiệu ngắn gọn về thử thách" required><?php
                                                                                     echo ! empty($challenge) ? htmlspecialchars($challenge->getDescription()) : '';
                                                                                     ?></textarea>
        </div>

        <!-- Template câu hỏi -->
        <template id="questionTemplate">
            <div class="card mb-3 question-card">
                <div class="card-body">
                    <h5 class="card-title">Câu hỏi <span class="q-index"></span></h5>
                    <div class="mb-2">
                        <label class="form-label">Nội dung câu hỏi</label>
                        <input type="text" class="form-control question-content" required />
                    </div>

                    <!-- Các lựa chọn -->
                    <div class="mb-2">
                        <label class="form-label">Các lựa chọn</label>
                        <div class="row g-2">
                            <div class="col-md-6">
                                <input type="text" class="form-control option-content" data-option="1"
                                    placeholder="Lựa chọn A" required />
                            </div>
                            <div class="col-md-6">
                                <input type="text" class="form-control option-content" data-option="2"
                                    placeholder="Lựa chọn B" required />
                            </div>
                            <div class="col-md-6 mt-2">
                                <input type="text" class="form-control option-content" data-option="3"
                                    placeholder="Lựa chọn C" />
                            </div>
                            <div class="col-md-6 mt-2">
                                <input type="text" class="form-control option-content" data-option="4"
                                    placeholder="Lựa chọn D" />
                            </div>
                        </div>
                    </div>

                    <!-- Đáp án đúng -->
                    <div class="mb-2">
                        <label class="form-label">Đáp án đúng</label>
                        <select class="form-select answer-select w-100" required>
                            <option value="">Chọn đáp án</option>
                            <option value="1">A</option>
                            <option value="2">B</option>
                            <option value="3">C</option>
                            <option value="4">D</option>
                        </select>
                    </div>

                    <button type="button" class="btn btn-sm btn-danger mt-2 remove-btn">Xóa câu hỏi</button>
                </div>
            </div>
        </template>

        <!-- Danh sách câu hỏi -->
        <div id="questionList">
            <?php if (! empty($questions)): ?>
            <?php $i = 1; ?>

            <?php foreach ($questions as $q): ?>
            <div class="card mb-3 question-card">
                <div class="card-body">
                    <h5 class="card-title">Câu hỏi <span class="q-index"><?php echo $i++ ?></span></h5>
                    <div class="mb-2">
                        <label class="form-label">Nội dung câu hỏi</label>
                        <input type="text" class="form-control question-content"
                            name="questions[<?php echo $q->getId(); ?>][content]"
                            value="<?php echo htmlspecialchars($q->getContent()); ?>" />
                    </div>
                    <?php $options = $optionRepo->findByQuestion($q->getId()); ?>
                    <div class="mb-2">
                        <label class="form-label">Các lựa chọn</label>
                        <div class="row g-2">
                            <?php foreach ($options as $idx => $opt): ?>
                            <div class="col-md-6 mt-2">
                                <input type="text" class="form-control option-content"
                                    name="questions[<?php echo $q->getId(); ?>][options][<?php echo $idx + 1; ?>][content]"
                                    value="<?php echo htmlspecialchars($opt->getContent()); ?>" />
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>


                    <!-- Đáp án đúng -->
                    <div class="mb-2">
                        <label class="form-label">Đáp án đúng</label>
                        <select class="form-select answer-select w-100"
                            name="questions[<?php echo $q->getId(); ?>][answer]">
                            <?php foreach ($options as $idx => $opt): ?>
                            <option value="<?php echo $idx + 1; ?>"<?php if ($opt->isCorrect()) {
        echo 'selected';
}
?>>
                                <?php echo htmlspecialchars($opt->getContent()); ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="button" class="btn btn-sm btn-danger mt-2 remove-btn">Xóa câu hỏi</button>
                </div>
            </div>
            <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <button type="button" class="btn btn-outline-primary mb-3" id="addQuestionBtn">
            + Thêm câu hỏi
        </button>

        <div class="text-end">
            <button type="submit" class="btn btn-primary">Lưu thử thách</button>
        </div>
    </form>
</div>