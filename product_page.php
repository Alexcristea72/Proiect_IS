

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="product_page_style.css">
    <title>Detalii Produs</title>
    <link rel="stylesheet" href="product_page_style.css">
</head>
<body>
<?php include 'header.php';?>

<main>
   <section class="product-details">
    <div class="product-container">
        <!-- Imaginea produsului -->
        <div class="product-image-container">
            <img src="<?= htmlspecialchars($product['image_link']) ?>"
                 alt="<?= htmlspecialchars($product['name']) ?>"
                 class="product-image">
        </div>

        <!-- Detaliile produsului -->
        <div class="product-info">
            <h3 class="product-name"><?= htmlspecialchars($product['name']) ?></h3>

            <div class="product-rating">
                <?php
                $rating_count = $product['rating_count'];
                $total_rating = $product['total_rating'];
                $average_rating = ($rating_count > 0) ? $total_rating / $rating_count : 0;
                $full_stars = floor($average_rating);
                $half_star = ($average_rating - $full_stars) >= 0.5;
                ?>

                <?php for ($i = 0; $i < 5; $i++): ?>
                    <?php if ($i < $full_stars): ?>
                        <i class="fas fa-star filled"></i>
                    <?php elseif ($half_star && $i == $full_stars): ?>
                        <i class="fas fa-star-half-alt filled"></i>
                        <?php $half_star = false; ?>
                    <?php else: ?>
                        <i class="far fa-star"></i>
                    <?php endif; ?>
                <?php endfor; ?>
                <span>(<?= $rating_count ?>)</span>
            </div>

            <p class="product-price">Preț: <?= number_format($product['price'], 2) ?> RON</p>

            <button class="btn view-details" onclick="openModal(`<?= htmlspecialchars($product['description']) ?>`)">
    <i class="fas fa-info-circle"></i> Detalii
</button>


            <div id="productModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h2>Detalii produs</h2>
        <p id="productDescription"></p>
    </div>
</div>


            <form action="/add-to-cart" method="post">
                <input type="hidden" name="product_id" value="<?= htmlspecialchars($product['id']); ?>">
                <label for="quantity">Cantitate:</label>
                <input type="number" name="quantity" id="quantity" value="1" min="1" required>
                <button type="submit" class="fas fa-cart-plus">Adaugă în coș</button>
            </form>
        </div>
    </div>
</section>



    <section class="reviews">
        <h3>Lasă un review</h3>
        <?php if (isset($_SESSION['user'])): ?>
            <form action="/add-review" method="post">
                <input type="hidden" name="product_id" value="<?= $product['id'] ?>">

                <label for="rating">Rating (1-5):</label>
                <select name="rating" id="rating" required>
                    <option value="1">⭐</option>
                    <option value="2">⭐⭐</option>
                    <option value="3">⭐⭐⭐</option>
                    <option value="4">⭐⭐⭐⭐</option>
                    <option value="5">⭐⭐⭐⭐⭐</option>
                </select>

                <label for="review_text">Comentariu:</label>
                <textarea name="review_text" id="review_text" rows="3" required></textarea>

                <button type="submit">Trimite review</button>
            </form>
        <?php else: ?>
            <p>Trebuie să fii <a href="/login">logat</a> pentru a lăsa un review.</p>
        <?php endif; ?>
    </section>

    <!-- Lista review-uri -->
    <section class="reviews">
        <h3>Recenzii</h3>
        <?php foreach ($reviews as $review): ?>
            <div class="review">
                <p><strong><?= htmlspecialchars($review['nume']) ?></strong> - <?= htmlspecialchars($review['rating']) ?> ⭐</p>
                <p><?= htmlspecialchars($review['review_text']) ?></p>
                <p><?= htmlspecialchars($review['created_at']) ?></p>
            </div>
        <?php endforeach; ?>
    </section>
</main>

<?php include 'footer.php';?>
<script>
function openModal(description) {
    document.getElementById("productDescription").textContent = description;
    document.getElementById("productModal").style.display = "block";
}

function closeModal() {
    document.getElementById("productModal").style.display = "none";
}

</script>

</body>
</html>
