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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
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
    <script src="assets/js/cart.js" defer></script>

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

                <a href="index.php" class="flex items-center">
                    <div class="w-12 h-12 rounded-full bg-pastel-yellow flex items-center justify-center mr-3">
                        <i class="fas fa-birthday-cake text-2xl text-pastel-brown"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold font-display text-pastel-brown">Kondorito</h1>
                        <p class="text-sm text-gray-600">Postres y Pasteles</p>
                    </div>
                </a>

                <nav class="hidden lg:flex items-center gap-8 text-gray-700">
                    <a href="index.php" class="hover:text-primary transition">Inicio</a>
                    <a href="Catalogocompleto.php" class="text-primary font-semibold">Cat&aacute;logo</a>
                    <a href="nosotros.php" class="hover:text-primary transition">Nosotros</a>
                    <a href="contacto.php" class="hover:text-primary transition">Contacto</a>
                </nav>

                <div class="flex items-center gap-4">
                    <?php if(isset($_SESSION['usuario'])): ?>
                        <details class="relative">
                            <summary class="flex cursor-pointer list-none items-center text-gray-700 hover:text-primary">
                                <i class="fas fa-user text-lg"></i>
                                <span class="ml-1 hidden sm:inline">Hola, <?php echo htmlspecialchars($_SESSION['usuario'], ENT_QUOTES, 'UTF-8'); ?></span>
                                <i class="fas fa-chevron-down ml-2 text-xs"></i>
                            </summary>
                            <div class="absolute right-0 mt-3 w-56 rounded-2xl border border-pink-100 bg-white p-2 shadow-xl">
                                <a href="perfil.php" class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm text-gray-700 hover:bg-orange-50 hover:text-primary">
                                    <i class="fas fa-user-cog"></i>
                                    Configuraci&oacute;n perfil
                                </a>
                                <a href="mis_pedidos.php" class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm text-gray-700 hover:bg-orange-50 hover:text-primary">
                                    <i class="fas fa-receipt"></i>
                                    Mis pedidos
                                </a>
                                <a href="logout.php" class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm text-red-500 hover:bg-red-50">
                                    <i class="fas fa-sign-out-alt"></i>
                                    Cerrar sesi&oacute;n
                                </a>
                            </div>
                        </details>
                    <?php else: ?>
                        <a href="login.php" class="hidden sm:inline-flex items-center text-gray-700 hover:text-primary">
                            <i class="fas fa-user text-lg"></i>
                            <span class="ml-1">Mi cuenta</span>
                        </a>
                    <?php endif; ?>

                    <a href="#cart"
                     id="cart-btn"
                     data-cart-button
                     class="relative bg-pastel-pink hover:bg-pink-300 transition-colors rounded-full p-3">
                        <i class="fas fa-shopping-cart text-xl text-pastel-brown"></i>
                        <span id="cart-count" data-cart-count
                          class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">0</span>
                    </a>
                </div>

                <nav class="flex w-full flex-wrap justify-center gap-x-6 gap-y-2 text-sm text-gray-700 lg:hidden">
                    <a href="index.php" class="hover:text-primary transition">Inicio</a>
                    <a href="Catalogocompleto.php" class="text-primary font-semibold">Cat&aacute;logo</a>
                    <a href="nosotros.php" class="hover:text-primary transition">Nosotros</a>
                    <a href="contacto.php" class="hover:text-primary transition">Contacto</a>
                </nav>
            </div>
        </div>
    </header>
    <!-- Hero -->
    <section class="bg-gradient-to-r from-pastel-pink via-pastel-cream to-pastel-yellow py-12 md:py-16">
        <div class="container mx-auto px-4 text-center">
            <div class="floating inline-block mb-4 text-5xl">🍰</div>
            <h2 class="text-3xl sm:text-4xl md:text-5xl font-display font-bold text-pastel-brown mb-4">
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
            <div class="bg-white rounded-3xl shadow-md p-4 sm:p-6 flex flex-col md:flex-row gap-4 justify-between items-center">
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
<!-- Product Modal -->
<div id="productModal"
class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 items-center justify-center p-4">

    <div class="bg-white rounded-3xl max-w-2xl w-full p-5 sm:p-8 relative max-h-[90vh] overflow-y-auto">

        <button onclick="closeProductModal()"
            class="absolute top-4 right-4 text-3xl text-gray-500 hover:text-red-500">

            &times;

        </button>

        <img id="modalImage"
            class="w-full h-64 object-cover rounded-2xl mb-6">

        <h2 id="modalName"
            class="text-3xl font-bold font-display text-pastel-brown mb-4">
        </h2>

        <p id="modalDescription"
            class="text-gray-600 mb-6">
        </p>

        <!-- Tamaño -->
        <div class="mb-5">

            <label class="block font-semibold mb-2">
                Tamaño
            </label>

            <select id="cakeSize"
                class="w-full border rounded-xl px-4 py-3">

                <option>Pesa</option>
                <option>2 Pesas</option>
                <option>3 Pesas</option>
                <option>Media libra</option>
                <option>Libra</option>
                <option>Libra y media</option>

            </select>

        </div>

        <!-- Relleno -->
        <div class="mb-5">

            <label class="block font-semibold mb-2">
                Relleno
            </label>

            <select id="cakeFill"
                class="w-full border rounded-xl px-4 py-3">

                <option>Arequipe</option>
                <option>Fresa</option>
                <option>Mora</option>
                <option>Chocolate</option>
                <option>Durazno</option>

            </select>

        </div>

        <!-- Extra -->
        <div class="mb-5">

            <label class="block font-semibold mb-2">
                Descripción adicional
            </label>

            <textarea id="extraDescription"
                rows="4"
                class="w-full border rounded-xl px-4 py-3">
            </textarea>

        </div>

        <div class="mb-5">
            <span id="modalPrice"
                class="text-2xl font-bold text-primary">
            </span>
        </div>

        <button onclick="addConfiguredProduct()"
            class="w-full bg-pastel-pink hover:bg-pink-300 text-pastel-brown font-bold py-4 rounded-full transition">

            Agregar al carrito

        </button>

    </div>

