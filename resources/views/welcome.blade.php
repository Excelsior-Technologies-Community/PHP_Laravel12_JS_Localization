<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <title>Laravel Localization</title>

    <style>
        body {
            margin: 0;
            font-family: Arial;
            background: linear-gradient(135deg, #667eea, #764ba2);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            transition: 0.3s;
        }

        .card {
            background: #fff;
            padding: 40px;
            border-radius: 12px;
            width: 420px;
            text-align: center;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            transition: 0.3s;
        }

        select,
        button {
            padding: 10px;
            margin-top: 10px;
            width: 100%;
            border-radius: 6px;
        }

        button {
            cursor: pointer;
            border: none;
            font-weight: bold;
        }

        #darkModeToggle {
            background: #333;
            color: white;
        }

        .dark-mode {
            background: #121212 !important;
            color: white !important;
        }

        .dark-mode .card {
            background: #1e1e1e !important;
            color: white !important;
        }
    </style>
</head>

<body>

    <div class="card">

        <h2>{{ __('messages.welcome') }}</h2>

        <p>Current Locale: <b>{{ app()->getLocale() }}</b></p>

        <!-- LANGUAGE SWITCHER -->
        <select id="languageSwitcher">
            <option value="en" {{ app()->getLocale() == 'en' ? 'selected' : '' }}>English</option>
            <option value="hi" {{ app()->getLocale() == 'hi' ? 'selected' : '' }}>Hindi</option>
        </select>

        <!-- DARK MODE -->
        <button id="darkModeToggle">🌙 Toggle Dark Mode</button>

    </div>

    <script>
        // ================= LANGUAGE SWITCH =================
        document.getElementById('languageSwitcher').addEventListener('change', function() {
            let lang = this.value;

            localStorage.setItem('lang', lang);

            window.location.href = "/lang/" + lang;
        });

        // just set dropdown value (NO redirect)
        document.addEventListener("DOMContentLoaded", function() {
            let savedLang = localStorage.getItem('lang');

            if (savedLang) {
                document.getElementById('languageSwitcher').value = savedLang;
            }
        });

        // ================= DARK MODE =================
        const toggleBtn = document.getElementById("darkModeToggle");

        if (localStorage.getItem("theme") === "dark") {
            document.body.classList.add("dark-mode");
        }

        toggleBtn.addEventListener("click", function() {
            document.body.classList.toggle("dark-mode");

            if (document.body.classList.contains("dark-mode")) {
                localStorage.setItem("theme", "dark");
            } else {
                localStorage.setItem("theme", "light");
            }
        });
    </script>

</body>

</html>