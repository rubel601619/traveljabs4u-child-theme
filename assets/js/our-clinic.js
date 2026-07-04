(function ($) {
  'use strict';

  var map = null;
  var markers = [];
  var infoWindows = [];
  var debounceTimer = null;
  var allClinics = pmcInitialClinics || [];
  var remoteResults = [];
  var usingRemote = false;
  var remoteCache = {};
  var currentXhr = null;
  var minChars = 2;
  var localMatchThreshold = 3;
  var mapInitRetries = 0;

  function initMap() {
    if (typeof google === 'undefined' || !google.maps || !google.maps.Map) {
      mapInitRetries++;
      if (mapInitRetries < 50) {
        setTimeout(initMap, 200);
      }
      return;
    }

    map = new google.maps.Map(document.getElementById('clinicMap'), {
      zoom: 10,
      center: { lat: 51.5074, lng: -0.1278 },
      mapTypeId: google.maps.MapTypeId.ROADMAP,
    });

    addMarkers(allClinics);
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
      if (c.postcode) html += '<p class="clinic-postcode">' + c.postcode + '</p>';
      if (c.phone) html += '<p class="clinic-phone"><a href="tel:' + c.phone + '">' + c.phone + '</a></p>';
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

  function renderAndMap(clinics) {
    renderClinicList(clinics);
    addMarkers(clinics);
  }

  function localMatches(query) {
    if (!query) return [];
    var q = query.toLowerCase();
    return allClinics.filter(function (c) {
      return c.title.toLowerCase().indexOf(q) !== -1 ||
             (c.address && c.address.toLowerCase().indexOf(q) !== -1) ||
             (c.postcode && c.postcode.toLowerCase().indexOf(q) !== -1);
    });
  }

  function searchRemote(query) {
    if (remoteCache[query]) {
      remoteResults = remoteCache[query];
      usingRemote = true;
      renderAndMap(remoteResults);
      return;
    }

    if (currentXhr) {
      currentXhr.abort();
    }

    currentXhr = $.ajax({
      url: pmcClinicVars.ajaxUrl,
      type: 'POST',
      data: {
        action: 'search_clinics',
        search: query,
        nonce: pmcClinicVars.nonce,
      },
      success: function (clinics) {
        remoteResults = clinics;
        remoteCache[query] = clinics;
        usingRemote = true;
        renderAndMap(clinics);
      },
    });
  }

  function doSearch(query) {
    if (currentXhr) {
      currentXhr.abort();
      currentXhr = null;
    }

    if (query.length < minChars) {
      usingRemote = false;
      remoteResults = [];
      renderAndMap(allClinics);
      return;
    }

    usingRemote = false;
    var local = localMatches(query);

    if (local.length >= localMatchThreshold) {
      renderAndMap(local);
    } else {
      searchRemote(query);
    }
  }

  $(document).ready(function () {
    renderClinicList(allClinics);
    initMap();

    $('#clinicSearch').on('input', function () {
      clearTimeout(debounceTimer);
      var query = $(this).val().trim();
      debounceTimer = setTimeout(function () {
        doSearch(query);
      }, 300);
    });

    $('#clinicSearch').on('keydown', function (e) {
      if (e.keyCode === 13) {
        e.preventDefault();
        clearTimeout(debounceTimer);
        doSearch($(this).val().trim());
      }
    });
  });

})(jQuery);
