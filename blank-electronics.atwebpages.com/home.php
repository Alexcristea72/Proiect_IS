<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Blank Electronics</title>
    <link rel="stylesheet" href="home_style.css">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>
<body>
<?php include 'header.php'; ?>

<!-- Conținut principal -->
<main class="main-content">
    <h1>Produse Populare</h1>
    <div class="products-grid">
        <?php foreach ($products as $product): ?>
            <div class="product-card">
                <a href="product?id=<?= $product['id'] ?>" class="product-link">
                    <img src="<?= htmlspecialchars($product['image_link']) ?>"
                         alt="<?= htmlspecialchars($product['name']) ?>"
                         class="product-image">
                </a>
                <div class="product-info">
                    <h3 class="product-name"><?= htmlspecialchars($product['name']) ?></h3>

                    <!-- Rating stele -->
                    <div class="product-rating">
                        <?php
                        $rating_count = $product['rating_count'];
                        $average_rating = ($rating_count > 0) ? $product['total_rating'] / $rating_count : 0;
                        $full_stars = floor($average_rating);
                        $half_star = ($average_rating - $full_stars) >= 0.5;
                        ?>

                        <?php for ($i = 0; $i < 5; $i++): ?>
                            <?php if ($i < $full_stars): ?>
                                <i class="fas fa-star filled"></i> <!-- Stea plină -->
                            <?php elseif ($half_star && $i == $full_stars): ?>
                                <i class="fas fa-star-half-alt filled"></i> <!-- Stea pe jumătate -->
                                <?php $half_star = false; // Se afișează doar o singură stea pe jumătate ?>
                            <?php else: ?>
                                <i class="far fa-star"></i> <!-- Stea goală -->
                            <?php endif; ?>
                        <?php endfor; ?>

                        <span>(<?= $rating_count ?>)</span>
                    </div>

                    <p class="product-price">Preț: <?= number_format($product['price'], 2) ?> RON</p>

                    <a href="/product?id=<?= $product['id'] ?>" class="btn view-details">
                        <i class="fas fa-info-circle"></i> Detalii
                    </a>

                    <button class="btn add-to-cart" data-product-id="<?= $product['id'] ?>">
                        <i class="fas fa-cart-plus"></i> Adaugă în Coș
                    </button>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</main>

<script src="main.js"></script>
</body>
</html>
