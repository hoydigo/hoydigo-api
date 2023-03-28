<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>hoydigo</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Arvo&family=Roboto&display=swap" rel="stylesheet">

        <style>
            body {
                /*font-family: 'Arvo', serif;*/
                font-family: 'Roboto', sans-serif;
                position: relative;
                background: #e1e8ed;
            }

            .center {
                position: fixed;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                padding: 10px 50px;
            }

            h1 {
                font-family: 'Arvo', serif;
                color: #14171A;
                font-size: 68px;
            }
        </style>
    </head>
    <body>
        <div class="center">
            <h1>hoydigo.com</h1>
        </div>
    </body>
</html>
