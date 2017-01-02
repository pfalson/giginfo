/**
 * Created by pfalson on 1/1/2017.
 */
function getTimeZone(lat, lng, key) {
    var googleApi = "https://maps.googleapis.com/maps/api/timezone/json?location=";
    var URL = googleApi + lat + ',' + lng + '&timestamp=0&key=' + key;
    var tz = null;
    $.ajax({
        url: URL
    }).done(function (response) {
        if (response.timeZoneId != null) {
            tz = response.timeZoneId;
        }
    });

    return tz;
}