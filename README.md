Travaux pratiques - PHP / bases de données

Travail à réaliser

1. Adapter les modèles

Écrire une nouvelle classe Answer et modifier la classe Question afin de correspondre au nouveau modèle de données. Récupérer les données de la base de données sous forme d'objets Question et Answer uniquement.

BONUS

Les classes ne doivent pas contenir les clés étrangères sous forme de nombre, mais à la place, chaque objet Answer doit faire référence à un objet Question, et vice-versa.

2. Adapter la vue

Modifier le code de la page index.php afin de correspondre au nouveau modèle de données.

BONUS

Écrire des méthodes dans les class Question et Answer permettant de réaliser les requêtes SQL et de renvoyer les résultats sous forme d'objets, de telle sorte qu'il n'y ait plus aucune manipulation de la base de données réalisée en-dehors de ces classes.