<!DOCTYPE html>
<html lang="en">
<head>
    <title>Bing Maps Location Selection</title>
    <meta charset="utf-8" />
    <style>
        #myMap {
            position: relative;
            width: 600px;
            height: 400px;
            display: none;
            margin-top: 10%;
        }
    </style>
    <script type='text/javascript' src='http://www.bing.com/api/maps/mapcontrol?callback=GetMap&key=Ah2oWyGHFM1s9k2TY3eiEKR4r5sxVaamEPcCDl8BICrRwD9fulT_KsjML-F09_R6' async defer></script>
<body>
 
    <div id="search-form">
        <label for="destination">Destination:</label>
        <input type="text" id="destination" onclick="showMap()" >

        <label for="current-location">Current Location:</label>
        <input type="text" id="current-location" readonly>

        <label for="seats">Number of Seats:</label>
        <input type="number" id="seats" min="1" value="1">

        <button onclick="searchTrips()">Search</button>
    </div>
    <div id="myMap" style="position:relative;width:600px;height:400px;"></div>
   

</body>
 <script type='text/javascript'>
    var map;
    var searchManager;

    
        function GetMap() {
        map = new Microsoft.Maps.Map('#myMap', {
            credentials: 'Ah2oWyGHFM1s9k2TY3eiEKR4r5sxVaamEPcCDl8BICrRwD9fulT_KsjML-F09_R6',
            center: new Microsoft.Maps.Location(0, 0),
            zoom: 2
        });

        Microsoft.Maps.loadModule('Microsoft.Maps.AutoSuggest', function () {
            var options = {
                maxResults: 4,
                map: map
            };
            searchManager = new Microsoft.Maps.AutosuggestManager(options);
        });

        // ... (existing code)

        // Add event listener for map click
        Microsoft.Maps.Events.addHandler(map, 'click', function (e) {
            var point = new Microsoft.Maps.Point(e.getX(), e.getY());
            var loc = e.target.tryPixelToLocation(point);

            // Reverse geocode to get the address of the clicked location
            Microsoft.Maps.Location.reverseGeocode(loc, 'AqVY6zwaJ7oOe9iXs0xDdHJ2ysZ07ay2n0Rcf4mITb7HdtNdBQv5cZlTTq8awc8d', function (result) {
                if (result && result.resourceSets && result.resourceSets.length > 0) {
                    var address = result.resourceSets[0].resources[0].address;
                    var locationString = address.locality || address.adminDistrict || '';

                    // Update the destination input field with the selected location
                    document.getElementById('destination').value = locationString;
                }
            });
        });

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function (position) {
                var lat = position.coords.latitude;
                var lon = position.coords.longitude;

                fetch(`https://dev.virtualearth.net/REST/v1/Locations/${lat},${lon}?key=Ah2oWyGHFM1s9k2TY3eiEKR4r5sxVaamEPcCDl8BICrRwD9fulT_KsjML-F09_R6`)
                    .then(response => response.json())
                    .then(data => {
                        var cityName = data.resourceSets[0].resources[0].address.locality || data.resourceSets[0].resources[0].address.adminDistrict;
                        document.getElementById('current-location').value = cityName;
                    })
                    .catch(error => {
                        console.error('Error getting address:', error.message);
                    });
            }, function (error) {
                console.error('Error getting geolocation:', error.message);
            });
        } else {
            console.error('Geolocation is not supported by this browser.');
        }
    }
    
    function showMap() {
        document.getElementById('myMap').style.display = 'block';
    }

    function searchTrips() {
        alert('Searching for trips to ' + document.getElementById('destination').value +
            ' from ' + document.getElementById('current-location').value +
            ' with ' + document.getElementById('seats').value + ' available seats.');

        document.getElementById('myMap').style.display = 'none';
    }


</script>
</html>
