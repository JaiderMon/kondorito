<?php
session_start();

if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['agregar_carrito'])) {
    $producto = [
        'id' => $_POST['id'],
        'nombre' => $_POST['name'],
        'precio' => $_POST['price'],
        'imagen' => $_POST['image']
    ];

    $_SESSION['carrito'][] = $producto;
}

$cantidadCarrito = count($_SESSION['carrito']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Catálogo Completo | Kondorito</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'pastel-pink': '#ffcce6',
                        'pastel-brown': '#8b4513',
                        'pastel-cream': '#fffaf0',
                        'pastel-yellow': '#fffacd',
                        'pastel-purple': '#e6e6fa',
                        'primary': '#d2691e',
                        'secondary': '#a0522d'
                    },
                    fontFamily: {
                        'display': ['"Playfair Display"', 'serif'],
                        'body': ['"Open Sans"', 'sans-serif']
                    }
                }
            }
        }
    </script>

    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Open+Sans:wght@300;400;600&display=swap" rel="stylesheet">

    <style>
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        .floating { animation: float 3s ease-in-out infinite; }
    </style>
</head>

<body class="min-h-screen bg-pastel-cream font-body text-gray-800">

    <!-- Header -->
    <header class="sticky top-0 z-50 bg-white shadow-md">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center py-4 flex-wrap gap-4">
                
                <!-- Logo -->
                <div class="flex items-center">
                    <div class="w-12 h-12 rounded-full bg-pastel-yellow flex items-center justify-center mr-3">
                        <span class="text-2xl">🎂</span>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold font-display text-pastel-brown">Kondorito</h1>
                        <p class="text-sm text-gray-600">Postres y Pasteles</p>
                    </div>
                </div>

                <!-- Botón volver -->
                <a href="index.php"
                   class="bg-pastel-brown hover:bg-secondary text-white px-5 py-2 rounded-full font-semibold transition duration-300 shadow">
                    Volver al inicio
                </a>
            </div>
        </div>
    </header>

    <!-- Hero -->
    <section class="bg-gradient-to-r from-pastel-pink via-pastel-cream to-pastel-yellow py-16">
        <div class="container mx-auto px-4 text-center">
            <div class="floating inline-block mb-4 text-5xl">🍰</div>
            <h2 class="text-4xl md:text-5xl font-display font-bold text-pastel-brown mb-4">
                Catálogo Completo
            </h2>
            <p class="text-lg text-gray-700 max-w-2xl mx-auto">
                Descubre nuestras tortas, postres y cupcakes preparados con amor, sabor y un toque especial de Kondorito.
            </p>
        </div>
    </section>

    <!-- Filtros -->
    <section class="py-8">
        <div class="container mx-auto px-4">
            <div class="bg-white rounded-3xl shadow-md p-6 flex flex-col md:flex-row gap-4 justify-between items-center">
                <input
                    type="text"
                    id="searchInput"
                    placeholder="Buscar producto..."
                    class="w-full md:w-1/2 px-4 py-3 border border-pastel-pink rounded-full focus:outline-none focus:ring-2 focus:ring-pastel-brown"
                />

                <select
                    id="categoryFilter"
                    class="w-full md:w-1/4 px-4 py-3 border border-pastel-pink rounded-full focus:outline-none focus:ring-2 focus:ring-pastel-brown bg-white"
                >
                    <option value="all">Todas las categorías</option>
                    <option value="Tortas">Tortas</option>
                    <option value="Cupcakes">Cupcakes</option>
                    <option value="Postres">Postres</option>
                </select>
            </div>
        </div>
    </section>

    <!-- Catálogo -->
    <section class="pb-16">
        <div class="container mx-auto px-4">
            <div id="catalogGrid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Productos aquí -->
            </div>
        </div>
    </section>

    <script>
        const catalogoData = [
            {
                id: 1,
                name: "Torta Chocolate Supreme",
                description: "Chocolate negro con relleno de ganache y frambuesas.",
                price: 45.99,
                image: "https://aki-225de.kxcdn.com/wp-content/uploads/2021/01/foto-receta-pastel-chocolate.jpg",
                alt: "Torta de chocolate",
                category: "Tortas"
            },
            {
                id: 2,
                name: "Red Velvet Clásica",
                description: "Bizcocho rojo con frosting de queso crema.",
                price: 39.99,
                image: "https://i0.wp.com/anandaweb.com/wp-content/uploads/2025/04/Torta-Red-Velvet-Ananda-Mediana-1.png?fit=1080%2C1080&ssl=1",
                alt: "Torta Red Velvet",
                category: "Tortas"
            },
            {
                id: 3,
                name: "Tres Leches",
                description: "Suave, cremosa y tradicional.",
                price: 34.99,
                image: "https://picsum.photos/400/300?random=4",
                alt: "Torta tres leches",
                category: "Tortas"
            },
            {
                id: 4,
                name: "Cheesecake de Frutos Rojos",
                description: "Cremoso cheesecake con cubierta de frutos rojos.",
                price: 42.50,
                image: "https://cdn.recetasderechupete.com/wp-content/uploads/2018/03/Tarta-de-queso-Antonio.jpg",
                alt: "Cheesecake",
                category: "Postres"
            },
            {
                id: 5,
                name: "Cupcake de Vainilla",
                description: "Esponjoso cupcake con topping suave de vainilla.",
                price: 6.50,
                image: "https://cakemehometonight.com/wp-content/uploads/2020/08/Confetti-Cupcakes-19.jpg",
                alt: "Cupcake de vainilla",
                category: "Cupcakes"
            },
            {
                id: 6,
                name: "Torta de Zanahoria",
                description: "Deliciosa torta de zanahoria con nueces y crema.",
                price: 37.90,
                image: "https://picsum.photos/400/300?random=7",
                alt: "Torta de zanahoria",
                category: "Tortas"
            },
            {
                id: 7,
                name: "Brownie Especial",
                description: "Brownie húmedo con trozos de chocolate.",
                price: 8.99,
                image: "https://picsum.photos/400/300?random=8",
                alt: "Brownie",
                category: "Postres"
            },
            {
                id: 8,
                name: "Cupcake de Chocolate",
                description: "Cupcake de chocolate con cobertura cremosa.",
                price: 7.20,
                image: "https://picsum.photos/400/300?random=9",
                alt: "Cupcake de chocolate",
                category: "Cupcakes"
            }
        ];

        const catalogGrid = document.getElementById("catalogGrid");
        const searchInput = document.getElementById("searchInput");
        const categoryFilter = document.getElementById("categoryFilter");

        function renderCatalog(products) {
            catalogGrid.innerHTML = products.map(product => `
                <div class="bg-white rounded-3xl shadow-lg overflow-hidden hover:shadow-xl transition duration-300 transform hover:-translate-y-2">
                    <img src="${product.image}" alt="${product.alt}" class="w-full h-56 object-cover">
                    <div class="p-5">
                        <div class="flex justify-between items-start mb-3">
                            <h3 class="text-xl font-display font-bold text-pastel-brown">${product.name}</h3>
                            <span class="bg-pastel-purple text-pastel-brown text-xs px-3 py-1 rounded-full font-semibold">
                                ${product.category}
                            </span>
                        </div>
                        <p class="text-gray-600 mb-4 text-sm">${product.description}</p>
                        <div class="flex justify-between items-center">
                            <span class="text-lg font-bold text-primary">$${product.price.toFixed(2)}</span>
                            <button class="bg-pastel-brown hover:bg-secondary text-white px-4 py-2 rounded-full transition duration-300">
                                Agregar
                            </button>
                        </div>
                    </div>
                </div>
            `).join("");
        }

        function filterProducts() {
            const searchText = searchInput.value.toLowerCase();
            const selectedCategory = categoryFilter.value;

            const filtered = catalogoData.filter(product => {
                const matchesSearch =
                    product.name.toLowerCase().includes(searchText) ||
                    product.description.toLowerCase().includes(searchText);

                const matchesCategory =
                    selectedCategory === "all" || product.category === selectedCategory;

                return matchesSearch && matchesCategory;
            });

            renderCatalog(filtered);
        }

        searchInput.addEventListener("input", filterProducts);
        categoryFilter.addEventListener("change", filterProducts);

        renderCatalog(catalogoData);
    </script>
</body>
</html>