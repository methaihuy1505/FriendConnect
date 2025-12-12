<?php

class ChallengeController
{
    public function index()
    {
        if (empty($_SESSION['user_id'])) {
            header("Location: index.php");
            exit;
        }

        $challengeRepo        = new ChallengeRepository();
        $questionRepo         = new QuestionRepository();
        $challengeAttemptRepo = new ChallengeAttemptRepository();
        $optionRepo           = new OptionRepository();
        $userRepo             = new UserRepository();

        $userId      = $_GET['user'] ?? null;
        $challengeId = $_GET['id'] ?? null;

        $user       = $userRepo->find($userId);
        $challenges = $challengeRepo->findByCreator($userId);

        require "view/challenge/index.php";
    }

    public function submit()
    {

        if (empty($_POST['answers']) || empty($_POST['challenge_id'])) {
            header("Location: index.php?c=dashboard");
            exit;
        }

        $answers     = $_POST['answers'];
        $userId      = $_SESSION['user_id'];
        $challengeId = (int) $_POST['challenge_id'];

        $optionRepo  = new OptionRepository();
        $attemptRepo = new ChallengeAttemptRepository();

        // Tính điểm
        $score        = 0;
        $wrongAnswers = [];
        foreach ($answers as $questionId => $optionIndex) {
            $correctOption = $optionRepo->findCorrectByQuestion($questionId);
            if (! $correctOption || $correctOption->getId() != $optionIndex) {
                $wrongAnswers[] = $questionId;
            } else {
                $score++;
            }
        }
        // check attempt cũ
        $lastAttempt = $attemptRepo->findLastAttempt($challengeId, $userId);

        if ($lastAttempt) {
            $lastAttempt->setScore($score);
            $lastAttempt->setAttemptCount($lastAttempt->getAttemptCount() + 1);
            $attemptRepo->update($lastAttempt);
            $attemptId = $lastAttempt->getId();
        } else {
            $attemptId = $attemptRepo->save(
                new ChallengeAttempt(null, $challengeId, $userId, $score, 1, null)
            );
        }

        $_SESSION['last_result'] = [
            'challenge_id' => $challengeId,
            'score'        => $score,
            'wrong'        => $wrongAnswers,
        ];

        header("Location: index.php?c=challenge&a=result&id=" . $challengeId);
        exit;
    }
    public function result()
    {
        $questionRepo  = new QuestionRepository();
        $optionRepo    = new OptionRepository();
        $challengeRepo = new ChallengeRepository();

        $challengeId = (int) ($_GET['id'] ?? 0);
        $challenge   = $challengeRepo->find($challengeId);
        $questions   = $questionRepo->findByChallenge($challengeId);

        $lastResult = $_SESSION['last_result'] ?? null;

        require "view/challenge/result.php";
    }

    public function save()
    {
        $challengeRepo = new ChallengeRepository();
        $questionRepo  = new QuestionRepository();
        $optionRepo    = new OptionRepository();

        $creatorId   = $_SESSION['user_id'];
        $title       = $_POST['title'];
        $description = $_POST['description'];

        if (! empty($_POST['challenge_id'])) {
            // Update challenge
            $challengeId = (int) $_POST['challenge_id'];
            $challengeRepo->update(
                new Challenge($challengeId, $creatorId, $title, $description, null)
            );
        } else {
            // Create challenge
            $challengeId = $challengeRepo->save(
                new Challenge(null, $creatorId, $title, $description, null)
            );
        }

        // Lấy danh sách question cũ 
        $oldQuestions   = $questionRepo->findByChallenge($challengeId);
        $oldQuestionIds = array_map(function ($q) {return $q->getId();}, $oldQuestions);

        $newQuestionIds = [];

        foreach ($_POST['questions'] as $qId => $qData) {
            // Nếu có question_id thì update, nếu không thì insert mới
            if (! empty($qData['id'])) {
                $questionId = (int) $qData['id'];
                $questionRepo->update(
                    new Question($questionId, $challengeId, $qData['content'])
                );
            } else {
                $questionId = $questionRepo->save(
                    new Question(null, $challengeId, $qData['content'])
                );
            }
            $newQuestionIds[] = $questionId;

            // Xử lý options
            $oldOptions   = $optionRepo->findByQuestion($questionId);
            $oldOptionIds = array_map(function ($o) {return $o->getId();}, $oldOptions);
            $newOptionIds = [];

            $correctIndex = (int) $qData['answer'];

            foreach ($qData['options'] as $idx => $optData) {
                $isCorrect = ($idx == $correctIndex) ? 1 : 0;

                if (! empty($optData['id'])) {
                    $optionId = (int) $optData['id'];
                    $optionRepo->update(
                        new Option($optionId, $questionId, $optData['content'], $isCorrect)
                    );
                } else {
                    $optionId = $optionRepo->save(
                        new Option(null, $questionId, $optData['content'], $isCorrect)
                    );
                }
                $newOptionIds[] = $optionId;
            }

            // Xóa option cũ không còn trong form
            foreach ($oldOptionIds as $oldId) {
                if (! in_array($oldId, $newOptionIds)) {
                    $optionRepo->delete($oldId);
                }
            }
        }

        // Xóa question cũ không còn trong form
        foreach ($oldQuestionIds as $oldId) {
            if (! in_array($oldId, $newQuestionIds)) {
                $questionRepo->delete($oldId);
                $optionRepo->deleteByQuestion($oldId);
            }
        }

        header("Location: index.php?c=dashboard#my-challenges");
        exit;
    }
    public function delete()
    {
        $challengeRepo = new ChallengeRepository();
        $questionRepo  = new QuestionRepository();
        $optionRepo    = new OptionRepository();

        if (empty($_POST['challenge_id'])) {
            header("Location: index.php?c=dashboard#mychallenge");
            exit;
        }

        $challengeId = (int) $_POST['challenge_id'];

        // Xóa tất cả option thuộc challenge
        $optionRepo->deleteByChallenge($challengeId);

        // Xóa tất cả question thuộc challenge
        $questionRepo->deleteByChallenge($challengeId);

        // Xóa challenge
        $challengeRepo->delete($challengeId);

        header("Location: index.php?c=dashboard#my-challenges");
        exit;
    }

}
