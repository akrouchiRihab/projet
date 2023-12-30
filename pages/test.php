<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Autres balises meta et liens CSS ici -->

    <!-- Ajoutez le script de l'API Bing Maps avec votre clé API -->
    <script type="text/javascript" src="https://www.bing.com/api/maps/mapcontrol?key=ApE-HNGaFCRDs_bsmYj3Dgak-HaLSYWyN7K35FxHQXjQt8ePrxpy8_uvZoXESwIg"></script>

    <!-- Votre code CSS et titre ici -->
</head>

<body onload="initMap()">
    <!-- Votre contenu HTML existant -->

    <!-- Ajoutez un conteneur pour la carte Bing Maps -->
    <div id="map" style="height: 400px;"></div>

    <!-- Votre code JavaScript existant -->

    <!-- Ajoutez le script JavaScript pour gérer Bing Maps et le calcul de l'itinéraire -->
    <script>
        var map;

        function initMap() {
            map = new Microsoft.Maps.Map(document.getElementById('map'), {
                center: new Microsoft.Maps.Location(0, 0), // Centre de la carte initial
                zoom: 2 // Niveau de zoom initial
            });
        }

        function calculateRoute() {
            var departureTerm = document.getElementById('departureInput').value;
            var arrivalTerm = document.getElementById('arrivalInput').value;

            // Géocodage du lieu de départ
            fetch(`https://dev.virtualearth.net/REST/v1/Locations?q=${departureTerm}&key=VOTRE_CLE_API`)
                .then(response => response.json())
                .then(departureData => {
                    var departureLocation = departureData.resourceSets[0].resources[0].point.coordinates;
                    // Utilisez les coordonnées pour afficher le marqueur sur la carte ou effectuer d'autres opérations
                    console.log('Coordonnées du lieu de départ:', departureLocation);
                    var departurePin = new Microsoft.Maps.Pushpin(new Microsoft.Maps.Location(departureLocation[0], departureLocation[1]));
                    map.entities.push(departurePin);
                })
                .catch(error => {
                    console.error('Erreur lors du géocodage du lieu de départ : ', error);
                });

            // Géocodage du lieu d'arrivée
            fetch(`https://dev.virtualearth.net/REST/v1/Locations?q=${arrivalTerm}&key=VOTRE_CLE_API`)
                .then(response => response.json())
                .then(arrivalData => {
                    var arrivalLocation = arrivalData.resourceSets[0].resources[0].point.coordinates;
                    // Utilisez les coordonnées pour afficher le marqueur sur la carte ou effectuer d'autres opérations
                    console.log('Coordonnées du lieu d\'arrivée:', arrivalLocation);
                    var arrivalPin = new Microsoft.Maps.Pushpin(new Microsoft.Maps.Location(arrivalLocation[0], arrivalLocation[1]));
                    map.entities.push(arrivalPin);
                })
                .catch(error => {
                    console.error('Erreur lors du géocodage du lieu d\'arrivée : ', error);
                });
        }
    </script>
</body>
</html>
