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

4. Je fais une nouvelle requette pour récupérer les réponses.
Dans answer j'ai question_id que je peux récupérer via un getteur, parce que c'est une propriété privée de la Question. Comme j'ai importé la classe Question dans l'index, j'ai accès aux propriétés de cette classe.

$statement = $databaseHandler->prepare('SELECT * FROM `answer` WHERE `question_id` = :questionId');
$statement->execute([':questionId' => $question->getId()]);
var_dump(
    $statement->fetchAll()
);

Je récupère le tableau des réponses:
(array) [4 elements]
0: 
(array) [6 elements]
id: (string) "2"
0: (string) "2"
text: (string) "5"
1: (string) "5"
question_id: (string) "1"
2: (string) "1"
1: 
(array) [6 elements]
id: (string) "3"
0: (string) "3"
text: (string) "7"
1: (string) "7"
question_id: (string) "1"
2: (string) "1"
2: 
(array) [6 elements]
id: (string) "4"
0: (string) "4"
text: (string) "11"
1: (string) "11"
question_id: (string) "1"
2: (string) "1"
3: 
(array) [6 elements]
id: (string) "5"
0: (string) "5"
text: (string) "235"
1: (string) "235"
question_id: (string) "1"
2: (string) "1"

5. J'importe la class Answer dans index.php
include './models/Answer.php';

6. Je range les résultats dans une variable:
$allAnswersData = $statement->fetchAll();

7. $allAnswersData est un tableau associatif. Je peux le parcourir et créer pour chaque réponse un objet Answer.
foreach ($allAnswersData as $allAnswerData) {
    new Answer(
        $allAnswerData['id'],
        $allAnswerData['text'],
        $allAnswerData['question_id']

    );
}

foreach ($allAnswersData as $allAnswerData) {
    var_dump(
        new Answer(
            $allAnswerData['id'],
            $allAnswerData['text'],
            $allAnswerData['question_id']

        )
    );
}

Résultat:
Answer (object) [Object ID #2][3 properties]
id:Answer:private: (integer) 2 
text:Answer:private: (string) "5"
questionId:Answer:private: (integer) 1 
Answer (object) [Object ID #2][3 properties]
id:Answer:private: (integer) 3 
text:Answer:private: (string) "7"
questionId:Answer:private: (integer) 1 
Answer (object) [Object ID #2][3 properties]
id:Answer:private: (integer) 4 
text:Answer:private: (string) "11"
questionId:Answer:private: (integer) 1 
Answer (object) [Object ID #2][3 properties]
id:Answer:private: (integer) 5 
text:Answer:private: (string) "235"
questionId:Answer:private: (integer) 1

8. Je range les résultat dans le tableau $answers.
foreach ($allAnswersData as $allAnswerData) {
    $answers[] = new Answer(
        $allAnswerData['id'],
        $allAnswerData['text'],
        $allAnswerData['question_id']
    );
}

9. Je récupère les réponses
    <?php foreach ($answers as $answer) : ?>
                    <div class="custom-control custom-radio mb-2">
                        <input class="custom-control-input" type="radio" name="answer" id="<?= $answer->getId() ?>" value="<?= $answer->getId() ?>">
                        <label class="custom-control-label" for="<?= $answer->getId() ?>" id="answer1-caption"><?= $answer->getText() ?></label>
                    </div>
                <?php endforeach ?>

10. $previousQuestion->getRightAnswerId()
//Si le formulaire vient d'être envoyé
if ($formSubmitted) {

    //Je récupère la question précedénte en base de données
    $statement = $databaseHandler->prepare('SELECT * FROM `question` WHERE `id` = :id');
    $statement->execute([':id' => $_POST['current-question']]);
    $questionData = $statement->fetch();
    $previousQuestion = new Question(
        $questionData['id'],
        $questionData['text'],
        $questionData['right_answer_id'],
        $questionData['rank']
    );

    //je vérifie, si la réponse fournie par l'utilisateur est une bonne réponse.
    $rightlyAnswered = intval($_POST['answer']) === $previousQuestion->getRightAnswerId();
}

BONUS: Les classes ne doivent pas contenir les clés étrangères sous forme de nombre, mais à la place, chaque objet Answer doit faire référence à un objet Question, et vice-versa.

11. Dans Answer.php j'ai  private int $questionId; qui est un nobre.
A la place d'un nombre je voudrais avoir un objet Question.

private int $questionId; - un nombre
private Question $question; - un objet Question


12. Je supprime questionId de constructeur dans Answer.php et dans foreach dans l'index.php et je modifie son getteur.
  /**
     * Get the value of questionId
     */
    public function getQuestion(): ?Question
    {
        return $this->question;
    }

13. Pour l'instant l'objet Question qui et dans Answer.php n'est pas initialisé.
Pour pouvoir accéder aux propriétés de la Question dans la classe Answer, j'ai besoin d'ajouter un setteur dans Answer.php.

  public function setQuestion(?Question $question)
    {
        $this->question = $question;
    }

P.S. Quand on crée une réponse, on a envie d'associer un objet Question à une réponse. Le problème est que la propriété Question est privée. Grace à une méthode get, on peut accéder à la valeur. De la même manière, on peut écrire une méthode set qui permettra modifier les propriété de la Question. Et comme la méthode set est public, on peut y accéder.

14. J'ajoute la Question dans la variable $answer et je range la valeur dans le tableau $answers[].

foreach ($allAnswersData as $answerData) {
    $answer = new Answer(
        $answerData['id'],
        $answerData['text'],
    );
    $answer->setQuestion($question);
    $answers[] = $answer;

    var_dump($answer);
    var_dump($answer->getQuestion());
    var_dump($answer->getQuestion()->getText());
}

Comme ca j'ai un objet Answer qui contient l'objet Question.

Le constructeur permet d'inicialiser les propriétés d'un objet. Mais ce n'est pas obligatoire. Je peux avoir un constructeur vide. 
Dans les propriétés de l'Answer j'ai un id et un text que j'initialise quand je crée l'objet Answer. Pour pouvoir ajouter l'objet Question dedans, j'ai besoin d'une méthode set qui me permettra de modifier l'objet Answer.

Le constructeur est une méthode qui se déclanche automatiquement à la création d'un objet.

 public function __construct(
        ?int $id = null,
        string $text = '',
        //ce sont les paramètres

    ) {
        $this->id = $id;
        $this->text = $text;
        //on définit ce que la méthode fait
    }


Je peux mettre l'objet dans le constructeur

 public function __construct(
        ?int $id = null,
        string $text = '',
       ?Question $question = null

    ) {
        $this->id = $id;
        $this->text = $text;
        $this->question = $question;
    }

    Et dans le foreach j'ajoute $question dans le constructeur.
    foreach ($allAnswersData as $answerData) {
    $answer = new Answer(
        $answerData['id'],
        $answerData['text'],
        $question
    );
    $answers[] = $answer;

Cela marche pareil.

15. Dans la Question, j'ai un rightAnswerId qui est un nombre, m'ai je voudrais avoir un objet Réponse avec une bonne réponse.
