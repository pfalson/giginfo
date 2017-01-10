<?php
$request = request();
$gigs = Gigs::getShows($request);
?>

<head>
    <script type="text/javascript">
        window.onload = function () {
            if (parent) {
                var oHead = document.getElementsByTagName("head")[0];
                var arrStyleSheets = parent.document.getElementsByTagName("style");
//                for (var i = 0; i < arrStyleSheets.length; i++)
//                    oHead.appendChild(arrStyleSheets[i].cloneNode(true));
            }
        }
    </script>
    <link href="/css/bootstrap.min.css" rel="stylesheet">
</head>

<div class="container">
    @inject('inject', 'App\Http\Controllers\IFrameController')

    {!! $inject->getBlade(compact('gigs')) !!}

    @if (method_exists($gigs, 'links'))
        <?php
        $args = $request->all();
        unset($args['page']);
        $gigs->appends($args);
        ?>
        {{ $gigs->links() }}
    @endif
</div>