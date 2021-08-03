<?php

class Question
{

    private ?int $id;
    private string $text;
    private ?Answer $rightAnswer;
    private ?int $rank;

    public function __construct(
        ?int $id = null,
        string $text = '',
        ?Answer $rightAnswer = null,
        ?int $rank = null
    ) {
        $this->id = $id;
        $this->text = $text;
        $this->rightAnswer = $rightAnswer;
        $this->rank = $rank;
    }

    public function findById(int $id): ?Question
    {
        $databaseHandler = new PDO('mysql:host=localhost;dbname=quizpoo', 'root', 'root');
        $statement = $databaseHandler->prepare('SELECT * FROM `question` WHERE `id` = :id');
        $statement->execute([':id' => $id]);

        $questionData = $statement->fetch();
        return new Question(
            $questionData['id'],
            $questionData['text'],
            null,
            $questionData['rank']
        );
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
    public function getRightAnswer(): ?Answer
    {
        return $this->rightAnswer;
    }

    /**
     * Set the value of rightAnswer
     *
     */
    public function setRightAnswer(?Answer $answer)
    {
        $this->rightAnswer = $answer;
    }

    /**
     * Get the value of rank
     */
    public function getRank()
    {
        return $this->rank;
    }
}
