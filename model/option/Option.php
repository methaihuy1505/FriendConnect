<?php
class Option
{
    protected $id;
    protected $questionId;
    protected $content;
    protected $isCorrect;

    public function __construct($id, $questionId, $content, $isCorrect)
    {
        $this->id         = $id;
        $this->questionId = $questionId;
        $this->content    = $content;
        $this->isCorrect  = $isCorrect;
    }

    // Getter
    public function getId()
    {return $this->id;}
    public function getQuestionId()
    {return $this->questionId;}
    public function getContent()
    {return $this->content;}
    public function isCorrect()
    {return $this->isCorrect;}

    // Setter
    public function setQuestionId($questionId)
    {$this->questionId = $questionId;return $this;}
    public function setContent($content)
    {$this->content = $content;return $this;}
    public function setIsCorrect($isCorrect)
    {$this->isCorrect = $isCorrect;return $this;}

    // Liên kết với repository khác
    public function getQuestion()
    {
        $repo = new QuestionRepository();
        return $repo->find($this->questionId);
    }
}
