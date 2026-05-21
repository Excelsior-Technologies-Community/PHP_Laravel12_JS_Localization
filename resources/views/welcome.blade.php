<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Laravel Localization - Enhanced</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            transition: 0.3s;
        }

        .card {
            background: #fff;
            padding: 40px;
            border-radius: 20px;
            width: 550px;
            max-width: 100%;
            text-align: center;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
            transition: 0.3s;
        }

        h2 {
            color: #667eea;
            margin-bottom: 15px;
            font-size: 1.8rem;
        }

        .locale-badge {
            background: #667eea;
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            display: inline-block;
            margin-bottom: 20px;
            font-size: 0.9rem;
        }

        select, button, input {
            padding: 12px;
            margin-top: 12px;
            width: 100%;
            border-radius: 10px;
            border: 2px solid #e0e0e0;
            font-size: 1rem;
            transition: 0.3s;
        }

        select:focus, input:focus {
            outline: none;
            border-color: #667eea;
        }

        button {
            cursor: pointer;
            border: none;
            font-weight: bold;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            transition: transform 0.2s;
        }

        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        #darkModeToggle {
            background: #333;
            color: white;
        }

        #darkModeToggle:hover {
            background: #444;
        }

        .reset-btn {
            background: #ff6b6b;
        }

        .reset-btn:hover {
            background: #ff5252;
        }

        .stats {
            background: #f5f5f5;
            padding: 15px;
            border-radius: 10px;
            margin: 20px 0;
            text-align: left;
        }

        .stats p {
            margin: 8px 0;
            font-size: 0.95rem;
        }

        .greeting-box {
            background: linear-gradient(135deg, #667eea20, #764ba220);
            padding: 15px;
            border-radius: 10px;
            margin: 15px 0;
            font-weight: bold;
        }

        .features-list {
            text-align: left;
            margin: 20px 0;
            padding-left: 20px;
        }

        .features-list li {
            margin: 8px 0;
            font-size: 0.9rem;
        }

        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            background: #4caf50;
            color: white;
            padding: 12px 20px;
            border-radius: 8px;
            animation: slideIn 0.3s ease-out;
            z-index: 1000;
        }

        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        .dark-mode {
            background: #1a1a2e !important;
        }

        .dark-mode .card {
            background: #16213e !important;
            color: #eee !important;
        }

        .dark-mode .stats {
            background: #0f3460 !important;
        }

        .dark-mode select, .dark-mode input {
            background: #0f3460;
            color: white;
            border-color: #16213e;
        }

        .dark-mode .locale-badge {
            background: #0f3460;
        }
    </style>
</head>

