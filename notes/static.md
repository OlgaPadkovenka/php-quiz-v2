1. Je voudrais déclaréer les méthodes comme static.
Cela veut dire que les méthodes vont appartenir à la classe et pas à l'objet. J'ajoute static devant la méthode.

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

2. Pour appeler cette méthode à index.php, je supprime

$question = new Question();
$question = $question->findById(1);

$answer = new Answer();
$answers = $answer->findByQuestion($question);

 Et j'utilise cette syntaxe:

Question::findById(2);
Answer::findByQuestion($question);

Je range les résultats dans des variables:

$question = Question::findById(2);
$answers = Answer::findByQuestion($question);

3. 