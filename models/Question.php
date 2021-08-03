<?php

class Question
{

    private ?int $id;
    private string $text;
    private ?int $rightAnswer;
    private ?int $rank;

    public function __construct(
        ?int $id = null,
        string $text = '',
        ?int $rightAnswer = null,
        ?int $rank = null
    ) {
        $this->id = $id;
        $this->text = $text;
        $this->rightAnswer = $rightAnswer;
        $this->rank = $rank;
    }

    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the value of text
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Get the value of rightAnswer
     */
    public function getRightAnswer()
    {
        return $this->rightAnswer;
    }

    /**
     * Get the value of rank
     */
    public function getRank()
    {
        return $this->rank;
    }
}
