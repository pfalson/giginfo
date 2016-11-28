<!DOCTYPE html>
<html lang="en">
<head>

    @include('includes.head')

</head>
<body>
<div class="container">

            @yield('base')

</div>

<!-- TODO package scripts into single file -->
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<!--suppress JSUnresolvedLibraryURL -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<!-- required for login cookie checks -->
<!--suppress JSUnresolvedLibraryURL -->
<script src="https://cdn.jsdelivr.net/jquery.cookie/1.4.1/jquery.cookie.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<!-- Latest compiled and minified JavaScript -->
<!--suppress HtmlUnknownTarget -->
<script src="/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<!--suppress JSUnresolvedLibraryURL -->
<script src="http://getbootstrap.com/assets/js/ie10-viewport-bug-workaround.js"></script>

@yield("js-end-of-page")

</body>
</html>
