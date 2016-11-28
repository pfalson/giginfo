<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <script src='https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js'></script>
<script src='/js/openLayers.js'></script>
<script src='https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&key=AIzaSyDCFUSNaAg1mpT8S_GPO-36AmRLNxN7pG4'></script>

<script src='/js/location-picker.js'></script>

<style>
    #map { height: 400px; width:100%;}
    .map-container { margin-top: 10px;}
</style>
</head>
<body>
<div class='location-picker'>
    <input type='text' id='txtAddress' class='form-control' placeholder='Enter your address here' data-type='address' />
    <input type='hidden' id='txtLocation' data-type='location-store' />

    <div class='map-container'>
        <div id='map' data-type='map'></div>
    </div>
</div>
<script>
    $(function(){
        var locationPicker = $('.location-picker').locationPicker({
            locationChanged : function(data){
                $('#output').text(JSON.stringify(data));
            }
        });
    });
</script>
</body>