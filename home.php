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
    <div class="carousel-container">
        <button class="carousel-btn prev" onclick="slideProducts(-1)">&lt;</button>
        <div class="products-grid"></div>
        <button class="carousel-btn next" onclick="slideProducts(1)">&gt;</button>
    </div>
</main>

<script>
    let currentPage = 0; // Start from the first page
    const productsPerPage = 4;
    const allProducts = <?= json_encode($products) ?>;

    function slideProducts(direction) {
        const totalPages = Math.ceil(allProducts.length / productsPerPage);
        currentPage += direction;

        // Loop back to the start or end
        if (currentPage < 0) currentPage = totalPages - 1;
        if (currentPage >= totalPages) currentPage = 0;

        updateProductsDisplay(); // Update the displayed products
    }

    function updateProductsDisplay() {
        const productsGrid = document.querySelector('.products-grid');
        productsGrid.innerHTML = ''; // Clear the grid

        // Calculate the start and end indices for the current page
        const startIdx = currentPage * productsPerPage;
        const endIdx = startIdx + productsPerPage;
        const displayedProducts = allProducts.slice(startIdx, endIdx);

        // Add the products for the current page to the grid
        displayedProducts.forEach(product => {
            const productCard = document.createElement('div');
            productCard.className = 'product-card';
            productCard.innerHTML = `
                <a href="product?id=${product.id}" class="product-link">
                    <img src="${product.image_link}" alt="${product.name}" class="product-image">
                </a>
                <div class="product-info">
                    <h3 class="product-name">${product.name}</h3>
                    <div class="product-rating">
                        ${renderRating(product.rating_count, product.total_rating)}
                        <span>(${product.rating_count} reviews)</span>
                    </div>
                    <p class="product-price">Preț: ${parseFloat(product.price).toFixed(2)} RON</p>
                    <a href="/product?id=${product.id}" class="btn view-details">
                        <i class="fas fa-info-circle"></i> Detalii
                    </a>
                    <button class="btn add-to-cart" data-product-id="${product.id}">
                        <i class="fas fa-cart-plus"></i> Adaugă în Coș
                    </button>
                </div>
            `;
            productsGrid.appendChild(productCard);
        });
    }

    function renderRating(count, total) {
        if (count === 0) {
            return `
                <span class="stars">
                    <i class="far fa-star" style="color: #f39c12;"></i>
                    <i class="far fa-star" style="color: #f39c12;"></i>
                    <i class="far fa-star" style="color: #f39c12;"></i>
                    <i class="far fa-star" style="color: #f39c12;"></i>
                    <i class="far fa-star" style="color: #f39c12;"></i>
                </span>
            `; // Empty stars if no reviews
        }

        const average = total / count;
        let stars = '';
        const fullStars = Math.floor(average);
        const hasHalfStar = average % 1 >= 0.5;

        for (let i = 0; i < 5; i++) {
            if (i < fullStars) {
                stars += '<i class="fas fa-star" style="color: #f39c12;"></i>'; // Full star
            } else if (hasHalfStar && i === fullStars) {
                stars += '<i class="fas fa-star-half-alt" style="color: #f39c12;"></i>'; // Half star
            } else {
                stars += '<i class="far fa-star" style="color: #f39c12;"></i>'; // Empty star
            }
        }

        return `<span class="stars">${stars}</span>`;
    }

    // Initialize the products grid
    document.addEventListener('DOMContentLoaded', updateProductsDisplay);
</script>

</body>
</html>