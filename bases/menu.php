<div data-role="appbar" data-expand-point="md" class="fg-grey menuColor">
    <a href="../../commons/views/home.php" class="brand brandColor no-hover bg-grayWhite"><b>ScratchOverflow</b></a>
    <ul class="app-bar-menu">
        <?php
        if (isset($_SESSION)) {
            echo '<li id="proposeCourse"><a href="../../commons/proposals/proposeCourse.php?proposal=unset">Proposer</a></li>
            <li id="courses"><a href="../../commons/views/courses.php?course=unset">S\'inscrire à un cours</a></li>
            <li id="newCourse"><a href="../../commons/courses/newCourse.php?newc=unset">Donner un cours</a></li>
            <li id="forum"><a href="../../commons/forum/questionForum.php?forum=unset">Forum</a></li>';

            if ($_SESSION["role"] == 1) {
                // echo '<li id="admin"><a href="../../admin/pannel/administration.php?action=none">Pannel admin</a></li>';
                echo '<li>
                <a href="#" class="dropdown-toggle">Administration</a>
                <ul class="d-menu" data-role="dropdown">
                    <li><a href="../../admin/pannel/managementUser.php">Gestion USER</a></li>
                    <li><a href="../../admin/pannel/managementCourse.php">Gestion COURS</a></li>
                    <li><a href="../../admin/pannel/managementMatiere.php">Gestion MATIERE</a></li>
                    <li><a href="../../admin/pannel/managementSchool.php">Gestion ECOLE</a></li>
                </ul>
            </li>';
                echo '<li><a href="../../admin/charts/statistics.php">Statistiques</a></li>';
            }
            echo '<li>
                <a href="#" class="dropdown-toggle">' . selectPrenomById($_SESSION['id_personne']) . ' ' . selectNomById($_SESSION['id_personne']) . '</a>
                <ul class="d-menu" data-role="dropdown">
                    <li><a href="../../commons/users/profileView.php">Mon compte</a></li>
                    <li><a href="../../commons/users/coursView.php">Visu des cours</a></li>
                    <li class="divider"></li>
                    <li><a href="../../connexion/deco.php">Déconnexion</a></li>
                </ul>
            </li>';
        }
        ?>
    </ul>
</div>
<div class="h-100 p-16">