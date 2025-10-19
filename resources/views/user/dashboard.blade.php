<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <style>
        body {
            display: flex;
            min-height: 100vh;
            overflow-x: hidden;
            margin: 0;
        }

        /* Sidebar */
        .sidebar {
            width: 250px;
            background: #13772aff; /* Vert bootstrap */
            color: #fff;
            padding-top: 20px;
            flex-shrink: 0;
            margin-left: -10px;
            box-shadow: 2px 0 5px rgba(0,0,0,0.1);
        }

        .sidebar h4 {
            color: #fff;
        }

        .sidebar a {
            color: #e2f0d9;
            text-decoration: none;
            display: block;
            padding: 12px 20px;
            border-radius: 5px;
            transition: background 0.3s;
        }

        .sidebar a:hover, .sidebar a.active {
            background: #1a7930ff;
            color: #fff;
        }

        /* Contenu principal */
        .content {
            flex-grow: 1;
            background: #f8f9fa;
            padding: 30px;
            margin-left: 10px;
        }
    </style>
</head>

<body>

    <!-- Inclusion de la sidebar -->
    @include('user.sidebar')

    <!-- Contenu principal -->
    <div class="content">
        <h2 class="mb-4">Bienvenue, {{ Auth::user()->name ?? 'Utilisateur' }} 👋</h2>

        {{-- Ici le contenu spécifique de chaque page --}}
        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
