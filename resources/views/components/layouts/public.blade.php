<!doctype html>
<html lang="en" class="h-full bg-gray-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Houssist</title>
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
    @vite('resources/sass/app.scss')
</head>
<body lass="h-full">
<div class="relative isolate bg-white">
    {{$slot}}
</div>
@vite('resources/js/app.js')
</body>
</html>
