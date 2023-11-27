<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Forside - NPG</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background-color: #333;
      color: white;
    }

    .container {
      max-width: 960px;
      margin: 0 auto;
      padding: 20px;
    }

    h1 {
      text-align: center;
    }

    p {
      text-align: center;
      font-size: 18px;
      margin-bottom: 20px;
    }

    /* Produktkort styling */
    .product-card {
      margin-bottom: 20px;
      background-color: #333;
      width: 30%; /* Set width to one-third */
      display: flex;
      flex-direction: column;
    }

    .product-card img {
      width: 100%;
      height: 250px;
      max-height: 100%; /* Ensure the image does not exceed the height of the card */
      object-fit: cover;
    }

    .product-card .card-body {
      padding: 10px;
      height: 200px; /* Set a fixed height for the card body */
      display: flex;
      flex-direction: column;
      overflow: hidden; /* Hide any content that overflows the fixed height */
    }

    .product-card .card-body h5,
    .product-card .card-body p {
      flex-grow: 1; /* Allow the text to take up the available space */
      overflow: hidden; /* Hide any text that overflows the fixed height */
      margin: 0; /* Remove default margin */
    }

    .product-card .btn {
      margin-top: 10px;
    }

    /* Overskrift og tekstfarve for konsistens */
    .card-title,
    .card-text {
      color: white;
    }

    /* Knapfarver for konsistens */
    .btn-info,
    .btn-primary {
      background-color: #17a2b8;
      border-color: #17a2b8;
    }

    .btn-info:hover,
    .btn-primary:hover {
      background-color: #138496;
      border-color: #117a8b;
    }

    /* Modal styling */
    #descriptionModal {
      background-color: #333;
      color: white;
    }

    /* Knapfarver for modal for konsistens */
    #descriptionModal .btn-info,
    #descriptionModal .btn-primary {
      background-color: #17a2b8;
      border-color: #17a2b8;
    }

    #descriptionModal .btn-info:hover,
    #descriptionModal .btn-primary:hover {
      background-color: #138496;
      border-color: #117a8b;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Velkommen til NPG</h1>
    <p><?php echo date('Y-m-d'); ?></p>

    <div class="row">
        <?php foreach($randomProducts as $product): ?>
            <div class="col-4 mb-3 product-card">
                <div class="card border-dark" style="background-color: #333;">
                    <?php
                        $imagePath = isset($product->billede_url) && !empty($product->billede_url)
                            ? "../npg/images/" . $product->billede_url
                            : '../npg/images/NPGaming.png';
                    ?>
                    <div style="padding: 10px; box-sizing: border-box;">
                        <img src="<?= $imagePath; ?>" class="card-img-top" alt="Product Image">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title"><?= $product->produkt_navn; ?></h5>
                        <p class="card-text"><strong>Pris:</strong> <?= number_format($product->pris, 2); ?> DKK</p>
                        <p class="card-text"><strong>Kategori:</strong> <?= $product->kategori_navn; ?></p>
                        <a href="product_details/<?= $product->produkt_id; ?>" class="btn btn-info btn-sm">
                            Vis Detaljer
                        </a>
                        <button class="btn btn-primary btn-sm add-to-cart" data-product-id="<?= $product->produkt_id; ?>">
                            Tilføj til kurv
                        </button>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
  </div>

  <!-- Modal for visning af beskrivelse -->
  <div class="modal fade" id="descriptionModal" tabindex="-1" role="dialog" aria-labelledby="descriptionModalLabel" aria-hidden="true" style="background-color: #333; color: white;">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="descriptionModalLabel">Produkt Beskrivelse</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" id="descriptionContent"></div>
      </div>
    </div>
  </div>

  <!-- JavaScript for håndtering af visning af beskrivelse og tilføjelse til kurven -->
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      // Vis beskrivelse knap
      document.querySelectorAll('.view-description').forEach(function (button) {
        button.addEventListener('click', function () {
          var description = this.getAttribute('data-description');
          document.getElementById('descriptionContent').innerText = description;
          $('#descriptionModal').modal('show');
        });
      });

      // Tilføj til kurven knap
      document.querySelectorAll('.add-to-cart').forEach(function (button) {
        button.addEventListener('click', function () {
          var productId = this.getAttribute('data-product-id');
          // Implementer logik for at tilføje produktet til indkøbskurven, f.eks. via AJAX
          alert('Produktet med ID ' + productId + ' blev tilføjet til kurven!');
        });
      });
    });
  </script>
</body>
</html>