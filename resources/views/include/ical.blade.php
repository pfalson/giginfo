<?php
list($date, $time) = explode(' ', $gig->start);
$date = str_replace("-", "", $date);
$timestart = substr(str_replace(":", "", $time), 0, 4);
list($dateend, $timeend) = explode(' ', $gig->finish);
$timeend = substr(str_replace(":", "", $timeend), 0, 4);
$desc = $gig->description;
$location = htmlspecialchars($gig->address);
$filename = htmlspecialchars($gig->artistName . ' - ' . $gig->name);
$ical = 'BEGIN:VCALENDAR
VERSION:2.0
PRODID:-//hacksw/handcal//NONSGML v1.0//EN
BEGIN:VEVENT
UID:' . $gig->artistWebsite . '
DTSTAMP:' . date('Ymd') . 'T' . date('His') . 'Z
DTSTART;TZID="Pacific Standard Time":' . $date . 'T' . $timestart . '00
DTEND;TZID="Pacific Standard Time":' . $date . 'T' . $timeend . '00
SUMMARY:' . $gig->name . '
DESCRIPTION:' . $desc . '
LOCATION:' . $location . '
END:VEVENT
END:VCALENDAR';
header('Content-type: text/calendar; charset=utf-8');
header('Content-Disposition: inline; filename="' . $filename . '.ics"');
echo $ical;
?>