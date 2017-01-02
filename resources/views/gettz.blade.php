<!DOCTYPE html>
<html dir="ltr" lang="en-US">

<head>
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="/js/jstz.min.js"></script>
</head>

<body>

<script type="text/javascript">
   $(document).ready(function () {
      var tz = jstz.determine();
      var tzname = 'UTC';

      if (typeof (tz) === 'undefined') {
         tzname = 'UTC';
      }
      else {
         tzname = tz.name();
      }
      window.location.href = "tzpostdetect?_tz="+tzname;
   });
</script>

</body>

</html>