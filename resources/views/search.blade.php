<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel and Typeahead Tutorial</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<h1>Laravel and Typeahead Tutorial</h1>
<hr>
<form class="typeahead" role="search">
    <div class="form-group">
        <input id="q_id" name="q_id" value="">
        <input type="search" id="q" name="q" class="search-input form-control" placeholder="Search" autocomplete="off">
        {{ Form::text('', '', ['id' => 'another_id', 'placeholder' => 'Enter name'])}}
    </div>
</form>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins  and Typeahead) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<!-- Bootstrap JS -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<!-- Typeahead.js Bundle -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.11.1/typeahead.bundle.min.js"></script>
<!-- Typeahead Initialization -->
<script>
    jQuery(document).ready(function ($) {
        // Set the Options for "Bloodhound" suggestion engine
        var engine = new Bloodhound({
            remote: {
                url: '/find?q=%QUERY%',
                wildcard: '%QUERY%'
            },
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
            queryTokenizer: Bloodhound.tokenizers.whitespace
        });

        $("#q").typeahead({
            hint: true,
            autoSelect: true,
            highlight: true,
            minLength: 1
        }, {
            source: engine.ttAdapter(),

            // This will be appended to "tt-dataset-" to form the class name of the suggestion menu.
            name: 'id',
            displayKey: 'name',
            autoSelect: true,
            limit: 15,
            // the key from the array we want to display (name,id,email,etc...)
            templates: {
                empty: [
                    '<div class="list-group search-results-dropdown"><div class="list-group-item">Nothing found.</div></div>'
                ],
                suggestion: function (data) {
                    return '<div class="list-group-item">' + data.name + '</div>'
                }
            }
        }).bind('typeahead:selected', function (ev, suggestion) {
            $("#q_id").val(suggestion.id);
        });
    });

    //Javascript
    $(function()
    {
        $( "#another_id" ).autocomplete({
            source: "search/autocomplete",
            minLength: 3,
            select: function(event, ui) {
                $('#another_id').val(ui.item.value);
            }
        });
    });
</script>
</body>
</html>