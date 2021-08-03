<?php

class Question
{

    private ?int $id;
    private string $text;
    private ?int $rightAnswerId;
    private ?int $rank;

    public function __construct(
        ?int $id = null,
        string $text = '',
        ?int $rightAnswerId = null,
        ?int $rank = null
    ) {
        $this->id = $id;
        $this->text = $text;
        $this->rightAnswerId = $rightAnswerId;
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
    public function getRightAnswerId()
    {
        return $this->rightAnswerId;
    }

    /**
     * Get the value of rank
     */
    public function getRank()
    {
        return $this->rank;
    }
}
