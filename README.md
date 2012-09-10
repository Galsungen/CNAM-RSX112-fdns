# FDNS : Friend Domain Name Server #

## Matière / UE ##

 * RS112 : Sécurité et réseaux
 * Centre Régional Rhône-Alpes, FOD Grenoble
 * Année de réalisation : 2010

## Avertissement ##

Je met à disposition ces sources et ce sujet pour accompagner de nouveaux auditeurs dans les matières concernées. En aucun cas il ne s'agit de "la" solution au sujet, mais simplement de ma solution. Ne recopiez jamais le code d'un autre sans le comprendre, et surtout pas pour le rendre au formateur. Et même en le comprenant d'ailleurs dans le cadre du CNAM ... Ecrivez votre propre code, votre propre solution, vous verrez que vous en apprendrez bien plus. Ma démarche est juste de vous aider en vous donnant une réprésentation possible d'une solution. Je sais que moi cela m'aide comme démarche, et que j'écris ensuite toujours ma solution, avec ma vision.

Bon courage à tous si vous êtes dans le cursus du CNAM (Conservatoire National des Arts et Métiers).

##  Sujet ##

Travailler sur l'identification symbolique dans le réseau , le service DNS ( ou un équivalent ).

Le lien avec les Travaux dirigés : projet Fdns
<ol>
<li>réaliser un projet ( simple )</li>
<li>exposer les composés du projet ( monolithe ? ) : structure , protocoles , ...</li>
<li>envisager le projet sous l'angle sécurisation :</li>
  * identification ,<br />
  * authentification,<br />
  * intégrité,<br />
  * confidentialité,<br />
Le but étant de conserver les qualités relatives à :<br />
  * Entretenir la continuité du service<br />
  * Contrôler l'intrusion<br />
<li>étudier les agressions, trouver une réponse corrective</li>
<li>commencer la mise en œuvre de techniques sécuritaires ( reengineering )</li>
</ol>

***

Fdns : Friend Domain Name Server<br />
Pourquoi Friend : le but est de restreindre l'usage à une catégorie limitée d'agents « amis »,donc cela revient à ne pas accepter l'accès à tous les points du réseau Internet possiblee
( point placés hors du cercle de restriction )

L'objectif poursuivi par cette restriction est double :
<ol>
<li> établir un sous-ensemble d'acteurs acceptant les contraintes forgés par le groupe, contraintes qui ont un coût et provoquent des restrictions</li>
<li>protéger le dispositif mis en place pour le groupe de points extérieurs qui pourraient avoir des intentions néfastes pour le groupe</li>

