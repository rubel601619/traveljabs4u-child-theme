(function ($) {
  'use strict';

  var map = null;
  var markers = [];
  var infoWindows = [];
  var allClinics = pmcInitialClinics || [];
  var userLocation = { lat: 51.5074, lng: -0.1278 };

  function haversineDistance(lat1, lng1, lat2, lng2) {
    var R = 6371;
    var dLat = (lat2 - lat1) * Math.PI / 180;
    var dLng = (lng2 - lng1) * Math.PI / 180;
    var a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
            Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
            Math.sin(dLng / 2) * Math.sin(dLng / 2);
    var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
    return R * c;
  }

  function getUserLocation(callback) {
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(function (pos) {
        userLocation = { lat: pos.coords.latitude, lng: pos.coords.longitude };
        if (callback) callback(userLocation);
      }, function () {
        fetchLocationByIP(callback);
      });
    } else {
      fetchLocationByIP(callback);
    }
  }

  function fetchLocationByIP(callback) {
    $.getJSON('https://ipinfo.io/json').done(function (data) {
      if (data && data.loc) {
        var parts = data.loc.split(',');
        var lat = parseFloat(parts[0]);
        var lng = parseFloat(parts[1]);
        if (!isNaN(lat) && !isNaN(lng)) {
          userLocation = { lat: lat, lng: lng };
          if (callback) callback(userLocation);
        }
      }
    });
  }

  function attachDistances(clinics) {
    if (!userLocation) return;
    for (var i = 0; i < clinics.length; i++) {
      var c = clinics[i];
      if (c.latitude != null && c.longitude != null && !isNaN(c.latitude) && !isNaN(c.longitude)) {
        c.distance = haversineDistance(userLocation.lat, userLocation.lng, c.latitude, c.longitude);
      } else {
        c.distance = null;
      }
    }
  }

  function loadGoogleMaps(callback) {
    if (typeof google !== 'undefined' && google.maps && google.maps.Map) {
      callback();
      return;
    }
    if (!pmcClinicVars.apiKey) return;
    if (document.querySelector('script[src*="maps.googleapis.com/maps/api"]')) {
      var check = setInterval(function () {
        if (typeof google !== 'undefined' && google.maps && google.maps.Map) {
          clearInterval(check);
          callback();
        }
      }, 200);
      setTimeout(function () { clearInterval(check); }, 15000);
      return;
    }
    var script = document.createElement('script');
    script.src = 'https://maps.googleapis.com/maps/api/js?key=' + pmcClinicVars.apiKey;
    script.async = true;
    script.onload = callback;
    document.head.appendChild(script);
  }

  function initMap() {
    loadGoogleMaps(function () {
      map = new google.maps.Map(document.getElementById('clinicMap'), {
        zoom: 10,
        center: { lat: 51.5074, lng: -0.1278 },
        mapTypeId: google.maps.MapTypeId.ROADMAP,
      });
      addMarkers(allClinics);
    });
  }

  function clearMarkers() {
    for (var i = 0; i < markers.length; i++) {
      markers[i].setMap(null);
    }
    markers = [];

    for (var j = 0; j < infoWindows.length; j++) {
      infoWindows[j].close();
    }
    infoWindows = [];
  }

  function addMarkers(clinics) {
    if (!map) return;

    clearMarkers();

    if (clinics.length === 0) return;

    var bounds = new google.maps.LatLngBounds();

    for (var i = 0; i < clinics.length; i++) {
      var c = clinics[i];
      if (c.latitude == null || c.longitude == null || isNaN(c.latitude) || isNaN(c.longitude)) continue;

      var position = { lat: c.latitude, lng: c.longitude };
      bounds.extend(position);

      var marker = new google.maps.Marker({
        position: position,
        map: map,
        title: c.title,
        animation: google.maps.Animation.DROP,
      });

      var content = '<div class="gm-info-window">' +
        (c.thumbnail ? '<img src="' + c.thumbnail + '" alt="' + c.title + '" class="gm-thumb">' : '') +
        '<strong>' + c.title + '</strong><br>' +
        (c.address ? c.address + '<br>' : '') +
        (c.postcode ? c.postcode + '<br>' : '') +
        (c.phone ? '<a href="tel:' + c.phone + '">' + c.phone + '</a><br>' : '') +
        '<a href="' + c.link + '">View details</a>' +
        '</div>';

      var infoWindow = new google.maps.InfoWindow({ content: content });
      infoWindows.push(infoWindow);

      marker.addListener('click', (function (iw, m) {
        return function () {
          iw.open(map, m);
        };
      })(infoWindow, marker));

      markers.push(marker);
    }

    if (clinics.length === 1 && markers.length === 1) {
      map.setCenter(markers[0].getPosition());
      map.setZoom(14);
    } else if (markers.length > 1) {
      map.fitBounds(bounds);
    }
  }

  function renderClinicList(clinics) {
    var $list = $('#clinicList');
    if (clinics.length === 0) {
      $list.html('<p class="text-muted">No clinics found.</p>');
      return;
    }

    attachDistances(clinics);

    var html = '';
    for (var i = 0; i < clinics.length; i++) {
      var c = clinics[i];
      html += '<div class="clinic-item" data-lat="' + c.latitude + '" data-lng="' + c.longitude + '">';
      if (c.thumbnail) {
        html += '<div class="clinic-thumb"><img src="' + c.thumbnail + '" alt="' + c.title + '"></div>';
      }
      html += '<div class="clinic-info">';
      html += '<h3><a href="' + c.link + '">' + c.title + '</a></h3>';
      if (c.address) html += '<p class="clinic-address">' + c.address + '</p>';
      if (c.postcode) {
        html += '<p class="clinic-postcode">' + c.postcode;
        if (c.distance != null) {
          html += '<span class="clinic-distance">' + c.distance.toFixed(1) + ' km</span>';
        }
        html += '</p>';
      } else if (c.distance != null) {
        html += '<p class="clinic-postcode"><span class="clinic-distance">' + c.distance.toFixed(1) + ' km</span></p>';
      }
      
      html += '</div></div>';
    }
    $list.html(html);

    $list.find('.clinic-item').on('click', function () {
      var lat = parseFloat($(this).data('lat'));
      var lng = parseFloat($(this).data('lng'));
      if (map && lat && lng) {
        map.setCenter({ lat: lat, lng: lng });
        map.setZoom(16);
      }
    });
  }

  function localMatches(query) {
    if (!query) return allClinics;
    var q = query.toLowerCase();
    return allClinics.filter(function (c) {
      return c.title.toLowerCase().indexOf(q) !== -1 ||
             (c.address && c.address.toLowerCase().indexOf(q) !== -1) ||
             (c.postcode && c.postcode.toLowerCase().indexOf(q) !== -1);
    });
  }

  function reRender() {
    var query = $('#clinicSearch').val().trim();
    var matches = localMatches(query);
    renderClinicList(matches);
    addMarkers(matches);
  }

  $(document).ready(function () {
    renderClinicList(allClinics);
    initMap();

    function requestLocation() {
      getUserLocation(function () {
        reRender();
      });
    }

    requestLocation();

    $('#clinicSearch').on('focus', function () {
      requestLocation();
    });

    $('#clinicSearch').on('input', function () {
      reRender();
    });
  });

})(jQuery);
