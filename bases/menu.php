<div data-role="appbar" data-expand-point="md" class="fg-grey menuColor">
    <a href="../../commons/views/home.php" class="brand brandColor no-hover bg-grayWhite"><b>ScratchOverflow</b></a>
    <ul class="app-bar-menu">
        <?php
        if (isset($_SESSION)) {
            echo '<li id="proposeCourse"><a href="../../commons/proposals/proposeCourse.php?proposal=unset">Proposer</a></li>
            <li id="courses"><a href="../../commons/views/courses.php?course=unset">S\'inscrire à un cours</a></li>
            <li id="newCourse"><a href="../../commons/courses/newCourse.php?newc=unset">Donner un cours</a></li>';
            if ($_SESSION["role"] == 1) {
                echo '<li id="admin"><a href="../../admin/pannel/administration.php?action=none">Pannel admin</a></li>';
                echo '<li>
                <a href="#" class="dropdown-toggle"><span class="mif-chart-dots"></span> Stats</a>
                <ul class="d-menu" data-role="dropdown">
                    <li><a href="../../admin/charts/globalCharts.php">Global</a></li>
                    <li><a href="../../admin/charts/chartsB1.php">Recap B1</a></li>
                    <li><a href="../../admin/charts/chartsB2.php">Recap B2</a></li>
                    <li><a href="../../admin/charts/chartsB3.php">Recap B3</a></li>
                    <li><a href="../../admin/charts/chartsI1.php">Recap I1</a></li>
                    <li><a href="../../admin/charts/chartsI2.php">Recap I2</a></li>
                    <li><a href="../../admin/charts/chartsWis1.php">Recap WIS 1</a></li>
                </ul>
            </li>';
            }
            echo '<li>
                <a href="#" class="dropdown-toggle">Compte</a>
                <ul class="d-menu" data-role="dropdown">
                    <li><a href="../../commons/users/profileView.php">Aperçu</a></li>
                    <li class="divider"></li>
                    <li><a href="../../connexion/deco.php">Déconnexion</a></li>
                </ul>
            </li>';
        }
        ?>
    </ul>
</div>
<div class="h-100 p-16">