![Image d'un cercle avec un nuage de points internes/externes](https://raw.github.com/Galsungen/CNAM-RSX112-fdns/master/images_sujet/001_cercle_points.jpg)

Aspect sécurisation<br />
Le problème qui se pose consiste avant tout à réaliser un groupe susceptible d'être protégé des éléments agresseurs externes ( murailles, guichets, vaccinations, etc …)<br />
Le deuxième aspect doit s'occuper de la conduite sécuritaire d'un groupe pour maintenir ses qualités : Gérer l'entrée d'acteurs, la sortie d'acteurs, les possibilités offertes à chaque acteur

Fdns, ce que ce n'est pas :
 * Un remplaçant d'un outil comme Bind, serveur DNS concrêt et réel , présent et indispensable sur Internet
 * Un futur service pouvant éventuellement remplacer un DNS
 * Un projet dont la finalité serait d'être installé sur Internet

Un serveur Fdns se différencie d'un DNS par la particularité de ne travailler qu'avec des « amis » c'est à dire des points acceptés par un gardien chargé de détecter les identités.<br />
Par comparaison, un DNS classique n'introduit pas cette notion de filtrage et accepte toute demande d'où qu'elle vienne du réseau.<br />
Dans ce sens Fdns est plus restrictif puisqu'il n'accepte pas de travailler pour des points IP anonymes.<br />

Un serveur Fdns c'est un projet « pédagogique », introduit pour exercer les connaissances théoriques donc abstraites acquises dans un cours. Il est donc susceptible de porter de nombreuses failles !.<br />

### Flot de contrôle typique d'un serveur DNS : fonction de recherche ###

![Schéma de fonctionnement des mémoires en fonction des requêtes](https://raw.github.com/Galsungen/CNAM-RSX112-fdns/master/images_sujet/002_schema_fonction.jpg)

<ol>
<li>Contrôler si le symbole est connu dans les tables ADS</li>
<li>le symbole est valide et présent dans le cache ?</li>
<li>le symbole est recherché dans la hiérarchie DNS ( récurent )</li>
<li>le symbole est référencé dans le cache DNS, il est mis en forme pour élaborer la réponse</li>
<li>le symbole est présent mais son TTL est valide ?</li>
</ol>

### Flot de contrôle typique d'un client DNS : le resolver et la fonction recherche ###

![Schéma illustrant la problématique](https://raw.github.com/Galsungen/CNAM-RSX112-fdns/master/images_sujet/003_schema_fonction.jpg)

<ol>
<li>Capturer les informations constituant la « question »</li>
<li>Elaborer la requête et l'envoyer</li>
<li>attendre la réponse et capturer le contenu</li>
<li>la réponse est reconnue mais nécessite de réitérer une résolution ?</li>
<li>Elaborer la réponse vers le demandeur</li>
</ol>

### Flot de données type dans un serveur DNS ###

![Schéma des flots de type de données](https://raw.github.com/Galsungen/CNAM-RSX112-fdns/master/images_sujet/004_schema_fonction.jpg)

### Schéma transactionnel type d'un DNS ###

![Schéma transactionnel type](https://raw.github.com/Galsungen/CNAM-RSX112-fdns/master/images_sujet/005_schema_fonction.jpg)

### Fonctions typique pour FDNS ###

Il s'agit ici de spécifier ce que devrait introduire un service Fdns pour être utilisable. Un composant Fdns élabore un annuaire local qu'il met à la disposition des agents adhérents au groupe Fdns. Un groupe Fdns est référencé dans l'annuaire Fdns !

Inscrire : C'est une fonction en principe qualifiée d'administrative puisqu'elle consiste à inscrire un candidat dans l'annuaire Fdns. L'initiateur doit disposer du droit d'écriture dans l'annuaire.

Rechercher : C'est une fonction de consultation réservée aux seuls adhérents. N'utilise que la capacité de lecture dans l'annuaire Fdns.

Radier : C'est une fonction en principe qualifiée d'administrative puisqu'elle consiste à supprimer un référencement dans l'annuaire Fdns. L'initiateur doit disposer du droit d'écriture dans l'annuaire.

Un groupe Fdns est référencé dans l'annuaire Fdns ce qui pose alors le problème de l'initiation de cette structure (remplissage initial).<br />
Le principe de la cooptation est utile dans ce cas. La cooptation consiste à demander à un adhérent dument inscrit de réaliser la première inscription d'un autre adhérent. Ce procédé s'appuie sur le principe d'une politique discrétionnaire.<br />
Il existe des constantes dans l'annuaire (des adhérents permanents), ces adhérents privilégiés peuvent coopter d'autres adhérents.<br />

### Vue sécuritaire sur un composant Fdns ###

Il s'agit ici de percevoir comment se comporterait un futur composant Fdns dans un réseau agressif et donc d'introduire certains correctifs susceptibles de solidifier le système.<br />
Elle s'applique après avoir acquis un niveau fonctionnel correct comprenant au moins les trois fonctions de base répertoriés pour Fdns : inscrire, rechercher, radier.<br />

Objectifs :

 * transporter l'identité des intervenants : Une notion de groupe existe, comment la gérer ?
 * Assumer la traçabilité : Le système ne sera jamais infaillible, au moins faut-il mémoriser les défaillances qu'il pouraait rencontrer.

 ### transporter l'identité des intervenants ###

![Schéma d'un échange](https://raw.github.com/Galsungen/CNAM-RSX112-fdns/master/images_sujet/006_schema_fonction.jpg)

Le serveur Fdns répond aux clients "amis" : ils sont adhérents à un groupe Fdns.

Resolver & serveur Fdns fournissent l'identité nécessaire à la détection d'appartenance à un groupe<br />
Le message possède des n° IP origine & destination acceptés dans le groupe<br />
Le resolver propose un identité logique<br />
Le serveur Fdns répond avec une identité logique<br />

Le but est de répondre aux adhérents et seulement à ceux-ci.<br />
Comment réagir devant une demande anonyme (agent non répertorié)<br />
- L'attitude la plus raisonnable serait de ne rien dire et de détruire simplement la requête ( attitude implicite de IP ). Cette approche viens du constat qu'un point IP qui répond systématiquement peut très facilement être inondé de requêtes inutiles et agressives cherchant à effondrer ses capacités de travail ( dénis de service ). L'absence de réponse ne modifie pas cet état de fait pour le serveur, mais place le client dans la situation d'un effort inutile possible (indécision).

### Assumer la traçabilité : Journalisation des requêtes / réponses ###

Un journal c'est le plus souvent un fichier texte qui enregistre « au fil de l'eau » tous les événements subits par le point IP ou le composant concerné par le problème de traçabilité. Il constitue une « histoire » des phénomènes reçus ou produits autours du composant porteur ou générateur du journal. C'est un enregistreur, le but du journal est d'offrir la capacité ultérieure d'extraire un diagnostique comportemental (le phénomène doit s'être produit pour être journalisé).

![Schéma échange et journalisation](https://raw.github.com/Galsungen/CNAM-RSX112-fdns/master/images_sujet/007_schema_fonction.jpg)

 * Le serveur Fdns répond aux clients « amis » : ils sont adhérents à un groupe Fdns
 * Un journal de « log » serveur Fdns enregistre le trafic subit

Pour un système de composants répartis dans un réseau, le problème consiste à synchroniser les écritures dans les différents journaux existant, pour pouvoir ensuite les confronter chronologiquement. Traditionnellement, le temps universel est utilisé mais avec la possibilité de désynchronisation des horloges, que ce soit coté client ou coté serveur, il est possible de rompre la capacité future de trouver des repères cohérents entre journaux. La lecture des journaux devrait permettre d'induire une relation cause-effet entre les événements inscrits dans les journaux.

Le plus souvent, une solution alternative au temps consiste à produire un « tag », il est introduit par le producteur dans le message que ce soit pour une requête ou une réponse. Ce « tag » est incrusté dans le journal du destinataire avec la ligne de journal créé à l'occasion de l'arrivée du message. Un « tag » c'est un identificateur ayant la propriété d'être unique dans l'espace d'expression. Par exemple, un tag numérique c'est un nombre essentiellement croissant et unique pour son producteur.

### Les problèmes aperçus mais pas forcément résolus ###

éviter le détournement de vue réalisable par un "intercepteur" (milieu).

![4 schémas illustrant ce point](https://raw.github.com/Galsungen/CNAM-RSX112-fdns/master/images_sujet/007_schema_fonction.jpg)

## Complément ##

### Installation ###

Le dossier "bdd" contient un fichier sql avec le schéma de la base de données, et un pseudo jeu de test pour pouvoir profiter dès le départ de l'application et comprendre son fonctionnement. J'ajouterais peut-être à terme un fichier sans le jeu de test. Il est ici présent car je tenais à présenter le projet tel que rendu, en exemple.

Le dossier "images" ne contient lui que quelques icones pour le projet. Le dossier "images_sujet" ne fait pas réellement partie du projet, il permet d'illustrer le présent README.

Le projet était prévu en PHP. Il était semble t-il plus logique de choisir MySQL comme base de données pour fonctionner avec. Nous pourrions bien sûr l'adapter à d'autres moteurs.

Dans le cadre de la sécurisation, nous avions un utilisateur dédié à cette base. Nous ne lui donnons que les droits minimum pour que l'application fonctionne. Il ne peut donc modifier le schéma des tables ou de la base mais il peut y lire et y écrire des données.

### description Architecture ###

Nous avons 4 tables :

gd_identification : permet de conserver la liste des utilisateurs et leurs rôles respectifs.<br />
gd_dns : permettant de conserver dans le temps les différents enregistrements réalisés et d'effectuer des recherches sur ces derniers.<br />
gd_connexions : permettant de conserver l'enregistrement de toutes les connexions réussies à l'application.<br />
gd_journal : permet de conserver une trace de toutes les opérations réussies ou échouées sur l'une des interfaces.<br />

### description des rôles et utilisateurs ###

<table>
  <tr>
		<td>Page / Rôle</td>
		<td>lecteur</td>
		<td>ecrivain</td>
		<td>admin</td>
	</tr>
		<tr>
		<td>Lecture (read)</td>
		<td>X</td>
		<td>X</td>
		<td>X</td>
	</tr>
		<tr>
		<td>Ajouter (save)</td>
		<td>&nbsp;</td>
		<td>X</td>
		<td>X</td>
	</tr>
		<tr>
		<td>Supprimer (suppression)</td>
		<td>&nbsp;</td>
		<td>X</td>
		<td>X</td>
	</tr>
		<tr>
		<td>Journal des opérations</td>
		<td>&nbsp;</td>
		<td>X</td>
		<td>X</td>
	</tr>
		<tr>
		<td>Journal des connexions</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>X</td>
	</tr>
		<tr>
		<td>Administration des utilisateurs</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>X</td>
	</tr>
		<tr>
		<td>Logout</td>
		<td>X</td>
		<td>X</td>
		<td>X</td>
	</tr>
		<tr>
		<td>utilisateurs disponibles</td>
		<td>Delphine / dp458904 <br/> Charly / ch009988</td>
		<td>Bob / bob987654 <br/> Alice / alice123</td>
		<td>toto / gd748596 <br/>  Alpha / ac415263</td>
	</tr>
</table>

### Propositions pour améliorer la sécurité ###

Ce projet en lui même st incomplet. Nous avons répondu à la majeure partie, mais nous pourrions faire encore bien plus afin d'en améliorer la sécurité. Voici quelques pistes pour le faire évoluer à court terme.

 * TLS / SSL : En mettant en place un certificat et en forcant les connexions à passer en HTTPS plutôt qu'en HTTP, nous échanges seront cryptés et donc plus sécurisés.

 * Zend / IonCube pour crypter les pages : Crypter les fichiers contenant le code peut permettre d'éviter qu'une personne qui accèderait au serveur puisse consulter le code de l'application directement, et ainsi en comprenant son fonctionnement, puisse intervenir sur son fonctionnement.

 * Page authentification aléatoire ou récurrente : Il pourrait être envisagé d'afficher de façon aléatoire ou suite à trop d'erreurs un système d'authentification sous la forme de plusieurs formulaires avecd es questions/réponses que seul l'utilisateur pourrait connaitre, ou que seul un humain pourrait répondre. Nous pourrions nous baser sur le protocole de Feige-Fiat-Shamir par exemple.

 * Bannissement des IP quand trop d'essais d'identification infructueux : La mise en place d'un "FAIL2BAN" serait aussi intéressante. Quand nous avons trop d'essais en erreur depuis uen même adresse IP, nous bloquons cette dernière pour un temps donné, ou définitivement. Nous pouvons alerter un administrateur à la suite.

 * Réplication de la base sur un autre serveur / Synchronisation (cluster) serveur pour haute disponibilité ou redondance : Nous pourrions envisager de répliquer la base sur un autre serveur, soit dans un but de haute disponibilité ou bien pour sécuriser cette dernière. En effet si le serveur crash, nous serons heureux de l'avoir de backuper, voire d'immédiatement fonctionnel grâce à une copie.
 
 * détection intrusion, ddos, ... : Nous pouvons élargir la sécurisation par des outils de détection d'intrusions ou d'attaques DDOS par exemple. Il n'y a pas forcément besoin de réinventer tout, nous pouvons utiliser les outils déjà disponibles sur le marché.