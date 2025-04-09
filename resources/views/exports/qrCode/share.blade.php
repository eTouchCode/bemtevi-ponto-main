<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Compartilhar QR Code</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
        }

        .qrCode {

            height: 100vh;
            width: 100vw;
        }

        .qrCodeContainer {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            width: 100%;
            height: 100%;
        }

        .svg {
            width: 500px;
            height: 500px;
            margin: auto;
        }
        .svg img {
            width: 100%;
            height: 100%;
        }

        .companyName {
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="qrCode">
        <div class="qrCodeContainer">
            <div class="svg">
                <img src="{!! $qrCode !!}" alt="">
            </div>
            <div class="companyName">
                <h1>{{ tenant('name') }}</h1>
                <small>Bem-te-vi Ponto</small>
            </div>
        </div>
    </div>
</body>

</html>
