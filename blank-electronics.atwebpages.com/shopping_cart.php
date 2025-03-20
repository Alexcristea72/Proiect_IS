<!DOCTYPE html>
<html lang="en">
<head>
    <title>Coș de cumpărături</title>
    <link rel="stylesheet" href="shopping_cart.css">
    
</head>
<body>
<?php include 'header.php'; ?>

<h1>Coșul tău de cumpărături</h1>

<div class="cart-container">

    <!-- Secțiunea cu produsele -->
    <div class="cart-items">
        <?php if (empty($cartItems)): ?>
            <p class="empty-cart">Coșul este gol!</p>
        <?php else: ?>
            <?php $total = 0; ?>
            <?php foreach ($cartItems as $item): ?>
                <div class="cart-item">
                    <div>
                        <h3><?= htmlspecialchars($item['name']) ?></h3>
                        <img class ="product-img" src="<?= htmlspecialchars($item['image_link']) ?>" 
                        <p>Preț: <?= number_format($item['price'], 2) ?> RON</p>
                         <form action="/update-cart" method="post" style="display: flex; align-items: center; gap: 10px;">
                            <input type="hidden" name="product_id" value="<?= $item['id'] ?>">
                            <button type="submit" name="action" value="decrease" style="padding: 5px 10px;">-</button>
                            <span><?= $item['quantity'] ?></span>
                            <button type="submit" name="action" value="increase" style="padding: 5px 10px;">+</button>
                        </form>
                        <div style="text-align: right;">
                        <p style="font-weight: bold;">Preț: <?= number_format($item['price'], 2) ?> RON</p>
                        <form action="/remove-from-cart" method="post" style="margin-top: 10px;">
                            <input type="hidden" name="product_id" value="<?= $item['id'] ?>">
                            <button type="submit">Șterge</button>
                        </form>
                    </div>
                        
                    </div>
                    <?php $total += $item['price'] * $item['quantity']; ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <!-- Secțiunea de sumar comandă -->
    <div class="cart-summary">
        <h2>Sumar comandă</h2>
        <p>Cost produse: <?= number_format($total, 2) ?> RON</p>
        <p>Cost livrare: 20.00 RON</p>
        <h3>Total: <?= number_format($total + 20, 2) ?> RON</h3>

        <button>Continuă</button>

        <form action="/clear-cart" method="post" style="margin-top: 20px;">
            <button type="submit" style="background-color: #444;">Golește coșul</button>
        </form>
    </div>

</div>

<a href="/">Continuă cumpărăturile</a>

<?php include 'footer.php'; ?>
</body>
</html>
