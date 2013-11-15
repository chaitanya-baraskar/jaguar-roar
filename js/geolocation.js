//var position
function getLocation() {
// Check to see if the browser supports the GeoLocation API.
    alert("You are here");
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(getCoords);

    }
    else{
        alert("Nooooooo!!!!!");
        console.log("No location services");
    }
}

function getCoords( position ) {

    $( "#lat" ).val( position.coords.latitude );
    $( "#lng" ).val( position.coords.longitude );

    // $( '#result' ).text( $("#lat").val() + ', ' + $("#long").val() );
}