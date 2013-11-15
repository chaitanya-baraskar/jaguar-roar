//var position
function getLocation() {
// Check to see if the browser supports the GeoLocation API.
    if (navigator.geolocation) {
      //  navigator.geolocation.getCurrentPosition(getCoords);

    }
    else{
        console.log("No location services");
    }
}

function getCoords( position ) {

  //  $( "#lat" ).val( position.coords.latitude );
  //  $( "#lng" ).val( position.coords.longitude );
   // alert(position.coords.latitude);
    // $( '#result' ).text( $("#lat").val() + ', ' + $("#long").val() );
}