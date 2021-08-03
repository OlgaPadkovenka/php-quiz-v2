1. Je change le modèle de donées de la Question.
class Question
{

    private ?int $id;
    private string $text;
    private ?int $rightAnswerId;
    private ?int $rank;

2. Je crée une classe Answer. Je fais le conctructeur et les geutteurs pour pouvoir accéder aux propriétés.
<?php

class Answer
{
    private ?int $id;
    private string $text;
    private int $questionId;
}

3. Je récupère la question actuelle dans la base de données.

$statement = $databaseHandler->query('SELECT * FROM `question` ORDER BY `rank` LIMIT 1');
$questionData = $statement->fetch();
$question = new Question(
    $questionData['id'],
    $questionData['text'],
    $questionData['right_answer_id'],
    $questionData['rank']
);