<body>

    <div class="card">
        <h2 id="welcomeText">{{ __('messages.welcome') }}</h2>
        
        <div class="locale-badge">
            {{ __('messages.current_language') }}: <span id="currentLocale">{{ app()->getLocale() == 'en' ? 'English' : 'हिन्दी' }}</span>
        </div>

        <!-- LANGUAGE SWITCHER - Real-time -->
        <select id="languageSwitcher">
            <option value="en" {{ app()->getLocale() == 'en' ? 'selected' : '' }}>🇬🇧 English</option>
            <option value="hi" {{ app()->getLocale() == 'hi' ? 'selected' : '' }}>🇮🇳 हिन्दी (Hindi)</option>
        </select>

        <!-- Statistics Box -->
        <div class="stats">
            <strong> {{ __('messages.stats_title') }}</strong>
            <p> {{ __('messages.total_translations') }}: <span id="translationCount">2</span></p>
            <p> {{ __('messages.current_language') }}: <span id="statLanguage">{{ app()->getLocale() == 'en' ? 'English' : 'हिन्दी' }}</span></p>
        </div>

        <!-- Name Greeting Feature -->
        <input type="text" id="userName" placeholder="{{ __('messages.enter_name') }}" value="John">
        <button id="showGreeting">{{ __('messages.show_greeting') }}</button>
        
        <div class="greeting-box" id="greetingDisplay">
             {{ __('messages.your_greeting') }}
        </div>

        <!-- Features List -->
        <ul class="features-list" id="featuresList">
            <li>{{ __('messages.feature_1') }}</li>
            <li>{{ __('messages.feature_2') }}</li>
            <li>{{ __('messages.feature_3') }}</li>
            <li>{{ __('messages.feature_4') }}</li>
            <li>{{ __('messages.feature_5') }}</li>
        </ul>

        <!-- Action Buttons -->
        <button id="darkModeToggle"> {{ __('messages.feature_4') }}</button>
        <button id="resetBtn" class="reset-btn">{{ __('messages.reset') }}</button>

    </div>

    <script>
        let currentLang = localStorage.getItem('lang') || '{{ app()->getLocale() }}';

        // Show notification function
        function showNotification(message, isError = false) {
            const notification = document.createElement('div');
            notification.className = 'notification';
            notification.style.background = isError ? '#ff5252' : '#4caf50';
            notification.textContent = message;
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.remove();
            }, 2000);
        }

        // Update all text content dynamically
        async function updateLanguage(locale) {
            try {
                const response = await fetch('/switch-language', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ locale: locale })
                });

                const data = await response.json();

                // Update all text content
                document.getElementById('welcomeText').textContent = data.welcome;
                document.getElementById('currentLocale').textContent = data.language_name;
                document.getElementById('statLanguage').textContent = data.language_name;
                document.getElementById('translationCount').textContent = data.translation_count;
                
                // Update placeholders
                document.getElementById('userName').placeholder = 
                    locale === 'en' ? 'Enter your name' : 'अपना नाम दर्ज करें';
                
                // Update button texts
                document.getElementById('showGreeting').textContent = 
                    locale === 'en' ? 'Show Greeting' : 'अभिवादन दिखाएं';
                
                document.getElementById('darkModeToggle').innerHTML = 
                    ` ${locale === 'en' ? 'Toggle Dark Mode' : 'डार्क मोड टॉगल करें'}`;
                
                document.getElementById('resetBtn').textContent = 
                    locale === 'en' ? ' Reset Settings' : ' सेटिंग्स रीसेट करें';
                
                // Update features list
                // const features = [
                //     locale === 'en' ? ' Real-time language switching (No page reload)' : ' रियल-टाइम भाषा बदलना (पेज रीलोड नहीं)',
                //     locale === 'en' ? ' Dynamic name-based greeting' : ' नाम-आधारित डायनामिक अभिवादन',
                //     locale === 'en' ? ' Translation statistics' : ' अनुवाद के आंकड़े',
                //     locale === 'en' ? ' Dark mode support' : ' डार्क मोड सपोर्ट',
                //     locale === 'en' ? ' Persistent settings with localStorage' : ' localStorage के साथ सेटिंग्स सुरक्षित'
                // ];
                
                const featuresList = document.getElementById('featuresList');
                featuresList.innerHTML = '';
                features.forEach(feature => {
                    const li = document.createElement('li');
                    li.textContent = feature;
                    featuresList.appendChild(li);
                });
                
                // Update greeting display text
                document.getElementById('greetingDisplay').innerHTML = 
                    ` ${locale === 'en' ? 'Your Personalized Greeting' : 'आपका व्यक्तिगत अभिवादन'}`;
                
                // Update stats title
                const statsTitle = document.querySelector('.stats strong');
                statsTitle.innerHTML = locale === 'en' ? ' Language Statistics' : ' भाषा के आंकड़े';
                
                // Show success notification
                showNotification(data.switch_message);
                
                // Update current language
                currentLang = locale;
                localStorage.setItem('lang', locale);
                
            } catch (error) {
                console.error('Error updating language:', error);
                showNotification('Error switching language!', true);
            }
        }

        // Show personalized greeting
        function showGreeting() {
            const name = document.getElementById('userName').value.trim();
            if (!name) {
                const lang = currentLang;
                const message = lang === 'en' ? 'Please enter your name!' : 'कृपया अपना नाम दर्ज करें!';
                showNotification(message, true);
                return;
            }
            
            const locale = currentLang;
            const greeting = locale === 'en' ? `Hello, ${name}! Welcome!` : `नमस्ते, ${name}!  स्वागत है!`;
            document.getElementById('greetingDisplay').innerHTML = ` ${greeting}`;
        }

        // Reset all settings
        function resetSettings() {
            // Reset language to English
            currentLang = 'en';
            localStorage.setItem('lang', 'en');
            document.getElementById('languageSwitcher').value = 'en';
            updateLanguage('en');
            
            // Reset name
            document.getElementById('userName').value = 'John';
            
            // Reset dark mode
            if (document.body.classList.contains('dark-mode')) {
                document.body.classList.remove('dark-mode');
                localStorage.setItem('theme', 'light');
            }
            
            showNotification(currentLang === 'en' ? 'Settings reset to default!' : 'सेटिंग्स डिफ़ॉल्ट पर रीसेट कर दी गईं!');
        }

        // ================= EVENT LISTENERS =================
        
        // Language switcher - Real-time
        document.getElementById('languageSwitcher').addEventListener('change', function() {
            let lang = this.value;
            currentLang = lang;
            localStorage.setItem('lang', lang);
            updateLanguage(lang);
        });

        // Show greeting button
        document.getElementById('showGreeting').addEventListener('click', showGreeting);
        
        // Enter key on name input
        document.getElementById('userName').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                showGreeting();
            }
        });

        // Reset button
        document.getElementById('resetBtn').addEventListener('click', resetSettings);

        // Dark mode toggle
        const toggleBtn = document.getElementById("darkModeToggle");
        
        if (localStorage.getItem("theme") === "dark") {
            document.body.classList.add("dark-mode");
        }

        toggleBtn.addEventListener("click", function() {
            document.body.classList.toggle("dark-mode");
            
            if (document.body.classList.contains("dark-mode")) {
                localStorage.setItem("theme", "dark");
                showNotification(currentLang === 'en' ? 'Dark mode enabled!' : 'डार्क मोड सक्षम!');
            } else {
                localStorage.setItem("theme", "light");
                showNotification(currentLang === 'en' ? 'Light mode enabled!' : 'लाइट मोड सक्षम!');
            }
        });

        // Set dropdown value on load
        document.addEventListener("DOMContentLoaded", function() {
            let savedLang = localStorage.getItem('lang');
            if (savedLang && savedLang !== currentLang) {
                currentLang = savedLang;
                document.getElementById('languageSwitcher').value = savedLang;
                updateLanguage(savedLang);
            }
            
            // Set initial name if exists
            const savedName = localStorage.getItem('userName');
            if (savedName) {
                document.getElementById('userName').value = savedName;
            }
            
            // Save name on change
            document.getElementById('userName').addEventListener('change', function() {
                localStorage.setItem('userName', this.value);
            });
        });
    </script>

</body>

</html>