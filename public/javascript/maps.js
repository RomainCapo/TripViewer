function initMap() {
  let map = new google.maps.Map(document.getElementById('map'), {
    center: {lat: 46.992, lng: 6.918},
    zoom: 2
  });

  $.ajax({
    type: 'POST',
    url: 'ajax',
    dataType: 'json'
  }).done(function(data){
    for(let key in data)
    {
      let markerColor;
      if(data[key]['trip_state'] == "realized")
      {
        markerColor = 'http://maps.google.com/mapfiles/ms/icons/red-dot.png';
      }
      else if (data[key]['trip_state'] == "planned")
      {
        markerColor = 'http://maps.google.com/mapfiles/ms/icons/blue-dot.png';
      }
      else if (data[key]['trip_state'] == "reserved")
      {
        markerColor = 'http://maps.google.com/mapfiles/ms/icons/green-dot.png';
      }

      let contentString = '<div id="content">' +
      '<h2>' + data[key]['dest'] + '</h2>' + 
      '<p><ul style="list-style:none;"><li><strong>Trip name : </strong>' + data[key]['name'] +  '</li>' +
      '<li><strong>Trip description : </strong>' + data[key]['description'] +  '</li>' +
      '<li><strong>Departure place : </strong>' + data[key]['departure'] +  '</li>' +
      '<li><strong>Departure date : </strong>' + data[key]['departure_date'] +  '</li>' +
      '<li><strong>Return date : </strong>' + data[key]['return_date'] +  '</li>' +
      '<li><strong>Km traveled : </strong>' + data[key]['km_traveled'] +  '</li>' +
      '<li><strong>Total price : </strong>' + data[key]['total_price'] +  '</li>' +
      '<li><strong>Number of people : </strong>' + data[key]['number_people'] +  '</li>' +
      '</p></ul></div>';

      let infoWindow = new google.maps.InfoWindow({
          content: contentString
        });

      let marker = new google.maps.Marker({
          position: new google.maps.LatLng(data[key]['lat'], data[key]['lng']),
          map: map,
          animation:google.maps.Animation.DROP,
          icon: markerColor
        });
        marker.addListener('click', function() {
          infoWindow.open(map, marker);
        });
    }
  });
}
