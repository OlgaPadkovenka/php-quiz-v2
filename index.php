<?php

include './models/Question.php';
include './models/Answer.php';

$databaseHandler = new PDO('mysql:host=localhost;dbname=quizpoo', 'root', 'root');

$formSubmitted = $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['answer']) && isset($_POST['current-question']);

//Si le formulaire vient d'être envoyé
if ($formSubmitted) {

    //Je récupère la question précedénte en base de données
    $statement = $databaseHandler->prepare(
        'SELECT
                `question`.`id`,
                `answer`.`id` as `right_answer_id`,
                `answer`.`text` as `right_answer_text`
         FROM   `question`
         JOIN   `answer` ON `answer`.`id` = `question`.`right_answer_id`
         WHERE  `question`.`id` = :id'
    );
    $statement->execute([':id' => $_POST['current-question']]);
    $questionData = $statement->fetch();
    $previousQuestion = new Question(
        $questionData['id'],
        '',
        new Answer(
            $questionData['right_answer_id'],
            $questionData['right_answer_text']
        ),
        null,
    );

    //je vérifie, si la réponse fournie par l'utilisateur est une bonne réponse.
    $rightlyAnswered = intval($_POST['answer']) === $previousQuestion->getRightAnswer()->getId();
}

$question = Question::findById(2);
$answers = Answer::findByQuestion($question);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <!------ Include the above in your HEAD tag ---------->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
</head>

<body>
    <div class="container">
        <h1>Quizz</h1>

        <?php if ($formSubmitted) : ?>
            <!-- Affiche une alerte uniquement si l'utilisateur vient de répondre à une question -->
            <div id="answer-result" class="alert alert-<?php if ($rightlyAnswered) {
                                                            echo 'success';
                                                        } else {
                                                            echo 'danger';
                                                        } ?>">
                <i class="fas fa-thumbs-<?php if ($rightlyAnswered) {
                                            echo 'up';
                                        } else {
                                            echo 'down';
                                        } ?>"></i>
                <!-- Affiche un texte différent selon que l'utilisateur a bien répondu à la question ou non -->
                <?php if ($rightlyAnswered) : ?>
                    Bravo, c'était la bonne réponse!
                <?php else : ?>
                    Hé non! La bonne réponse était <strong><?= $previousQuestion->getRightAnswer()->getText() ?></strong>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        <h2 class="mt-4">Question n°<span id="question-id"><?= $question->getRank() ?></span></h2>
        <form id="question-form" method="post">
            <p id="current-question-text" class="question-text"><?= $question->getText() ?></p>
            <div id="answers" class="d-flex flex-column">

                <?php foreach ($answers as $answer) : ?>
                    <div class="custom-control custom-radio mb-2">
                        <input class="custom-control-input" type="radio" name="answer" id="<?= $answer->getId() ?>" value="<?= $answer->getId() ?>">
                        <label class="custom-control-label" for="<?= $answer->getId() ?>" id="answer1-caption"><?= $answer->getText() ?></label>
                    </div>
                <?php endforeach ?>

            </div>
            <input type="hidden" name="current-question" value="<?= $question->getId() ?>" />
            <button type="submit" class="btn btn-primary">Valider</button>
        </form>
    </div>
</body>

</html>