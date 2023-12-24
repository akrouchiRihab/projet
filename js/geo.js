function obtenirGeolocalisation() {
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(
        function(position) {
          var latitude = position.coords.latitude;
          var longitude = position.coords.longitude;
          var nomPosition = "Position actuelle";

          // Mettez à jour le champ d'entrée avec le nom de la position
          document.getElementById("geolocalisation").value = nomPosition + " (Latitude: " + latitude + ", Longitude: " + longitude + ")";
        },
        function(error) {
          console.error("Erreur de géolocalisation: " + error.message);
        }
      );
    } else {
      alert("La géolocalisation n'est pas prise en charge par votre navigateur.");
    }
  }
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
  