<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <title>Laravel Localization</title>

    <style>
        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background: linear-gradient(135deg, #667eea, #764ba2);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .card {
            background: #ffffff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            text-align: center;
            width: 400px;
        }

        .locale {
            font-size: 14px;
            color: #666;
            margin-bottom: 10px;
        }

        h1 {
            margin: 15px 0;
            color: #333;
        }

        .buttons {
            margin-top: 20px;
        }

        .btn {
            text-decoration: none;
            padding: 8px 18px;
            margin: 5px;
            border-radius: 6px;
            font-weight: bold;
            transition: 0.3s;
        }

        .btn-en {
            background: #4CAF50;
            color: white;
        }

        .btn-hi {
            background: #ff9800;
            color: white;
        }

        .btn:hover {
            opacity: 0.8;
        }
    </style>
</head>

<body>

    <div class="card">

        <div class="locale">
            Current Locale: <strong>{{ app()->getLocale() }}</strong>
        </div>

        <h1>{{ __('messages.welcome') }}</h1>

        <div class="buttons">
            <a href="/en" class="btn btn-en">English</a>
            <a href="/hi" class="btn btn-hi">हिंदी</a>
        </div>

    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {

            let greeting = @json(__('messages.greeting', ['Name' => 'Demo']));
            alert(greeting);

        });
    </script>

</body>

</html>