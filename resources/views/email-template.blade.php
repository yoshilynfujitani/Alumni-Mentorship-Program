<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <div class="container" style="padding: 1rem; background: #f5f5f5;">
        <p>Good Day! {{$userName}}</p>
        <p>
           You've been invited as a mentor! Click the link below to confirm your participation.
        </p>
        <a href="http://studentportal.test?code={{$code}}">Accept Invitation</a>
    </div>
</body>
</html>