/**
 * Created by pfalson on 12/18/2016.
 */
$(document).ready(function() {

    $('.addtocal').AddToCal({
        // ical and vcal require an ics or vcs file to be served.
        // Disable these features if required (as a result the 30boxes, iCal and vCalendar menu links will not appear)
        icalEnabled:true,
        vcalEnabled:true,

        getEventDetails: function( element ) {
            var
                dtstart_element = element.find('.dtstart'), start,
                dtend_element = element.find('.dtend'), end,
                title_element = element.find('.summary'), title,
                where_element = element.find('.where'), where,
                details_element = element.find('.description'), details,
                ical_element = element.find('.ical'), ical;

            // in this demo, we attempt to get hCalendar attributes or otherwise just dummy the values
            start = dtstart_element.length ? dtstart_element.attr('title') : new Date();
            if (dtend_element.length) {
                end = dtend_element.attr('title');
            } else {
                end = new Date();
                end.setTime(end.getTime() + 60 * 60 * 1000);
            }
            title = title_element.length ? title_element.html() : element.attr('id');
            details = details_element.length ? details_element.html() : element.html();
            where = where_element.length ? where_element.html() : '';
            ical = ical_element.attr('href');

            // return the required event structure
            return {
                webcalurl: null,
                icalurl: ical,
                vcalurl: null,
                start: start,
                end: end,
                title: title,
                details: details,
                location: where,
                url: null
            };
        }
    });

});
