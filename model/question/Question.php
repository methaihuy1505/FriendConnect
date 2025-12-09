<?php
class Question
{
    protected $id;
    protected $challengeId;
    protected $content;

    public function __construct($id, $challengeId, $content)
    {
        $this->id          = $id;
        $this->challengeId = $challengeId;
        $this->content     = $content;
    }

    // Getter
    public function getId()
    {return $this->id;}
    public function getChallengeId()
    {return $this->challengeId;}
    public function getContent()
    {return $this->content;}

    // Setter
    public function setChallengeId($challengeId)
    {$this->challengeId = $challengeId;return $this;}
    public function setContent($content)
    {$this->content = $content;return $this;}

    // Liên kết với repository khác
    public function getChallenge()
    {
        $repo = new ChallengeRepository();
        return $repo->find($this->challengeId);
    }

    public function getOptions()
    {
        $repo = new OptionRepository();
        return $repo->findByQuestion($this->id);
    }
}
