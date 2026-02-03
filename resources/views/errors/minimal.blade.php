<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#252539">

    <title>@yield('title') | Minecraft Inventory Builder</title>

    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        html, body {
            height: 100%;
            font-family: 'Inter', sans-serif;
            background-color: #252539;
            color: #EBFAFF;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        a { color: #45BEE9; text-decoration: none; transition: color 0.2s; }
        a:hover { color: #6fd0f0; }

        .error-navbar {
            background-color: #1A1A2E;
            padding: 1.25rem 0;
            border-bottom: 1px solid rgba(69, 190, 233, 0.1);
        }

        .error-navbar .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .error-navbar .brand {
            color: #fff;
            font-size: 1.25rem;
            font-weight: 700;
            text-decoration: none;
        }

        .error-navbar .brand:hover { color: #fff; }

        .error-navbar .nav-links a {
            margin-left: 1.5rem;
            font-size: 0.875rem;
            font-weight: 500;
        }

        .error-content {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 3rem 1.5rem;
        }

        .error-card {
            text-align: center;
            max-width: 560px;
            width: 100%;
        }

        .error-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 2rem;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
        }

        .error-icon svg {
            width: 40px;
            height: 40px;
        }

        .error-code {
            font-size: 7rem;
            font-weight: 900;
            line-height: 1;
            letter-spacing: -0.04em;
            background: linear-gradient(135deg, #45BEE9, #6fd0f0);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 0.75rem;
        }

        .error-title {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: #fff;
        }

        .error-message {
            font-size: 1rem;
            line-height: 1.7;
            color: #8A8A8A;
            margin-bottom: 2.5rem;
        }

        .error-actions {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn-primary-error {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.75rem;
            background: #45BEE9;
            color: #13132a;
            font-weight: 600;
            font-size: 0.875rem;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            transition: background 0.2s, transform 0.15s;
            text-decoration: none;
        }

        .btn-primary-error:hover {
            background: #6fd0f0;
            color: #13132a;
            transform: translateY(-1px);
        }

        .btn-secondary-error {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.75rem;
            background: transparent;
            color: #EBFAFF;
            font-weight: 600;
            font-size: 0.875rem;
            border-radius: 8px;
            border: 1px solid rgba(235, 250, 255, 0.2);
            cursor: pointer;
            transition: border-color 0.2s, transform 0.15s;
            text-decoration: none;
        }

        .btn-secondary-error:hover {
            border-color: #45BEE9;
            color: #fff;
            transform: translateY(-1px);
        }

        .error-footer {
            background-color: #13132a;
            padding: 1.5rem 0;
            text-align: center;
            border-top: 1px solid rgba(69, 190, 233, 0.1);
        }

        .error-footer p {
            font-size: 0.8125rem;
            color: #8A8A8A;
            margin: 0;
        }

        .error-footer a { font-weight: 500; }

        .error-decoration {
            position: absolute;
            pointer-events: none;
            opacity: 0.03;
            font-size: 20rem;
            font-weight: 900;
            color: #45BEE9;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            user-select: none;
            z-index: 0;
        }

        .error-content-inner {
            position: relative;
            z-index: 1;
        }

        @media (max-width: 640px) {
            .error-code { font-size: 5rem; }
            .error-title { font-size: 1.25rem; }
            .error-navbar .nav-links { display: none; }
            .error-decoration { font-size: 12rem; }
        }
    </style>
</head>
<body>

    <nav class="error-navbar">
        <div class="container">
            <a href="/" class="brand">Minecraft Inventory Builder</a>
            <div class="nav-links">
                <a href="/">Home</a>
                <a href="https://discord.groupez.dev/" target="_blank">Discord</a>
            </div>
        </div>
    </nav>

    <main class="error-content" style="position: relative; overflow: hidden;">
        <div class="error-decoration">@yield('code')</div>
        <div class="error-content-inner">
            <div class="error-card">
                @yield('icon')
                <div class="error-code">@yield('code')</div>
                <h1 class="error-title">@yield('title')</h1>
                <p class="error-message">@yield('message')</p>
                <div class="error-actions">
                    <a href="/" class="btn-primary-error">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                        Back to home
                    </a>
                    <a href="javascript:history.back()" class="btn-secondary-error">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
                        Go back
                    </a>
                </div>
            </div>
        </div>
    </main>

    <footer class="error-footer">
        <p>&copy; {{ date('Y') }} <a href="/">Minecraft Inventory Builder</a></p>
    </footer>

</body>
</html>
