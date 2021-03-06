<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="metro4:locale" content="fr-FR">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/metro/4.2.49/css/metro-all.css">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/metro/4.2.49/js/metro.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0/dist/Chart.min.js"></script>
    <script src="dashboard/dashboard.js"></script>
    <link rel="shortcut icon" type="image/x-icon" href="medias/squirelMascot.png">
    <title>Dashboard - ScratchOverflow</title>
    <meta name="google-site-verification" content="-FAkp5XQbDa-zN4Kl3UrlzR5WHeu-sbGdiroRytUeWU" />
</head>

<body>
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
    <div class="row">
        <div class="cell-4 offset-1">
            <div id="globalPart"></div>
            <div id="globalChartParticipationDiv"><canvas id="globalChartParticipation" width="100" height="100"></canvas></div>
        </div>
        <div class="cell-4 offset-2">
            <div id="globalMat"></div>
            <div id="globalChartMatiereDiv"><canvas id="globalChartMatiere" width="100" height="100"></canvas></div>
        </div>
    </div>
    <div class="row">
        <div class="cell-5">
            <div id="heuresM"></div>
            <div id="heureMatDiv"><canvas id="heuresMat" width="100" height="100"></canvas></div>
        </div>
        <div class="cell-5 offset-2">
            <div id="partM"></div>
            <div id="partMoisDiv"><canvas id="partMois" width="100" height="100"></canvas></div>
        </div>
    </div>
    <div class="row">
        <div class="cell-5">
            <div id="partI"></div>
            <div id="partInscDiv"><canvas id="partInsc" width="100" height="100"></canvas></div>
        </div>
        <div class="cell-5 offset-2">
            <div id="partP"></div>
            <div id="partPercentDiv"><canvas id="partPercent" width="100" height="100"></canvas></div>
        </div>
    </div>
</body>