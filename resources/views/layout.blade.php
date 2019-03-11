<!DOCTYPE html>
<html>
<head>
    <title>{{ $_PAGE['title'] ?? 'What Fruits Are in Season' }}</title>

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    @if ($is_mobile)
    <meta name='viewport' content='width=device-width, initial-scale=1.0, maximum-scale=1.0'/>
    @endif

    <meta name="AUTHOR" content="Andrew Weber">
    <meta name="COPYRIGHT" content="Copyright (c) {{ date('Y') }} {{  getenv('SITE_NAME') }}">
    @if (isset($_PAGE['description']))
    <meta name="DESCRIPTION" content="{{ $_PAGE['description'] }}">
    @endif

    @if ($_PAGE['id'] ?? null != 'error')
    <meta property="og:title" content="{{ $_PAGE['title'] ?? 'What Fruits Are in Season' }}" />
    <meta property="og:site_name" content="{{  getenv('SITE_NAME') }}" />
    <meta property="og:url" content="http://{{ getenv('DOMAIN') . '/' . ($_PAGE['url'] ?? '') }}" />
    <meta property="og:type" content="article" />
    @foreach ($_PAGE['og_image'] ?? [] as $og_image)
    <meta property="og:image" content="{{ $og_image }}" />
    @endforeach
    <meta property="og:description" content="{{ $_PAGE['description'] ?? '' }}" />
    <meta property="fb:admins" content="5611183" />

    @endif
    <link rel="stylesheet" type="text/css" href="/css/style.css?v={{ $versions['css'] }}">

    <!--[if lt IE 9]>
    <script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    @if ($_PAGE['id'] ?? null != 'error')
    <link rel="canonical" href="http://{{ getenv('DOMAIN') . '/' . ($_PAGE['url'] ?? '') }}" />
    @endif
    <link rel="shortcut icon" href="/favicon.ico">
    <link rel="apple-touch-icon-precomposed" href="/images/touchicon.png">

    @include('custom.analytics')
</head>

<body class="{{ $is_mobile ? 'mobile' : '' }}">

<header>
    <h1><a href="/">{{ $_PAGE['title'] ?? 'What Fruits Are in Season' }}</a></h1>
</header>

<div id="main">

    @yield('content')

</div>

<footer>

    <a href="http://andrewtweber.com/" target="_blank"><span>&copy; {{ date('Y') }} </span>Andrew Weber</a>
    &bull; <a href="/about">About</a>
    &bull; @if ($smaller)
        <a href="/{{ $_PAGE['url'] ?? '' }}?larger" rel="nofollow">Larger<span> Images</span></a>
    @else
        <a href="/{{  $_PAGE['url'] ?? '' }}?smaller" rel="nofollow">Smaller<span> Images</span></a>
    @endif

    @if ($is_mobile)
    <div id="add">
        Add it to your Home screen!<br>
        <img src="/images/add.png" width="33" height="27" alt="Add">
    </div>
    @endif

</footer>

</body>
</html>