</div>
<?php include 'cart_modal.php'; ?>
<script>
        
        const catalogoData = [
            {
                id: 1,
                name: "Torta Chocolate Supreme",
                description: "Chocolate negro con relleno de ganache y frambuesas.",
                price: 55000,
                image: "https://aki-225de.kxcdn.com/wp-content/uploads/2021/01/foto-receta-pastel-chocolate.jpg",
                alt: "Torta de chocolate",
                category: "Tortas"
            },
            {
                id: 2,
                name: "Red Velvet Clásica",
                description: "Bizcocho rojo con frosting de queso crema.",
                price: 70000,
                image: "https://www.infobae.com/new-resizer/DGoMOTuyK29Gwu_0GG0rzZg4VGk=/arc-anglerfish-arc2-prod-infobae/public/52E6H6YM2NHAHHAR6S7SL47SEM.jpg",
                alt: "Torta Red Velvet",
                category: "Tortas"
            },
            {
                id: 3,
                name: "Tres Leches",
                description: "Suave, cremosa y tradicional.",
                price: 25000,
                image: "https://irecetasfaciles.com/wp-content/uploads/2019/09/pastel-tres-leches.jpg",
                alt: "Torta tres leches",
                category: "Tortas"
            },
            {
                id: 4,
                name: "Cheesecake de Frutos Rojos",
                description: "Cremoso cheesecake con cubierta de frutos rojos.",
                price: 80000,
                image: "https://cdn.recetasderechupete.com/wp-content/uploads/2018/03/Tarta-de-queso-Antonio.jpg",
                alt: "Cheesecake",
                category: "Postres"
            },
            {
                id: 5,
                name: "Cupcake de Arcoiris",
                description: "Esponjoso cupcake con topping suave de vainilla.",
                price: 12000,
                image: "https://cakemehometonight.com/wp-content/uploads/2020/08/Confetti-Cupcakes-19.jpg",
                alt: "Cupcake de arcoiris",
                category: "Cupcakes"
            },
            {
                id: 6,
                name: "Torta de Zanahoria",
                description: "Deliciosa torta de zanahoria con nueces y crema.",
                price: 37000,
                image: "https://veggiefestchicago.org/wp-content/uploads/2021/04/21-carrot-cake.jpg",
                alt: "Torta de zanahoria",
                category: "Tortas"
            },
            {
                id: 7,
                name: "Brownie Especial",
                description: "Brownie húmedo con trozos de chocolate.",
                price: 8000,
                image: "https://images.cookforyourlife.org/wp-content/uploads/2020/06/Dark-Chocolate-Brownies-shutterstock_112430981.jpg",
                alt: "Brownie",
                category: "Postres"
            },
            {
                id: 8,
                name: "Cupcake de Chocolate",
                description: "Cupcake de chocolate con cobertura cremosa.",
                price: 10000,
                image: "https://carorocco.com/wp-content/uploads/2021/09/Cupcakes-de-Chocolate-y-Cereza-IMAGEN-DESTACADA.jpg",
                alt: "Cupcake de chocolate",
                category: "Cupcakes"
            }
        ];

        const catalogGrid = document.getElementById("catalogGrid");
        const searchInput = document.getElementById("searchInput");
        const categoryFilter = document.getElementById("categoryFilter");
        window.cartRequiresLogin = true;
        window.cartUserLoggedIn = <?php echo isset($_SESSION['usuario']) ? 'true' : 'false'; ?>;
        window.cartUserKey = <?php echo isset($_SESSION['correo']) ? json_encode($_SESSION['correo']) : 'null'; ?>;
        window.cartCheckoutUrl = 'pago.php';


        function renderCatalog(products) {
            catalogGrid.innerHTML = products.map(product => `
            <div class="bg-white rounded-3xl shadow-lg overflow-hidden hover:shadow-xl transition duration-300 transform hover:-translate-y-2 flex flex-col h-full">

    <img src="${product.image}" alt="${product.alt}" class="w-full h-56 object-cover">

    <div class="p-5 flex flex-col flex-grow">

        <div class="flex justify-between items-start mb-3">
            <h3 class="text-xl font-display font-bold text-pastel-brown min-h-[48px]">
                ${product.name}
            </h3>

            <span class="bg-pastel-purple text-pastel-brown text-xs px-3 py-1 rounded-full font-semibold">
                ${product.category}
            </span>
        </div>

        <p class="text-gray-600 mb-4 text-sm min-h-[32px]">
            ${product.description}
        </p>

        <div class="flex justify-between items-center mt-auto">

            <span class="text-lg font-bold text-primary">
                $${product.price.toFixed(2)}
            </span>

           <button onclick="${
             product.category === 'Tortas'
               ? `openProductModal(${product.id})`
              : `addToCart(${product.id})`
              }"

             class="bg-pastel-brown hover:bg-secondary text-white px-4 py-2 rounded-full transition duration-300">

                ${
                 product.category === 'Tortas'
              ? 'Personalizar'
              : 'Agregar'
                }

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

        function addToCart(productId) {
            const product = catalogoData.find(p => p.id === productId);
            if (!product) return;

            Cart.addItem(product);
        }

        // Abrir modal
function openProductModal(productId) {

    const product = catalogoData.find(p => p.id === productId);

    if (!product) return;

    document.getElementById("modalImage").src = product.image;
    document.getElementById("modalName").textContent = product.name;
    document.getElementById("modalDescription").textContent = product.description;
    document.getElementById("modalPrice").textContent = `$${product.price.toFixed(2)}`;

    document.getElementById("productModal").dataset.productId = product.id;

    document.getElementById("productModal").classList.remove("hidden");
    document.getElementById("productModal").classList.add("flex");
}


// Cerrar modal
function closeProductModal() {

    document.getElementById("productModal").classList.add("hidden");
    document.getElementById("productModal").classList.remove("flex");

}
function addConfiguredProduct() {

    const productId = parseInt(
        document.getElementById("productModal").dataset.productId
    );

    const size = document.getElementById("cakeSize").value;
    const fill = document.getElementById("cakeFill").value;
    const extra = document.getElementById("extraDescription").value;

    const product = catalogoData.find(p => p.id === productId);

    if (!product) return;

    Cart.addItem(product, { size, fill, extra });
    closeProductModal();
}    </script>
</body>
</html>

