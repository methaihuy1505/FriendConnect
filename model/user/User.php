<?php
class User
{
    protected $id;
    protected $name;
    protected $email;
    protected $passwordHash;
    protected $birthDate;
    protected $gender;
    protected $orientation;
    protected $interestedIn;
    protected $relationshipIntent;
    protected $avatarUrl;
    protected $createdAt;

    public function __construct(
        $id,
        $name,
        $email,
        $passwordHash,
        $birthDate,
        $gender,
        $orientation,
        $interestedIn,
        $relationshipIntent,
        $avatarUrl,
        $createdAt
    ) {
        $this->id                 = $id;
        $this->name               = $name;
        $this->email              = $email;
        $this->passwordHash       = $passwordHash;
        $this->birthDate          = $birthDate;
        $this->gender             = $gender;
        $this->orientation        = $orientation;
        $this->interestedIn       = $interestedIn;
        $this->relationshipIntent = $relationshipIntent;
        $this->avatarUrl          = $avatarUrl;
        $this->createdAt          = $createdAt;
    }

    // Getter
    public function getId()
    {return $this->id;}
    public function getName()
    {return $this->name;}
    public function getEmail()
    {return $this->email;}
    public function getPasswordHash()
    {return $this->passwordHash;}
    public function getBirthDate()
    {return $this->birthDate;}
    public function getGender()
    {return $this->gender;}
    public function getOrientation()
    {return $this->orientation;}
    public function getInterestedIn()
    {return $this->interestedIn;}
    public function getRelationshipIntent()
    {return $this->relationshipIntent;}
    public function getAvatarUrl()
    {return $this->avatarUrl;}
    public function getCreatedAt()
    {return $this->createdAt;}

    // Setter
    public function setName($name)
    {$this->name = $name;return $this;}
    public function setEmail($email)
    {$this->email = $email;return $this;}
    public function setPasswordHash($passwordHash)
    {$this->passwordHash = $passwordHash;return $this;}
    public function setBirthDate($birthDate)
    {$this->birthDate = $birthDate;return $this;}
    public function setGender($gender)
    {$this->gender = $gender;return $this;}
    public function setOrientation($orientation)
    {$this->orientation = $orientation;return $this;}
    public function setInterestedIn($interestedIn)
    {$this->interestedIn = $interestedIn;return $this;}
    public function setRelationshipIntent($intent)
    {$this->relationshipIntent = $intent;return $this;}
    public function setAvatarUrl($avatarUrl)
    {$this->avatarUrl = $avatarUrl;return $this;}
    public function getInterests()
    {
        $repo = new InterestRepository();
        return $repo->findByUser($this->id);
    }
    public function isFollowedBy(User $otherUser): bool
    {
        $repo      = new FollowRepository();
        $followers = $repo->findFollowers($this->id);

        foreach ($followers as $follower) {
            if ($follower->getId() === $otherUser->getId()) {
                return true;
            }
        }
        return false;
    }
    // Lấy danh sách người mà user đang theo dõi
    public function getFollowing()
    {
        $repo = new FollowRepository();
        return $repo->findFollowing($this->id);
    }

    // Lấy danh sách follower của user
    public function getFollowers()
    {
        $repo = new FollowRepository();
        return $repo->findFollowers($this->id);
    }
    public function getFollowerCount()
    {
        $repo = new FollowRepository();
        return count($repo->findFollowers($this->id));
    }

    public function getFollowingCount()
    {
        $repo = new FollowRepository();
        return count($repo->findFollowing($this->id));
    }

    // Lấy danh sách challenge do user tạo
    public function getChallenges()
    {
        $repo = new ChallengeRepository();
        return $repo->findByCreator($this->id);
    }

    // Lấy danh sách attempt của user
    public function getChallengeAttempts()
    {
        $repo = new ChallengeAttemptRepository();
        return $repo->findByUser($this->id);
    }
}
