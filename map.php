<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Choisir une Position sur la Carte</title>
  <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
  <style>
    #map {
      height: 300px; /* Ajustez la hauteur selon vos besoins */
    }

    .form-div {
      margin-bottom: 15px;
    }

    .geolocation-container {
      display: flex;
      align-items: center;
    }

    #geolocalisation {
      flex: 1;
    }

    #geolocalisation, #updateGeolocation {
      margin-right: 5px; /* Ajustez l'espacement entre l'entrée et le bouton */
    }
  </style>
</head>
<body>

  <h1>Choisir une Position sur la Carte</h1>

  <form action="includes/search.inc.php" method="post">

    <div class="form-div">
      <label for="departure">Départ:</label>
      <div class="geolocation-container">
        <input type="text" name="depart" id="geolocalisation" readonly>
        <button type="button" id="updateGeolocation" onclick="obtenirGeolocalisation()">Mettre à jour</button>
      </div>
    </div>

    <div class="form-div">
      <label for="destination">Destination:</label>
      <div id="map"></div>
      <input type="hidden" name="destination" id="destination">
    </div>

    <!-- Autres champs du formulaire -->
    <div class="form-div">
      <label for="nom">Nom:</label>
      <input type="text" id="nom" name="nom" required>
    </div>

    <button type="submit">Envoyer la demande</button>
  </form>

  <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
  <script>
    var map = L.map('map').setView([0, 0], 2); // Vue par défaut, ajustez les coordonnées et le niveau de zoom
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    map.on('click', function (e) {
      var latitude = e.latlng.lat;
      var longitude = e.latlng.lng;

      // Mettez à jour l'entrée de destination avec les coordonnées sélectionnées
      document.getElementById('destination').value = 'Latitude: ' + latitude + ', Longitude: ' + longitude;
    });
  </script>

  <script>
    function obtenirGeolocalisation() {
      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
          function(position) {
            var latitude = position.coords.latitude;
            var longitude = position.coords.longitude;

            // Mettez à jour le champ de géolocalisation
            document.getElementById("geolocalisation").value = "Latitude: " + latitude + ", Longitude: " + longitude;
          },
          function(error) {
            console.error("Erreur de géolocalisation: " + error.message);
          }
        );
      } else {
        alert("La géolocalisation n'est pas prise en charge par votre navigateur.");
      }
    }
  </script>

</body>
</html>
dhd