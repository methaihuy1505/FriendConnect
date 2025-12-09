<?php
class Challenge
{
    protected $id;
    protected $creatorId;
    protected $title;
    protected $description;
    protected $createdAt;

    public function __construct($id, $creatorId, $title, $description, $createdAt)
    {
        $this->id          = $id;
        $this->creatorId   = $creatorId;
        $this->title       = $title;
        $this->description = $description;
        $this->createdAt   = $createdAt;
    }

    // Getter
    public function getId()
    {return $this->id;}
    public function getCreatorId()
    {return $this->creatorId;}
    public function getTitle()
    {return $this->title;}
    public function getDescription()
    {return $this->description;}
    public function getCreatedAt()
    {return $this->createdAt;}

    // Setter
    public function setCreatorId($creatorId)
    {$this->creatorId = $creatorId;return $this;}
    public function setTitle($title)
    {$this->title = $title;return $this;}
    public function setDescription($description)
    {$this->description = $description;return $this;}
    public function setCreatedAt($createdAt)
    {$this->createdAt = $createdAt;return $this;}

    // Liên kết với repository khác
    public function getCreator()
    {
        $repo = new UserRepository();
        return $repo->find($this->creatorId);
    }

    public function getQuestions()
    {
        $repo = new QuestionRepository();
        return $repo->findByChallenge($this->id);
    }
    public function getAttempts()
    {
        $repo = new ChallengeAttemptRepository();
        return $repo->findByChallenge($this->id);
    }

}
