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

<br>
<div class="description">
    <h1 class="display3">Mentions légales</h1><br>
    <h2>Merci de lire avec attention les différentes modalités d’utilisation du présent site avant d’y parcourir ses pages. <br>
        En vous connectant sur ce site, vous acceptez sans réserves les présentes modalités. <br>
        Aussi, conformément à l’article n°6 de la Loi n°2004-575 du 21 Juin 2004 pour la confiance dans l’économie numérique, les responsables du présent site internet sont :</h2>
</div>


<br><br><br>
<div data-role="accordion"
     data-one-frame="false"
     data-show-active="true"
     data-on-frame-open="console.log('frame was opened!', arguments[0])"
     data-on-frame-close="console.log('frame was closed!', arguments[0])">
                <div class="frame">
                    <div class="heading"><span class="mif-display mif-lg fg-crimson"></span> <i> Conditions d'utilisation </i> </div>
                    <div class="content">
                        <div class="p-2">Ce site est proposé en différents langages web (PHP, JavaScript, CSS, etc…) pour
                                un meilleur confort d’utilisation et un graphisme plus agréable, nous vous recommandons de recourir à des navigateurs
                                modernes comme Safari, Firefox, Google Chrome, etc… <br>
                                ScratchOverflow met en œuvre tous les moyens dont elle dispose, pour assurer une information fiable et une mise à jour fiable de ses sites internet.<br>
                                Toutefois, des erreurs ou omissions peuvent survenir. L’internaute devra donc s’assurer de l’exactitude
                                des informations auprès de cedric.menanteau@epsi.fr, et signaler toutes modifications du site qu’il jugerait utile.
                                ScrathOverflow n’est en aucun cas responsable de l’utilisation faite de ces informations, et de tout préjudice direct ou indirect pouvant en découler.
                        </div>
                    </div>
                </div>
                <div class="frame">
                    <div class="heading"><span class="mif-database mif-lg fg-crimson"></span> <i> Limitation contractuelles sur les données </i></div>
                    <div class="content">
                        <div class="p-2">Les informations contenues sur ce site sont aussi précises que possible et le site remis à jour à différentes périodes de l’année,
                            mais peut toutefois contenir des inexactitudes ou des omissions. Si vous constatez une lacune, erreur ou ce qui parait être un dysfonctionnement,
                            merci de bien vouloir le signaler par email, à l’adresse cedric.menanteau@epsi.fr, en décrivant le problème de la manière la plus précise possible
                            (page posant problème, type d’ordinateur et de navigateur utilisé, …). <br>
                            Tout contenu téléchargé se fait aux risques et périls de l’utilisateur et sous sa seule responsabilité.<br>
                            En conséquence, ne saurait être tenu responsable d’un quelconque dommage subi par l’ordinateur de l’utilisateur ou d’une quelconque perte de données consécutives au téléchargement. <br>
                            De plus, l’utilisateur du site s’engage à accéder au site en utilisant un matériel récent, ne contenant pas de virus et avec un navigateur de dernière génération mis-à-jour. <br>
                            Les liens hypertextes mis en place dans le cadre du présent site internet en direction d’autres ressources présentes sur le réseau Internet
                            ne sauraient engager la responsabilité de ScratchOverflow.</div>
                    </div>
                </div>
                <div class="frame">
                    <div class="heading"><span class="mif-file-empty mif-lg fg-crimson"></span> <i> Déclaration à la CNIL</i></div>
                    <div class="content">
                        <div class="p-2">Conformément à la loi 78-17 du 6 janvier 1978 (modifiée par la loi 2004-801 du 6 août 2004 relative à la protection des personnes
                            physiques à l’égard des traitements de données à caractère personnel) relative à l’informatique, aux fichiers et aux libertés,
                            ce site a fait l’objet d’une déclaration en cours auprès de la Commission nationale de l’informatique et des libertés (www.cnil.fr).</div>
                    </div>
                </div>
                <div class="frame">
                    <div class="heading"><span class="mif-justice mif-lg fg-crimson"></span><i> Litiges </i></div>
                    <div class="content">
                        <div class="p-2">Les présentes conditions du site ScratchOverflow sont régies par les lois françaises et toute contestation ou litiges qui pourraient
                            naître de l’interprétation ou de l’exécution de celles-ci seront de la compétence exclusive des tribunaux français. <br>
                            La langue de référence, pour le règlement de contentieux éventuels, est le français.</div>
                    </div>
                </div>
                <div class="frame">
                    <div class="heading"><span class="mif-lock mif-lg fg-crimson"></span><i> Données personnelles</i></div>
                    <div class="content">
                        <div class="p-2">De manière générale, vous n’êtes pas tenu de nous communiquer vos données personnelles lorsque vous visitez notre site Internet ScratchOverflow.</div>
                    </div>
                </div>
                <div class="frame">
                    <div class="heading"><span class="mif-palette mif-lg fg-crimson"></span><i> Cookies</i></div>
                    <div class="content">
                        <div class="p-2">Ce site web n'utilise pas de cookies ou autres sytèmes de traceurs.</div>
                    </div>
                </div>
            </div>
        <br><br>

</body>
<script src="../../js/activeMenu.js"></script>

</html>
