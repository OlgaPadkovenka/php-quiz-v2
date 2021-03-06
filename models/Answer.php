<?php

class Answer
{
    private ?int $id;
    private string $text;
    private ?Question $question;

    public function __construct(
        ?int $id = null,
        string $text = '',

    ) {
        $this->id = $id;
        $this->text = $text;
    }

    static public function findByQuestion(Question $question)
    {
        $databaseHandler = new PDO('mysql:host=localhost;dbname=quizpoo', 'root', 'root');
        $statement = $databaseHandler->prepare('SELECT * FROM `answer` WHERE `question_id` = :questionId');
        $statement->execute([':questionId' => $question->getId()]);
        $answersData = $statement->fetchAll();
        foreach ($answersData as $answerData) {
            $answers[] = new Answer(
                $answerData['id'],
                $answerData['text'],
                $question
            );
        }

        return $answers;
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
    public function getQuestion(): ?Question
    {
        return $this->question;
    }

    /**
     * Set the value of question
     */
    public function setQuestion(?Question $question)
    {
        $this->question = $question;
    }
}
