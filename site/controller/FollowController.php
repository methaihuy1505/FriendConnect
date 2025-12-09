<?php
class FollowController
{
    public function toggle()
    {
        $repo          = new FollowRepository();
        $userRepo      = new UserRepository();
        $currentUserId = $_SESSION['user_id'];
        $targetUserId  = $_POST['id'];
        $currentUser   = $userRepo->find($currentUserId);
        $targetUser    = $userRepo->find($targetUserId);

        if ($targetUser->isFollowedBy($currentUser)) {
            // Nếu đã theo dõi thì hủy
            $repo->unfollow($currentUserId, $targetUserId);
        } else {
            // Nếu chưa theo dõi thì thêm mới
            $repo->follow($currentUserId, $targetUserId);
        }

        header("Location: index.php?c=user&a=profile&id=" . $targetUserId);
        exit;
    }
}
