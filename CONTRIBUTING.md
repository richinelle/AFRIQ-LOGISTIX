git commit -m "feat :Ajout de la structure du projet avec le backend"

 git commit -m "feat :ajout des composants docker"


1. Les principaux Types de Commit (avec explications)
Voici la liste des préfixes standardisés que tu peux utiliser selon la nature de ta modification :

🚀 feat (Feature)
Utilisé lorsque tu ajoutes une nouvelle fonctionnalité à ton application.

Exemple : feat(auth): ajouter la connexion via Google

🐛 fix (Bug Fix)
Utilisé lorsque tu corriges un bug ou une anomalie dans le code.

Exemple : fix(cart): corriger le calcul de la TVA lors de la validation

⚙️ chore (Tâches courantes / Maintenance)
Utilisé pour les modifications qui ne touchent ni aux fichiers de test, ni au code de production (ex: modifier le fichier .gitignore, mettre à jour les dépendances, configurer des outils comme Docker).

Exemple : chore: mettre à jour les packages de npm

Exemple : chore(docker): ajouter le service redis au docker-compose

📝 docs (Documentation)
Utilisé uniquement pour les modifications de la documentation (fichiers README.md, commentaires dans le code, documentation d'une API).

Exemple : docs: mettre à jour les instructions d'installation du projet

🎨 style (Formatage et UI)
Utilisé pour les changements cosmétiques qui n'affectent pas la logique du code (espaces, formatage avec Prettier, points-virgules manquants) ou pour l'intégration pure de styles CSS/Tailwind.

Exemple : style(navbar): ajuster l'espacement des boutons

♻️ refactor (Refactorisation)
Utilisé pour une modification du code de production qui ne corrige pas de bug et n'ajoute pas de fonctionnalité, mais qui améliore la structure ou la lisibilité du code.

Exemple : refactor(controllers): extraire la logique de paiement dans un Service

⚡ perf (Performance)
Utilisé pour une modification du code qui sert spécifiquement à améliorer les performances (vitesse, mémoire).

Exemple : perf(database): ajouter un index sur la colonne email

🧪 test (Tests)
Utilisé lorsque tu ajoutes des tests manquants ou que tu modifies des tests existants (PHPUnit, Jest, etc.).

Exemple : test(api): ajouter des tests unitaires pour le controlleur de produits

📦 ci ou build
ci : Modifications liées à tes scripts de déploiement continu ou d'intégration (GitHub Actions, GitLab CI). Exemple : ci: ajouter l'étape de staging sur GitHub Actions

build : Modifications affectant le système de build (ex: configuration de Vite, Webpack, Composer). Exemple : build: mettre à jour la version minimale de PHP requis

2. Les options et éléments structurels
Pour enrichir tes commits, tu peux utiliser des éléments optionnels très puissants :

A. La Portée (scope)
C'est le mot entre parenthèses juste après le type. Il sert à indiquer quelle partie précise du projet est impactée.

Syntaxe : type(scope): message

Exemple : feat(api): ajouter le endpoint pour récupérer les utilisateurs

B. Le Changement Majeur (BREAKING CHANGE)
Si ta modification casse la compatibilité ascendante (par exemple, si tu supprimes une table dans la base de données ou si tu changes complètement une route d'API), tu dois le signaler de deux manières :

En ajoutant un point d'exclamation ! juste avant les deux-points.

En expliquant la rupture dans le corps du message.

Exemple court :