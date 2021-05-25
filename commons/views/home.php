<?php
session_start();
include_once '../../requests/select.php';

if (!isset($_SESSION["role"])) {

    header("location: ../../connexion/co.php?co=newco");
}

?>
<!DOCTYPE html>
<html>

<?php
include_once '../../bases/head.php';
?>

<body>
    <?php include_once '../../bases/menu.php'; ?>

    <div class="warn">
        <span class="mif-warning ani-bounce"></span> PHASE DE TEST - RELEASE - ScratchOverflow V2.0 <span class="mif-warning ani-bounce"></span><br>
        Ceci est un site toujours en développement, certains bugs peuvent subsister. Si vous en rencontrez un, n'hésitez pas à me faire vos retours sur Discord ou par mail.
    </div><br><br>
    <div class="description">
        <h1>
            <img src="../../medias/scratchOverflow.png" alt="allo">
        </h1>
        <h2>Ce site web a été créé pour faciliter le tutorat et l'aide entre les promos de l'EPSI & de WIS. <br>Ici vous pouvez retrouver la description du site et les quelques règles du tutorat.</h2>
    </div>
    <br><br><br>
    <div class='grid'>
        <div class='row'>
            <div class='cell-4 offset-1'><b>Description du site</b>
                <div data-role="accordion" data-material="true">
                    <div class="frame">
                        <div class="heading"><i>Proposer</i></div>
                        <div class="content">
                            <div class="p-2">L'onglet 'Proposer' vous permet, si vous en avez besoin, de voter pour des cours déjà proposés par d'autres étudiants.<br><br>Si aucune matière n'est en rapport avec votre demande, vous pouvez en ajouter une vous-même à l'aide du formulaire.<br><br>Plus un cours a de votants, plus il apparaîtra haut dans le classement. Les tuteurs pourront ainsi voir quelles sont les demandes prioritaires.</div>
                        </div>
                    </div>
                    <div class="frame">
                        <div class="heading"><i>S'inscrire à un cours</i></div>
                        <div class="content">
                            <div class="p-2">L'onglet "S'inscrire à un cours", permet de s'inscrire à un cours déjà créer et planifié.<br><br>Cet onglet vous permet aussi de clore / annuler vos cours quand ceux si sont terminés.</div>
                        </div>
                    </div>
                    <div class="frame">
                        <div class="heading"><i>Donner un cours</i></div>
                        <div class="content">
                            <div class="p-2">L'onglet "Donner un cours", permet de créer un cours proposé par les autres étudiants (Attention, si vous avez proposer un cours, vous ne pouvez pas en être le tuteur), ou créer un autre cours.</div>
                        </div>
                    </div>
                    <div class="frame">
                        <div class="heading"><i>Forum</i></div>
                        <div class="content">
                            <div class="p-2">L'onglet "Forum", permet de poser une question sur un cours que vous avez mal compris.<br><br>Cet onglet vous permet également de répondre à une question et de voter pour une réponse qui vous aura aidé.</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class='cell-4 offset-2'><b>Les quelques règles</b><br><br>
                <span class="mif-sunrise"></span> Le tutorat est donné bénévolement en dehors des heures de cours.<br><br>
                <span class="mif-sunrise"></span> En t'inscrivant à un cours, tu t'engages à venir à ce cours (Tu peux t'en désinscrire, et prévenir le tuteur, pour qu'il ne se retrouve pas seul au cours).<br><br>
                <span class="mif-sunrise"></span> En tant que tuteur, tu t'engages à venir au cours que tu as proposé (Tu peux l'annuler, puis prévenir sur le discord que le cours n'aura pas lieu).<br><br>
                <span class="mif-sunrise"></span> Quand tu viens à un cours, essaye de rester calme (C'est jamais plaisant pour un tuteur de voir que des gens volontaires ne l'écoutent pas).<br><br>
                <span class="mif-sunrise"></span> Quand tu postes une question ou une réponse, fais attention à bien être respectueux. On a pas tous le même niveau, le forum est là pour apporter son aide, pas pour juger (Un peu d'humanité dans ce monde de bête ;) ).
            </div>
        </div>
    </div><br><br>
    <!-- <h5>Patchnotes</h5>
    <div class="remark info">
        <div class="spanpatch">
            <b>Patchnote - BETA v0.5 - 06/10/2019</b><br><br>
            <span class="mif-add"></span><i> Ajout d'un système de mail automatique à la création d'un cours. Un mail est envoyé à l'équipe pédagogique afin de vous fournir une liste de salles dispos à l'horaire de votre cours.</i><br>
            <span class="mif-add"></span><i> Ajout de features pour les admins du site.</i><br>
            <span class="mif-add"></span><i> Refonte graphique de la page de connexion.</i><br>
        </div>
    </div>
    <div class="remark info">
        <div class="spanpatch">
            <b>Patchnote - BETA v0.4 - 04/10/2019</b><br><br>
            <span class="mif-add"></span><i> Désormais vous pouvez ajouter une matière dans l'onglet "Proposer", (ceci n'implique plus la création d'une proposition).</i><br>
            <span class="mif-add"></span><i> Dans l'aperçu de compte, vous retrouvez la liste de vos cours, terminés ou annulés.</i><br>
            <span class="mif-add"></span><i> Les fonctionnalités de la page "Vos cours" sont transférées sur "S'inscrire à un cours". Désormais vous voyez même vos cours et vous pouvez les clore / annuler d'ici.</i><br><br>
            <span class="mif-cross"></span><i> La page "Vos cours" est supprimée pour plus de clarté.</i><br><br>
            <span class="mif-checkmark"></span><i> Résolution de bugs mineurs sur la création de compte.</i><br>
        </div>
    </div>
    <div class="remark info">
        <div class="spanpatch">
            <b>Patchnote - BETA v0.3 - 02/10/2019</b><br><br>
            <span class="mif-add"></span><i> Ajout du bot Discord du tutorat.</i><br>
            <span class="mif-add"></span><i> Réaménagement de la page "Vos cours".</i><br>
            <span class="mif-add"></span><i> Ajout de fonctionnalités pour les admins.</i><br><br>
            <span class="mif-checkmark"></span><i> Résolution de bugs mineurs sur la création de cours.</i><br>
        </div>
    </div>
    <div class="remark info">
        <div class="spanpatch">
            <b>Patchnote - BETA v0.2 - 01/10/2019</b><br><br>
            <span class="mif-add"></span><i> Ajout d'une autre méthode de proposition.</i><br>
            <span class="mif-add"></span><i> Ajout d'éléments graphiques (coucou Anaïs).</i><br><br>
            <span class="mif-checkmark"></span><i> Résolution d'un bug sur la création d'un cours à partir d'une proposition.</i><br>
        </div>
    </div>
    <div class="remark info">
        <div class="spanpatch">
            <b>Patchnote - BETA v0.1 - 11/09/2019</b><br><br>
            <span class="mif-add"></span><i> Ajout de la création d'utilisateur.</i><br>
            <span class="mif-add"></span><i> Ajout de la connexion.</i><br>
            <span class="mif-add"></span><i> Ajout de la création de cours.</i><br>
            <span class="mif-add"></span><i> Ajout de la création de propositions.</i><br>
            <span class="mif-add"></span><i> Ajout de l'inscription à un cours.</i><br><br>
            <span class="mif-bug"></span><i> Bug connu sur la création d'un cours à partir d'une proposition.</i><br>
        </div>
    </div>
    <i>Merci à Anaïs Tatibouët pour son aide sur ce projet, et à Pierre Nègre pour son soutien moral.</i> -->
</body>
<script src="../../js/activeMenu.js"></script>

</html>