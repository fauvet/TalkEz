# intothewhile
Git : Permet de versionner son code.
Github : Permet de partager les versions en ligne
WampServer : Un serveur.

Il vous faut donc créer un compte github et télécharger Git ainsi que Wamp.
…
Une fois les téléchargements finis il faut lancer Wamp puis Git Bash.
Une fois Git Bash ouvert sous Windows il faut se rendre dans C:/Wamp/www (certaines commandes linux fonctionnent comme ‘ll’ – pour ls – et ‘cd’)

Taper la commande : git clone https://github.com/xdrm-brackets/intothewhile.git
		    cd intothewhile

Les commandes utiles : 
git log -> permet de consulter l’ensemble des commit (sauvegarde) du projet
git status -> permet de savoir en détaillé si vous avez la dernière version partagé

Envoyer / Recevoir le projet :
git pull origin NOM_DE_LA_BRANCHE -> le nom de la branche est écrite entre paranthèses en bleu. permet de recevoir le projet.
git push origin NOM_DE_LA_BRANCHE -> le nom de la branche est écrite entre paranthèses en bleu. permet d’envoyer le projet.

Commande à faire avant de push :
git add FICHIER1 FICHIER2 … -> ajoute les fichiers à la liste des choses à envoyer en push. on peut éventuellement remplacer le nom des fichiers par un ‘-a’ mais après il peut il y avoir des conflits.
git commit –m « MESSAGE INFORMATIF SUR LE COMMIT » -> ajoute un comit (une sauvegarde) au projet. n’est donc sans conséquence sur le projet. on peut toutefois ne pas faire l’étape du dessus (git add) en remplaçant le ‘–m’ par ‘–am’

Si il y a d’afficher « merge » dans ce cas demander de l’aide …
