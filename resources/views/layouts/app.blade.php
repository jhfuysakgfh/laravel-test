
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Laravel Store')</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f5f6fa;
            color: #222;
        }

        nav {
            background: #222;
            color: white;
            padding: 18px 40px;
        }

        nav a {
            color: white;
            text-decoration: none;
            margin-right: 20px;
        }

        .container {
            max-width: 1100px;
            margin: 40px auto;
            padding: 20px;
        }

        footer {
            text-align: center;
            padding: 20px;
            background: #222;
            color: white;
            margin-top: 60px;
        }
    </style>

    @yield('styles')
</head>
<body>

    <nav>
        <a href="/">Laravel Store</a>
        <a href="/">Home</a>
    </nav>

    <main class="container">
        @yield('content')
    </main>

    <footer>
        <p>&copy; {{ date('Y') }} Laravel Store. All rights reserved.</p>
    </footer>

    @yield('scripts')

</body>
</html>
