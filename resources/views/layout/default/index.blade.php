<!DOCTYPE html>
<html>
  <head>
    <title>Simple click event</title>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
    <style>
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
      #map {
        height: 100%;
      }
.controls {
  margin-top: 10px;
  border: 1px solid transparent;
  border-radius: 2px 0 0 2px;
  box-sizing: border-box;
  -moz-box-sizing: border-box;
  height: 32px;
  outline: none;
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
}

#pac-input {
  background-color: #fff;
  font-family: Roboto;
  font-size: 15px;
  font-weight: 300;
  margin-left: 12px;
  padding: 0 11px 0 13px;
  text-overflow: ellipsis;
  width: 300px;
}

#pac-input:focus {
  border-color: #4d90fe;
}

.pac-container {
  font-family: Roboto;
}

#type-selector {
  color: #fff;
  background-color: #4d90fe;
  padding: 5px 11px 0px 11px;
}

#type-selector label {
  font-family: Roboto;
  font-size: 13px;
  font-weight: 300;
}

    </style>
    <title>Places Searchbox</title>
    <style>
      #target {
        width: 345px;
      }
    </style>


  </head>
  <body>
    <input id="pac-input" class="controls" type="text" placeholder="Search Box">
    <div id="map"></div>
    <input type="hidden" value="10.765415" id="lat">
    <input type="hidden" value="106.681731" id="lng">
    <script>
    if(navigator.geolocation) {
      browserSupportFlag = true;
      navigator.geolocation.getCurrentPosition(function(position) {
        document.getElementById('lat').value=position.coords.latitude;
        document.getElementById('lng').value=position.coords.longitude;
        initMap();
      }, function() {
        handleNoGeolocation(browserSupportFlag);
      });
    }
    // Browser doesn't support Geolocation
    else {
      browserSupportFlag = false;
      handleNoGeolocation(browserSupportFlag);
    }

    function handleNoGeolocation(errorFlag) {
      if (errorFlag == true) {
        alert("Geolocation service failed.");
      } else {
        alert("Your browser doesn't support geolocation. We've placed you in HCM VietNam.");
      }
    }

    function getAddress(lat, lng){
      var link = 'http://maps.googleapis.com/maps/api/geocode/json?latlng=' + lat + ',' + lng + '&sensor=true';
      var adress = '';
      $.getJSON(link, function (data) {
          adress = data.results[0].formatted_address;
          infowindow.setContent("<span id='address'>"+adress+"</span>");
      });
    }

    function initMap() {
      var marker = '';
      infowindow = new google.maps.InfoWindow();
      var la = Number(document.getElementById('lat').value);
      var ln = Number(document.getElementById('lng').value);

      var myLatlng = {lat: la, lng: ln};
      var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 18,
        center: myLatlng
      });

        marker = new google.maps.Marker({
        position: myLatlng,
        map: map,
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        draggable:true,
      });
      getAddress(la, ln);
      infowindow.open(map, marker);
      google.maps.event.addListener(marker,'dragend',function(event) {
          lat = event.latLng.lat();
          lon = event.latLng.lng();

          document.getElementById('lat').value = lat;
          document.getElementById('lng').value = lon;
          getAddress(lat, lon);
        });

      // Create the search box and link it to the UI element.
      if(!$("#pac-input").length){
        $("#map").after('<input id="pac-input" class="controls" type="text" placeholder="Search Box">');
      }
      var input = document.getElementById('pac-input');
      var searchBox = new google.maps.places.SearchBox(input);
      map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

      // Bias the SearchBox results towards current map's viewport.
      map.addListener('bounds_changed', function() {
        searchBox.setBounds(map.getBounds());
      });

      // [START region_getplaces]
      // Listen for the event fired when the user selects a prediction and retrieve
      // more details for that place.
      searchBox.addListener('places_changed', function() {
        var places = searchBox.getPlaces();

        if (places.length == 0) {
          return;
        }
        // Clear out the old markers.
        marker.setMap(null);

        // For each place, get the icon, name and location.
        var bounds = new google.maps.LatLngBounds();
        places.forEach(function(place) {
          var icon = {
            url: place.icon,
            size: new google.maps.Size(71, 71),
            origin: new google.maps.Point(0, 0),
            anchor: new google.maps.Point(17, 34),
            scaledSize: new google.maps.Size(25, 25)
          };

            marker = new google.maps.Marker({
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            map: map,
            position: place.geometry.location,
            draggable:true,
          });
          getAddress(la, ln);
          infowindow.open(map, marker);
          google.maps.event.addListener(marker,'dragend',function(event) {
            lat = event.latLng.lat();
            lon = event.latLng.lng();

            document.getElementById('lat').value = lat;
            document.getElementById('lng').value = lon;
            getAddress(lat, lon);
        });

          if (place.geometry.viewport) {
            // Only geocodes have viewport.
            bounds.union(place.geometry.viewport);
          } else {
            bounds.extend(place.geometry.location);
          }
        });
        map.fitBounds(bounds);
      });
    }

    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDi3RrxLSXmrJUoSXnJGg2UjnFdxuV5gTM&signed_in=true&libraries=places&callback=initMap" async defer>
    </script>
  </body>
</html>