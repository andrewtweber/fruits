<!DOCTYPE html>
<html>
<head>
	<title>{$_PAGE['title']}</title>

	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
{if $is_mobile}
	<meta name='viewport' content='width=device-width, initial-scale=1.0, maximum-scale=1.0'/> 
{/if}

	<meta name="AUTHOR" content="Andrew Weber">
	<meta name="COPYRIGHT" content="Copyright (c) {date('Y')} {$_CONFIG['site_name']}">
{if $_PAGE['description']}
	<meta name="DESCRIPTION" content="{htmlspecialchars($_PAGE['description'])}">
{/if}

{if $_PAGE['id'] != 'error'}
	<meta property="og:title" content="{htmlspecialchars($_PAGE['title'])}" />
	<meta property="og:site_name" content="{$_CONFIG['site_name']}" />
	<meta property="og:url" content="http://{$_CONFIG['domain']}/{$_PAGE['url']}" />
	<meta property="og:type" content="article" />
{foreach $_PAGE['og_image'] as $og_image}
	<meta property="og:image" content="{$og_image}" />
{/foreach}
	<meta property="og:description" content="{htmlspecialchars($_PAGE['description'])}" />
	<meta property="fb:admins" content="5611183" />

{/if}
{if is_local()}
	<link rel="stylesheet/less" type="text/css" href="/css/style.less?v={$versions['css']}">
{else}
	<link rel="stylesheet" type="text/css" href="/css/style.css?v={$versions['css']}">
{/if}

	<!--[if lt IE 9]>
	<script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

{if $_PAGE['id'] != 'error'}
	<link rel="canonical" href="http://{$_CONFIG['domain']}/{$_PAGE['url']}" />
{/if}
	<link rel="shortcut icon" href="/favicon.ico">
	<link rel="apple-touch-icon-precomposed" href="/images/touchicon.png">

{include file="custom/analytics.tpl"}
</head>

<body{if $is_mobile} class="mobile"{/if}>

<header>
<h1><a href="/">{$_PAGE['title']}</a></h1>
</header>

<div id="main">
