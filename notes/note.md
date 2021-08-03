1. Je change le modèle de donées de la Question.
class Question
{

    private ?int $id;
    private string $text;
    private ?int $rightAnswer;
    private ?int $rank;

2. Je crée une classe Answer. Je fais le conctructeur et les geutteurs pour pouvoir accéder aux propriétés.
<?php

class Answer
{
    private ?int $id;
    private string $text;
    private int $questionId;
}

3. 
