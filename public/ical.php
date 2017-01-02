<?php
/**
 * Created by PhpStorm.
 * User: pfalson
 * Date: 12/18/2016
 * Time: 7:46 AM
 */
$date = $_GET['date'];
$startTime = $_GET['startTime'];
$endTime = $_GET['endTime'];
$subject = urldecode($_GET['subject']);
$desc = urldecode($_GET['desc']);
$location = urldecode($_GET['location']);
$website= $_GET['website'];
$filename = $_GET['filename'];
$ical = "BEGIN:VCALENDAR
VERSION:2.0
PRODID:-//hacksw/handcal//NONSGML v1.0//EN
BEGIN:VEVENT
UID:" . $website . "
DTSTAMP:" . date('Ymd').'T'. date('His') . "Z
DTSTART;TZID=\"Pacific Standard Time\":".$date."T".$startTime."00
DTEND;TZID=\"Pacific Standard Time\":".$date."T".$endTime."00
SUMMARY:".$subject."
DESCRIPTION:".$desc."
LOCATION:".$location."
END:VEVENT
END:VCALENDAR";
//set correct content-type-header
header('Content-type: text/calendar; charset=utf-8');
header('Content-Disposition: inline; filename="' . $filename . '.ics"');
echo $ical;
exit;
