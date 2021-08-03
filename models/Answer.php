<?php

class Answer
{
    private ?int $id;
    private string $text;
    private int $questionId;

    public function __construct(
        ?int $id = null,
        string $text = '',
        int $questionId = null,
    ) {
        $this->id = $id;
        $this->text = $text;
        $this->questionId = $questionId;
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
     * Get the value of questionId
     */
    public function getQuestionId()
    {
        return $this->questionId;
    }
}
