<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

        <title>{{ $siteSetting['website_title']['cd_value'] ?? '' }}</title>

        <meta name="description" content="{{$siteSetting['website_name']['cd_value'] ?? '' }}">
        <meta name="author" content="thanhtrungit.net">

        <!-- Open Graph Meta -->
        <meta property="og:title" content="{{$siteSetting['website_title']['cd_value'] ?? '' }}">
        <meta property="og:site_name" content="{{$siteSetting['website_description']['cd_value'] ?? '' }}">
        <meta property="og:description" content="{{$siteSetting['website_description']['cd_value'] ?? '' }}">
        <meta property="og:type" content="website">
        <meta property="og:url" content="">
        <meta property="og:image" content="{{ $siteSetting['image_share']['cd_value'] ?? '' }}">
        <!-- Icons -->
        <!-- The following icons can be replaced with your own, they are used by desktop and mobile browsers -->
        <link rel="shortcut icon" href="{{ $siteSetting['favicon']['cd_value'] ?? '' }}">
        <link rel="icon" type="image/png" sizes="192x192" href="{{ $siteSetting['favicon']['cd_value'] ?? '' }}">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ $siteSetting['favicon']['cd_value'] ?? '' }}">
        <!-- END Icons -->
        <!-- Stylesheets -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito+Sans:300,400,400i,600,700">
        <link rel="stylesheet" id="css-main" href="{{asset('assets/css/dashmix.min.css')}}">
        <link rel="stylesheet" id="css-main" href="{{asset('assets/css/custom.css')}}">
        {!! $siteSetting['gg_analytics']['cd_value'] ?? '' !!}
    </head>
    <body>
