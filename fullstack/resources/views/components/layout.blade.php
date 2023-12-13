<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">

    <title>
        {{$title}}
    </title>

</head>
<body>
    <h1>UTA Interface Layout  {{$title}}</h1>
    {{$content}}
</body>
</html>
