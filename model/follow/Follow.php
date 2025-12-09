<?php
class Follow
{
    protected $id;
    protected $followerId;
    protected $followedId;
    protected $createdAt;

    public function __construct($id, $followerId, $followedId, $createdAt)
    {
        $this->id         = $id;
        $this->followerId = $followerId;
        $this->followedId = $followedId;
        $this->createdAt  = $createdAt;
    }

    // Getter
    public function getId()
    {return $this->id;}
    public function getFollowerId()
    {return $this->followerId;}
    public function getFollowedId()
    {return $this->followedId;}
    public function getCreatedAt()
    {return $this->createdAt;}

    // Setter
    public function setFollowerId($followerId)
    {$this->followerId = $followerId;return $this;}
    public function setFollowedId($followedId)
    {$this->followedId = $followedId;return $this;}
    public function setCreatedAt($createdAt)
    {$this->createdAt = $createdAt;return $this;}

    // Liên kết với repository khác
    public function getFollower()
    {
        $repo = new UserRepository();
        return $repo->find($this->followerId);
    }

    public function getFollowed()
    {
        $repo = new UserRepository();
        return $repo->find($this->followedId);
    }
}
