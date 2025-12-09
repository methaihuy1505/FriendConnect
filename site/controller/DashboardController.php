<?php
class DashboardController
{
    public function index()
    {
        if (empty($_SESSION['user_id'])) {
            header("Location: index.php");
        }
        $repo = new UserRepository();
        // Lấy danh sách interest truyền vào select
        $interestRepo         = new InterestRepository();
        $challengeAttemptRepo = new ChallengeAttemptRepository();
        $challengeRepo        = new ChallengeRepository();
        $questionRepo         = new QuestionRepository();
        $optionRepo           = new OptionRepository();

        //Lấy danh sách sở thích
        $interests = $interestRepo->getAll();
        // Lấy user hiện tại từ session
        $currentUserId = $_SESSION['user_id'] ?? null;
        $currentUser   = $currentUserId ? $repo->find($currentUserId) : null;
        // Phù hợp với bạn
        $matchedUsers = $repo->matchUser($currentUser);
        // Nhiều người theo dõi nhất
        $topFollowers = $repo->getTopUsersByFollowers();
        // Được thử thách nhiều nhất
        $topChallenged = $repo->getTopUsersByChallenges();
        // Lấy danh sách người mà currentUser đang theo dõi
        $followingUsers = $currentUser->getFollowing();
        // Lấy danh sách người đang theo dõi currentUser
        $followerUsers = $currentUser->getFollowers();
// Lấy toàn bộ danh sách người mà currentUser đã thhử thách
        $attempts = $challengeAttemptRepo->findByUser($currentUserId);
        //Lấy danh sách challenges của user
        $userChallenges = $currentUser->getChallenges();
        // Bộ lọc 
        $hasFilter   = ! empty($_GET['gender']) || ! empty($_GET['orientation']) || ! empty($_GET['ageRange']) || ! empty($_GET['interests']);
        $filterUsers = [];
        if ($hasFilter) {
            $conds = [];
            if (! empty($_GET['gender'])) {
                $conds['gender'] = ["type" => "=", "val" => $_GET['gender']];
            }
            if (! empty($_GET['orientation'])) {
                $conds['orientation'] = ["type" => "=", "val" => $_GET['orientation']];
            }
            if (! empty($_GET['ageRange'])) {
                if ($_GET['ageRange'] === "46+") {
                    $conds["TIMESTAMPDIFF(YEAR,birth_date,CURDATE())"] = ["type" => ">", "val" => 46];
                } else {
                    [$min, $max]                                       = explode("-", $_GET['ageRange']);
                    $conds["TIMESTAMPDIFF(YEAR,birth_date,CURDATE())"] = ["type" => "BETWEEN", "val" => "$min AND $max"];
                }
            }
            $filterUsers = $repo->getBy($conds, [], 1, 20);
        }
        // Nếu có lọc interests thì lọc thêm lần nữa
        if (! empty($_GET['interests'])) {
            $interestIds = array_filter($_GET['interests'], 'is_numeric');
            if (! empty($interestIds)) {
                $userIds = array_map(function ($u) {return $u->getId();}, $filterUsers);
                $matchedIds = $repo->filterByInterests($userIds, $interestIds);

                // Giữ lại những user có id nằm trong matchedIds
                $filterUsers = array_filter($filterUsers, function ($u) use ($matchedIds) {
                    return in_array($u->getId(), $matchedIds);
                });
            }
        }
        //Nếu có challenge_id thì chuyển sang tab create

        if (! empty($_POST['challenge_id'])) {
            $challenge_id = (int) $_POST['challenge_id'];
            $challenge    = $challengeRepo->find($challenge_id);
            $questions    = $questionRepo->findByChallenge($challenge_id);

        }

        require "view/dashboard/index.php";
    }
}
