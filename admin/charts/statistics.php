<?php
session_start();
include_once '../../requests/select.php';
?>
<!DOCTYPE html>
<html>
<script src="../../dashboard/dashboard.js"></script>

<?php
include_once '../../bases/head.php';

if (!isset($_SESSION["role"]) || $_SESSION["role"] != 1) {

    header("location: ../../connexion/co.php?co=newco");
}
?>

<body>
<?php include_once '../../bases/menu.php'; ?>
<div class="container">
    <h1>Datas powered by ScratchOverflow.</h1>
    <div class="row">
        <div class="cell-3 offset-1">
            <select onchange="callJs(this.selectedIndex)" name="classe" data-role="select" data-filter="false" data-prepend="Sélectionnez une classe :">
                <option value="Global">Global</option>
                <optgroup label="EPSI">
                    <option value="B1">B1</option>
                    <option value="B2">B2</option>
                    <option value="B3">B3</option>
                    <option value="I1">I1</option>
                    <option value="I2">I2</option>
                </optgroup>
                <optgroup label="WIS">
                    <option value="WIS1">WIS 1</option>
                    <option value="WIS2">WIS 2</option>
                    <option value="WIS3">WIS 3</option>
                </optgroup>
            </select>
        </div>
    </div>

    <div id="result">

    </div>
</div>

</body>
<script src="../../js/activeMenu.js"></script>


</html>
