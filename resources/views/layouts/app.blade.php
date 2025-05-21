<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>SIUP - Universitas Pertamina</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

  <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container">
      <a class="navbar-brand" href="/">SIUP</a>
      <div class="collapse navbar-collapse">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="{{ route('faculties.index') }}">Fakultas</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ route('programs.index') }}">Program Studi</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="container">
    @yield('content')
  </div>

</body>

</html>
