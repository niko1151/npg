<!-- layout.php -->
<!DOCTYPE html>
<html lang="en">

<head>
  <title><?= $title; ?></title>
  <link href="https://fonts.googleapis.com/css?family=Lato:300,400,400i,700,700i,900" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.1.0/css/all.css"
    integrity="sha384-87DrmpqHRiY8hPLIr7ByqhPIywuSsjuQAfMXAE0sMUpY3BM7nXjf+mLIUSvhDArs" crossorigin="anonymous">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <style>
    .topBar {
      background-color: #444;
      color: white;
      padding: 10px;
    }

    body {
      margin: 0;
      padding: 0;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      background-color: #333;
      color: white;
    }

    .navbar {
      background-color: #666;
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 10px;
    }

    .navbar ul {
      list-style-type: none;
      margin: 0;
      padding: 0;
      display: flex;
      align-items: center;
    }

    .navbar a {
      text-decoration: none;
      padding: 8px 16px;
      color: white;
    }

    .navbar a:hover {
      background-color: #888;
    }

    .navbar .left-links,
    .navbar .right-links {
      display: flex;
      align-items: center;
    }

    .navbar .left-links {
      margin-right: auto;
    }

    .navbar .right-links {
      margin-left: auto;
    }

    .navbar li {
      margin-right: 10px;
    }

    .navbar li:last-child {
      margin-right: 0;
    }

    .search-icon {
      display: flex;
      align-items: center;
    }

    .search-icon input {
      margin-right: 10px;
    }

    .footer {
      margin-top: auto;
      background-color: #555;
      padding: 10px;
      text-align: center;
      width: 100%;
    }

    .footer p {
      margin: 0;
      font-size: 14px;
    }

    .footer ul {
      list-style-type: none;
      padding: 0;
      margin-top: 10px;
    }

    .footer ul li {
      display: inline;
      margin: 0 5px;
    }

    .footer ul li a {
      text-decoration: none;
      color: white;
    }

    .footer ul li a:hover {
      color: #999;
    }

    .ml-auto {
      margin-left: auto !important;
    }
  </style>

  <meta charset="utf-8">
</head>

<body>
  <div class="navbar">
    <ul class="left-links">
      <li><a href="/npg">Forside</a></li>
      <li><a href="<?= getenv('BASE_URL')?>/category">Kategorier</a></li>
      <li><a href="<?= getenv('BASE_URL')?>/product">Alle Produkter</a></li>
      <li><a href="<?= getenv('BASE_URL')?>/about">Om os</a></li>
    </ul>
    <!-- Søgeformular i navbar -->
    <div class="search-icon">
      <form method="GET" action="<?= getenv('BASE_URL')?>/product/search" id="live-search-form">
        <label for="search">Søg efter produkter:</label>
        <input type="text" name="search" id="search" placeholder="Indtast søgeterm">
        <button type="submit">Søg</button>
      </form>
    </div>
    <!-- Container til live søge resultater -->
    <div id="live-search-results"></div>
    <ul class="right-links">
      <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) { ?>
        <li><a href="<?= getenv('BASE_URL')?>/logout">logout</a></li>
        <li><a href="<?= getenv('BASE_URL')?>/profile/<?php echo $_SESSION["user_id"]; ?>" role="button">Profil</a></li>
        <?php if (isset($_SESSION['user_id']) && ($_SESSION['user_id'] == 1 || $_SESSION['user_id'] == 2)) { ?>
          <li><a href="<?= getenv('BASE_URL')?>/admin">Admin</a></li>
        <?php } ?>
      <?php } else { ?>
        <li><a href="<?= getenv('BASE_URL')?>/login">Log ind</a></li>
      <?php } ?>
      <li class="ml-auto"><a href="<?= getenv('BASE_URL')?>/checkout">Checkout</a></li>
    </ul>
  </div>

  <main role="main" class="container">
    <?php echo $body_content; ?>
  </main>

  <footer class="footer">
    <p>NPG</p>
    <p>Telegrafvej 9, 2750 Ballerup</p>
    <ul>
      <li><a href="/npg">Forside</a></li>
      <li><a href="<?= getenv('BASE_URL')?>/category">Kategorier</a></li>
      <li><a href="<?= getenv('BASE_URL')?>about">Om os</a></li>
    </ul>
    <p>&copy; <?php echo date('Y'); ?> Min Hjemmeside. Alle rettigheder forbeholdes.</p>
  </footer>

  <!-- ... (eksisterende scripts) ... -->
  <!-- JavaScript for live search -->
  <script>
  $(document).ready(function () {
    $('#live-search-form').submit(function (event) {
      event.preventDefault();

      var searchTerm = $('#search').val();

      if (searchTerm.length >= 2) {
        $.ajax({
          url: '<?= getenv('BASE_URL') ?>/product/search',
          method: 'GET',
          data: { search: searchTerm },
          success: function (data) {
            console.log('AJAX success:', data); // Tilføjet console.log
            $('#live-search-results').html(data);
          },
          error: function (error) {
            console.error('Fejl ved søgning:', error);
          }
        });
      } else {
        $('#live-search-results').html('');
      }
    });
  });
</script>
</body>

</html>