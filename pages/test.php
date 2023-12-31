<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script type='text/javascript' src='https://www.bing.com/api/maps/mapcontrol?key=ApE-HNGaFCRDs_bsmYj3Dgak-HaLSYWyN7K35FxHQXjQt8ePrxpy8_uvZoXESwIg&callback=loadMapScenario' async defer></script>
    <style>
        #map {
            height: 300px;
            width: 100%;
        }
    </style>
</head>
<body>
    <div id="map"></div>
    <label for="departureInput">Lieu de départ</label>
    <input type="text" id="departureInput" placeholder="Saisissez le lieu de départ" />

    <script>
        var map;

        function loadMapScenario() {
            map = new Microsoft.Maps.Map(document.getElementById('map'), {
                credentials: 'ApE-HNGaFCRDs_bsmYj3Dgak-HaLSYWyN7K35FxHQXjQt8ePrxpy8_uvZoXESwIg',
                center: new Microsoft.Maps.Location(48.8566, 2.3522),
                zoom: 13
            });

            Microsoft.Maps.loadModule('Microsoft.Maps.AutoSuggest', function () {
                var options = {
                    maxResults: 5,
                    map: map
                };
                var manager = new Microsoft.Maps.AutosuggestManager(options);
                manager.attachAutosuggest('#departureInput', '#searchBoxContainer', selectedSuggestion);
            });

            // Ajoutez un gestionnaire d'événements pour déclencher la recherche lors de la saisie
            document.getElementById('departureInput').addEventListener('input', function () {
                searchLocation();
            });
        }

        function searchLocation() {
            var query = document.getElementById('departureInput').value;
            
            Microsoft.Maps.loadModule('Microsoft.Maps.Search', function () {
                var searchManager = new Microsoft.Maps.Search.SearchManager(map);
                var geocodeRequest = {
                    where: query,
                    callback: geocodeCallback,
                    errorCallback: errorCallback
                };
                searchManager.geocode(geocodeRequest);
            });
        }

        function geocodeCallback(result, userData) {
            if (result && result.results && result.results.length > 0) {
                var location = result.results[0].location;
                var pushpin = new Microsoft.Maps.Pushpin(location);
                map.entities.clear();
                map.entities.push(pushpin);
                map.setView({ center: location, zoom: 13 });
            }
        }

        function errorCallback(e) {
            console.log("Une erreur s'est produite lors de la recherche de lieu :", e);
        }

        function selectedSuggestion(suggestionResult) {
            if (suggestionResult) {
                var location = suggestionResult.location;
                var pushpin = new Microsoft.Maps.Pushpin(location);
                map.entities.clear();
                map.entities.push(pushpin);
                map.setView({ center: location, zoom: 13 });

                document.getElementById('departureInput').value = suggestionResult.formattedSuggestion;
            }
        }
    </script>
</body>
</html>
