/**
 * Created by pfalson on 12/29/2016.
 */
function geoFindMe(getCity) {
    var output = document.getElementById("currentLocation");

    if (!navigator.geolocation) {
        output.innerHTML = "<p>Geolocation is not supported by your browser</p>";
        return;
    }

    function success(position) {
        var lat = position.coords.latitude;
        var long = position.coords.longitude;

        if (getCity) {
            $.getJSON('https://giginfo.org/getCityFromPosition',
                {
                    longitude: long,
                    latitude: lat
                },
                function (data) {
                if (!data.error) {
                    city_id = $("input[name=city_id]");
                    city_id.val(data.id);
                    state_name = $("input[name=state_name]");
                    state_name.val(data.stateName);
                    city_name = $("input[name=city_name]");
                    city_name.val(data.name).trigger('change');
                }
            });
        }

        longitude = $("#longitude");
        longitude.val(long);
        latitude = $("#latitude");
        latitude.val(lat).trigger('change');
    }

    function error() {
        output.innerHTML = "Unable to determine your exact location - check your privacy/location settings";
        latitude = $("#latitude");
        longitude = $("#longitude");
        try {
            $.getJSON('https://giginfo.org/getLocation', function (data, latitude, longitude) {
                if (!data.error) {
                    $("#distance").val(1000);
                    longitude.val(data.geoplugin_longitude);
                    latitude.val(data.geoplugin_latitude).trigger('change');
                }
            });
        } catch (e) {
        }

        if (latitude.val().length === 0) {
            longitude.val(41);
            latitude.val(-122).trigger('change');
        }
    }

    output.innerHTML = "<p></p><p></p><p></p><p>&nbsp;&nbsp;Determining your location…</p>";

    navigator.geolocation.getCurrentPosition(success, error);
}