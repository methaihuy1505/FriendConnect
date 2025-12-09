<?php
class ChallengeAttempt
{
    protected $id;
    protected $challengeId;
    protected $userId;
    protected $score;
    protected $attemptCount;
    protected $createdAt;

    public function __construct($id, $challengeId, $userId, $score, $attemptCount, $createdAt)
    {
        $this->id           = $id;
        $this->challengeId  = $challengeId;
        $this->userId       = $userId;
        $this->score        = $score;
        $this->attemptCount = $attemptCount;
        $this->createdAt    = $createdAt;
    }

    // Getter
    public function getId()
    {return $this->id;}
    public function getChallengeId()
    {return $this->challengeId;}
    public function getUserId()
    {return $this->userId;}
    public function getScore()
    {return $this->score;}
    public function getAttemptCount()
    {return $this->attemptCount;}
    public function getCreatedAt()
    {return $this->createdAt;}

    // Setter
    public function setChallengeId($challengeId)
    {$this->challengeId = $challengeId;return $this;}
    public function setUserId($userId)
    {$this->userId = $userId;return $this;}
    public function setScore($score)
    {$this->score = $score;return $this;}
    public function setAttemptCount($count)
    {$this->attemptCount = $count;return $this;}
}
