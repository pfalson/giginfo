<!-- Typeahead.js Bundle -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.11.1/typeahead.bundle.min.js"></script>
<!-- Typeahead Initialization -->
<script>
    jQuery(document).ready(function ($) {
        // Set the Options for "Bloodhound" suggestion engine
        var engine = new Bloodhound({
            remote: {
                url: '/find?{{ $search_id }}=%QUERY%',
                wildcard: '%QUERY%'
            },
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
            queryTokenizer: Bloodhound.tokenizers.whitespace
        });

        $("#").typeahead({
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
