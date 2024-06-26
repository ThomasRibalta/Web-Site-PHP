<!DOCTYPE html>
<html lang="fr" class="h-100">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <title><?= $title ?? "blog" ?></title>
</head>
<body class="d-flex flex-column h-100">
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Mon Blog</a>
  </div>
</nav>
  
  <div class="container mt-4 mb-4">
    <?= $content ?>
  </div>

  <footer class="bg-primary py-4 footer mt-auto">
    <div class="container">
      <p>Page généré en <?= round(1000 * (microtime(true) - DEBUG_TIME)) ?> ms</p>
    </div>
  </footer>
</body>
</html>