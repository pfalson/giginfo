/**
 * Created by pfalson on 12/29/2016.
 */
function geoFindMe() {
    var output = document.getElementById("currentLocation");

    if (!navigator.geolocation){
        output.innerHTML = "<p>Geolocation is not supported by your browser</p>";
        return;
    }

    function success(position) {
        var lat  = position.coords.latitude;
        var long = position.coords.longitude;

        longitude = $("#longitude");
        longitude.val(long);
        latitude = $("#latitude");
        latitude.val(lat).trigger('change');
    }

    function error() {
        output.innerHTML = "Unable to retrieve your location - check your privacy/location services";
    }

    output.innerHTML = "<p></p><p></p><p></p><p>&nbsp;&nbsp;Determining your location…</p>";

    navigator.geolocation.getCurrentPosition(success, error);
}