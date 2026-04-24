<?php
session_start();

//if (!isset($_SESSION['usuario'])) {
    //header("Location: login.php");
    //exit();
//}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <base target="_self">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kondorito Postres y Pasteles - Delicias para cada ocasión</title>
    <meta name="description" content="Pastelería artesanal con las mejores tortas, postres y dulces. Catálogo completo, pedidos en línea y entrega a domicilio.">
    <meta name="keywords" content="pastelería, tortas, postres, dulces, repostería, pasteles, Kondorito">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
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
            <div class="flex justify-between items-center py-4">
                <!-- Logo -->
                <div class="flex items-center">
                    <div class="w-12 h-12 rounded-full bg-pastel-yellow flex items-center justify-center mr-3">
                        <i class="fas fa-birthday-cake text-2xl text-pastel-brown"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold font-display text-pastel-brown">Kondorito</h1>
                        <p class="text-sm text-gray-600">Postres y Pasteles</p>
                    </div>
                </div>

                <!-- Desktop Navigation -->
                <nav class="hidden md:block">
                    <ul id="main-nav" class="flex space-x-8"></ul>
                </nav>

                <!-- Cart and User -->
                <div class="flex items-center space-x-4">
                    <div class="hidden md:block">
                        <a href="#" class="text-gray-700 hover:text-primary">
                            <i class="fas fa-user text-lg"></i>
                            <span class="ml-1">Mi cuenta</span>
                        </a>
                    </div>
                    <a href="#cart" id="cart-btn" class="relative bg-pastel-pink hover:bg-pink-300 transition-colors rounded-full p-3">
                        <i class="fas fa-shopping-cart text-xl text-pastel-brown"></i>
                        <span id="cart-count" class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">0</span>
                    </a>
                    
                    <!-- Mobile Menu Button -->
                    <button id="mobile-menu-btn" class="md:hidden text-2xl text-pastel-brown">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>
            </div>

            <!-- Mobile Navigation -->
            <nav id="mobile-nav" class="hidden md:hidden bg-white border-t py-4">
                <ul id="mobile-nav-list" class="space-y-3"></ul>
                <div class="mt-4 pt-4 border-t">
                    <a href="#" class="block py-2 text-gray-700 hover:text-primary">
                        <i class="fas fa-user mr-2"></i> Mi cuenta
                    </a>
                </div>
            </nav>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="relative bg-gradient-to-r from-pastel-yellow to-pastel-pink overflow-hidden">
        <div class="container mx-auto px-4 py-16 md:py-24">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div>
                    <h2 class="text-4xl md:text-5xl lg:text-6xl font-bold font-display text-pastel-brown mb-6">
                        Delicias que <span class="text-primary">endulzan</span> tu vida
                    </h2>
                    <p class="text-lg md:text-xl text-gray-700 mb-8">
                        Pastelería artesanal con los ingredientes más frescos y el sabor más auténtico. 
                        Tortas personalizadas para cada ocasión especial.
                    </p>
                    <div class="flex flex-wrap gap-4">
                       <a href="Catalogocompleto.php" target="_blank" class="bg-primary hover:bg-secondary text-white font-semibold py-3 px-8 rounded-full shadow-lg transition-all transform hover:-translate-y-1">
                         Ver catálogo completo
                        </a>
                        <a href="#order" class="bg-white hover:bg-gray-100 text-primary font-semibold py-3 px-8 rounded-full border-2 border-primary transition-all">
                            Realizar pedido
                        </a>
                    </div>
                </div>
                <div class="relative">
                     <div class="w-64 h-64 rounded-full bg-pastel-yellow flex items-center justify-center ml-40">
                        <i class="fas fa-birthday-cake text-9xl text-pastel-brown"></i>
                    </div>
                  
                </div>
            </div>
        </div>
        <div class="absolute bottom-0 left-0 right-0 h-16 bg-gradient-to-t from-pastel-cream to-transparent"></div>
    </section>

    <!-- Featured Products -->
    <section id="catalog" class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold font-display text-pastel-brown mb-4">
                    Nuestros productos destacados
                </h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    Descubre nuestra selección de tortas y postres más populares
                </p>
            </div>

            <div id="featured-products" 
              class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 mb-12">
                <!-- Featured products will be rendered here -->
                <div id="featured-products"></div>
            </div>

            <div class="text-center">
                <a href="Catalogocompleto.php" class="inline-flex items-center text-primary hover:text-secondary font-semibold text-lg">
                    Ver catálogo completo
                    <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- How to Order -->
    <section id="order" class="py-16 bg-pastel-cream">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold font-display text-pastel-brown mb-4">
                    ¿Cómo realizar tu pedido?
                </h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    Sigue estos sencillos pasos para recibir tus postres favoritos
                </p>
            </div>

            <div id="order-steps"
               class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Order steps will be rendered here -->
                <div id="order-steps"></div>
            </div>
        </div>
    </section>

    <!-- Product Categories -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold font-display text-pastel-brown mb-4">
                    Explora por categorías
                </h2>
            </div>

            <div id="product-categories"
              class="grid grid-cols-2 md:grid-cols-4 gap-6">
                <!-- Categories will be rendered here -->
                <div id="product-categories"></div>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="py-16 bg-pastel-purple">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold font-display text-pastel-brown mb-4">
                    Lo que dicen nuestros clientes
                </h2>
            </div>

            <div id="testimonials"
             class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Testimonials will be rendered here -->
                <div id="testimonials"></div>
            </div>
        </div>
    </section>


    <!-- Footer -->
    <footer class="bg-gray-900 text-white pt-12 pb-8">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                <!-- Company Info -->
                <div>
                    <div class="flex items-center mb-6">
                        <div class="w-10 h-10 rounded-full bg-pastel-yellow flex items-center justify-center mr-3">
                            <i class="fas fa-birthday-cake text-xl text-pastel-brown"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold font-display">Kondorito</h3>
                            <p class="text-sm text-gray-400">Postres y Pasteles</p>
                        </div>
                    </div>
                    <p class="text-gray-400 mb-6">
                        Pastelería artesanal con más de 10 años endulzando momentos especiales.
                    </p>
                    <div class="flex space-x-4">
                        <a href="https://www.facebook.com/p/Kondorito-postres-pasteles-100063476113980/?locale=es_LA" class="text-gray-400 hover:text-white text-xl">
                            <i class="fab fa-facebook"></i>
                        </a>
                        <a href="https://www.instagram.com/kondoritopostresypasteles/" class="text-gray-400 hover:text-white text-xl">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="https://wa.me/573155321183" class="text-gray-400 hover:text-white text-xl">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h4 class="text-lg font-bold mb-6">Enlaces rápidos</h4>
                    <ul id="footer-links" class="space-y-3"></ul>
                </div>

                <!-- Categories -->
                <div>
                    <h4 class="text-lg font-bold mb-6">Categorías</h4>
                    <ul id="footer-categories" class="space-y-3"></ul>
                </div>

                <!-- Contact -->
                <div>
                    <h4 class="text-lg font-bold mb-6">Contacto</h4>
                    <ul class="space-y-4">
                        <li class="flex items-start">
                            <i class="fas fa-map-marker-alt text-gray-400 mr-3 mt-1"></i>
                            <span class="text-gray-400">Calle 30 #8E-02 local 1, Barrio la cumbre</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-phone text-gray-400 mr-3"></i>
                            <span class="text-gray-400">6076382215</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-envelope text-gray-400 mr-3"></i>
                            <span class="text-gray-400">Pasteleriakondorito@gmail.com</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-clock text-gray-400 mr-3"></i>
                            <span class="text-gray-400">Lun-Dom: 8am-7pm</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-800 pt-8 text-center">
                <p class="text-gray-400 text-sm">
                    &copy; 2026 Kondorito Postres y Pasteles. Todos los derechos reservados.
                </p>
                <div class="mt-4 flex justify-center space-x-6 text-sm text-gray-500">
                    <a href="#" class="hover:text-white">Política de privacidad</a>
                    <a href="#" class="hover:text-white">Términos y condiciones</a>
                    <a href="#" class="hover:text-white">Política de cookies</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Cart Modal -->
    <div id="cart-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 overflow-y-auto">
        <div class="relative min-h-screen flex items-center justify-center p-4">
            <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-hidden">
                <div class="p-6 border-b">
                    <div class="flex justify-between items-center">
                        <h3 class="text-2xl font-bold font-display text-pastel-brown">
                            <i class="fas fa-shopping-cart mr-3"></i>Tu carrito
                        </h3>
                        <button id="close-cart" class="text-3xl text-gray-500 hover:text-gray-800">&times;</button>
                    </div>
                </div>
                
                <div class="p-6 overflow-y-auto max-h-[60vh]">
                    <div id="cart-items" class="space-y-4"></div>
                    <div id="empty-cart" class="text-center py-12">
                        <i class="fas fa-shopping-cart text-6xl text-gray-300 mb-4"></i>
                        <p class="text-gray-500 text-lg">Tu carrito está vacío</p>
                        <p class="text-gray-400">Agrega productos del catálogo</p>
                    </div>
                </div>
                
                <div class="p-6 border-t bg-gray-50">
                    <div class="flex justify-between items-center mb-6">
                        <span class="text-xl font-bold">Total:</span>
                        <span id="cart-total" class="text-2xl font-bold text-primary">$0.00</span>
                    </div>
                    <button id="checkout-btn" class="w-full bg-primary hover:bg-secondary text-white font-bold py-4 px-6 rounded-full transition-colors text-lg">
                        Proceder al pago
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Data Layer
        const navigationData = [
            { "label": "Inicio", "href": "#home", "icon": "fas fa-home" },
            { "label": "Catálogo", "href": "#catalog", "icon": "fas fa-book" },
            { "label": "Cómo pedir", "href": "#order", "icon": "fas fa-shopping-bag" },
            { "label": "Personalizados", "href": "#custom", "icon": "fas fa-palette" },
            { "label": "Nosotros", "href": "#about", "icon": "fas fa-users" },
            { "label": "Contacto", "href": "#contact", "icon": "fas fa-envelope" }
        ];

        const featuredProductsData = [
            { 
                "id": 1, 
                "name": "Torta Chocolate Supreme", 
                "description": "Chocolate negro con relleno de ganache y frambuesas", 
                "price": 55000, 
                "image": "https://aki-225de.kxcdn.com/wp-content/uploads/2021/01/foto-receta-pastel-chocolate.jpg", 
                "alt": "Torta de chocolate negro con frambuesas",
                "category": "Tortas"
            },
            { 
                "id": 2, 
                "name": "Red Velvet Clásica", 
                "description": "Bizcocho rojo con frosting de queso crema", 
                "price": 70000, 
                "image": "https://i0.wp.com/anandaweb.com/wp-content/uploads/2025/04/Torta-Red-Velvet-Ananda-Mediana-1.png?fit=1080%2C1080&ssl=1", 
                "alt": "Torta Red Velvet con frosting blanco",
                "category": "Tortas"
            },
            { 
                "id": 3, 
                "name": "Cheesecake de Frutos Rojos", 
                "description": "Base crujiente con frutos del bosque", 
                "price": 80000, 
                "image": "https://cdn.recetasderechupete.com/wp-content/uploads/2018/03/Tarta-de-queso-Antonio.jpg", 
                "alt": "Cheesecake con frutos rojos",
                "category": "Postres"
            },
            { 
                "id": 4, 
                "name": "Cupcakes Arcoíris", 
                "description": "Set de 12 cupcakes con diferentes colores", 
                "price": 12000, 
                "image": "https://cakemehometonight.com/wp-content/uploads/2020/08/Confetti-Cupcakes-19.jpg", 
                "alt": "Cupcakes coloridos con decoraciones",
                "category": "Postres"
            }
        ];

        const orderStepsData = [
            { 
                "step": 1, 
                "title": "Explora el catálogo", 
                "description": "Navega por nuestras categorías y encuentra tu postre favorito", 
                "icon": "fas fa-search" 
            },
            { 
                "step": 2, 
                "title": "Personaliza tu pedido", 
                "description": "Selecciona tamaño, sabores y decoraciones especiales", 
                "icon": "fas fa-sliders-h" 
            },
            { 
                "step": 3, 
                "title": "Agrega al carrito", 
                "description": "Revisa los detalles y añade al carrito de compras", 
                "icon": "fas fa-cart-plus" 
            },
            { 
                "step": 4, 
                "title": "Recibe en casa", 
                "description": "Entrega a domicilio o recoge en nuestra pastelería", 
                "icon": "fas fa-truck" 
            }
        ];

        const categoriesData = [
            { "name": "Tortas de Cumpleaños",  "color": "bg-pastel-pink", "icon": "fas fa-birthday-cake" },
            { "name": "Postres Individuales",  "color": "bg-pastel-yellow", "icon": "fas fa-cookie-bite" },
            { "name": "Tortas de Bodas",  "color": "bg-pastel-purple", "icon": "fas fa-heart" },
            { "name": "Personalizadas", "count": "∞", "color": "bg-blue-100", "icon": "fas fa-palette" },
       
        ];

        const testimonialsData = [
            { 
                "name": "María González", 
                "comment": "La mejor torta de chocolate que he probado. Mi familia quedó encantada en mi cumpleaños.", 
                "rating": 5,
                "image": "https://picsum.photos/100/100?random=6",
                "alt": "Foto de María González"
            },
            { 
                "name": "Carlos Rodríguez", 
                "comment": "Pedí una torta personalizada para mi boda y superó todas mis expectativas. ¡Increíble!", 
                "rating": 5,
                "image": "https://picsum.photos/100/100?random=7",
                "alt": "Foto de Carlos Rodríguez"
            },
            { 
                "name": "Ana López", 
                "comment": "Siempre frescos y deliciosos. Mi pedido semanal de cupcakes ya es una tradición familiar.", 
                "rating": 5,
                "image": "https://picsum.photos/100/100?random=8",
                "alt": "Foto de Ana López"
            }
        ];

        const footerLinksData = [
            { "label": "Inicio", "href": "#home" },
            { "label": "Catálogo", "href": "#catalog" },
            { "label": "Cómo pedir", "href": "#order" },
            { "label": "Personalizados", "href": "#custom" },
            { "label": "Nosotros", "href": "#about" },
            { "label": "Contacto", "href": "#contact" }
        ];

        const footerCategoriesData = [
            { "label": "Tortas de Cumpleaños", "href": "#category-birthday" },
            { "label": "Postres Individuales", "href": "#category-individual" },
            { "label": "Tortas de Bodas", "href": "#category-wedding" }
        ];

        const cartData = [];
        let cartTotal = 0;

        // Reusable Render Functions
        function renderNavigation(items) {
            return items.map(item => `
                <li>
                    <a href="${item.href}" class="flex items-center text-gray-700 hover:text-primary font-medium transition-colors">
                        <i class="${item.icon} mr-2"></i>${item.label}
                    </a>
                </li>
            `).join("");
        }

        function renderMobileNavigation(items) {
            return items.map(item => `
                <li>
                    <a href="${item.href}" class="flex items-center py-3 px-4 text-gray-700 hover:bg-gray-100 rounded-lg transition-colors">
                        <i class="${item.icon} mr-3 text-lg"></i>
                        <span class="font-medium">${item.label}</span>
                    </a>
                </li>
            `).join("");
        }

        function renderFeaturedProducts(products) {
            return products.map(product => `
                <div class="group bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="relative overflow-hidden">
                        <img src="${product.image}" alt="${product.alt}" class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-500" loading="lazy">
                        <div class="absolute top-4 right-4 bg-primary text-white px-3 py-1 rounded-full text-sm font-semibold">
                            $${product.price.toFixed(2)}
                        </div>
                    </div>
                    <div class="p-6">
                        <span class="text-sm text-gray-500 uppercase tracking-wider">${product.category}</span>
                        <h3 class="text-xl font-bold font-display text-pastel-brown mt-2 mb-3">${product.name}</h3>
                        <p class="text-gray-600 mb-4">${product.description}</p>
                        <button onclick="addToCart(${product.id})" class="w-full bg-pastel-pink hover:bg-pink-300 text-pastel-brown font-semibold py-3 rounded-full transition-colors flex items-center justify-center">
                            <i class="fas fa-cart-plus mr-2"></i> Agregar al carrito
                        </button>
                    </div>
                </div>
            `).join("");
        }

        function renderOrderSteps(steps) {
            return steps.map(step => `
                <div class="text-center">
                    <div class="w-20 h-20 rounded-full ${step.step === 1 ? 'bg-pastel-pink' : step.step === 2 ? 'bg-pastel-yellow' : step.step === 3 ? 'bg-pastel-purple' : 'bg-green-100'} flex items-center justify-center mx-auto mb-6">
                        <div class="w-16 h-16 rounded-full bg-white flex items-center justify-center">
                            <i class="${step.icon} text-3xl text-pastel-brown"></i>
                        </div>
                    </div>
                    <div class="bg-white rounded-xl p-6 shadow-lg">
                        <div class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-primary text-white font-bold text-lg mb-4">
                            ${step.step}
                        </div>
                        <h3 class="text-xl font-bold font-display text-pastel-brown mb-3">${step.title}</h3>
                        <p class="text-gray-600">${step.description}</p>
                    </div>
                </div>
            `).join("");
        }

        function renderCategories(categories) {
            return categories.map(cat => `
                <a href="#category-${cat.name.toLowerCase().replace(/ /g, '-')}" class="block group">
                    <div class="${cat.color} rounded-2xl p-6 text-center transition-all duration-300 transform group-hover:scale-105 group-hover:shadow-xl">
                        <div class="w-16 h-16 rounded-full bg-white flex items-center justify-center mx-auto mb-4">
                            <i class="${cat.icon} text-2xl text-pastel-brown"></i>
                        </div>
                        <h3 class="font-bold text-gray-800 mb-2">${cat.name}</h3>
                        
                    </div>
                </a>
            `).join("");
        }

        function renderTestimonials(testimonials) {
            return testimonials.map(testimonial => `
                <div class="bg-white rounded-2xl shadow-lg p-8">
                    <div class="flex items-center mb-6">
                        <img src="${testimonial.image}" alt="${testimonial.alt}" class="w-16 h-16 rounded-full object-cover mr-4">
                        <div>
                            <h4 class="font-bold text-lg">${testimonial.name}</h4>
                            <div class="flex text-yellow-400">
                                ${'<i class="fas fa-star"></i>'.repeat(testimonial.rating)}
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-600 italic">"${testimonial.comment}"</p>
                </div>
            `).join("");
        }

        function renderFooterLinks(links) {
            return links.map(link => `
                <li><a href="${link.href}" class="text-gray-400 hover:text-white transition-colors">${link.label}</a></li>
            `).join("");
        }

        function renderCartItems(items) {
            if (items.length === 0) {
                document.getElementById('empty-cart').classList.remove('hidden');
                return '';
            }
            
            document.getElementById('empty-cart').classList.add('hidden');
            return items.map(item => `
                <div class="flex items-center bg-gray-50 p-4 rounded-lg">
                    <div class="w-20 h-20 rounded-lg overflow-hidden mr-4">
                        <img src="${item.image}" alt="${item.name}" class="w-full h-full object-cover">
                    </div>
                    <div class="flex-grow">
                        <h4 class="font-bold text-gray-800">${item.name}</h4>
                        <p class="text-gray-600 text-sm">${item.description}</p>
                        <div class="flex items-center justify-between mt-2">
                            <div class="flex items-center">
                                <button onclick="updateQuantity(${item.id}, -1)" class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center hover:bg-gray-300">
                                    <i class="fas fa-minus text-sm"></i>
                                </button>
                                <span class="mx-4 font-bold">${item.quantity}</span>
                                <button onclick="updateQuantity(${item.id}, 1)" class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center hover:bg-gray-300">
                                    <i class="fas fa-plus text-sm"></i>
                                </button>
                            </div>
                            <span class="font-bold text-primary">$${(item.price * item.quantity).toFixed(2)}</span>
                        </div>
                    </div>
                    <button onclick="removeFromCart(${item.id})" class="ml-4 text-red-500 hover:text-red-700">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            `).join("");
        }

        // Cart Functions
        function addToCart(productId) {
            const product = featuredProductsData.find(p => p.id === productId);
            if (!product) return;

            const existingItem = cartData.find(item => item.id === productId);
            if (existingItem) {
                existingItem.quantity++;
            } else {
                cartData.push({
                    ...product,
                    quantity: 1
                });
            }

            updateCartDisplay();
            showCartNotification();
        }

        function updateQuantity(productId, change) {
            const item = cartData.find(item => item.id === productId);
            if (!item) return;

            item.quantity += change;
            if (item.quantity <= 0) {
                removeFromCart(productId);
            } else {
                updateCartDisplay();
            }
        }

        function removeFromCart(productId) {
            const index = cartData.findIndex(item => item.id === productId);
            if (index > -1) {
                cartData.splice(index, 1);
                updateCartDisplay();
            }
        }

        function updateCartDisplay() {
            const cartCount = cartData.reduce((sum, item) => sum + item.quantity, 0);
            document.getElementById('cart-count').textContent = cartCount;
            
            cartTotal = cartData.reduce((sum, item) => sum + (item.price * item.quantity), 0);
            document.getElementById('cart-total').textContent = `$${cartTotal.toFixed(2)}`;
            
            document.getElementById('cart-items').innerHTML = renderCartItems(cartData);
        }

        function showCartNotification() {
            const cartBtn = document.getElementById('cart-btn');
            cartBtn.classList.add('animate-pulse');
            setTimeout(() => cartBtn.classList.remove('animate-pulse'), 1000);
        }

        // Event Handlers
        document.addEventListener('DOMContentLoaded', function() {
            // Render all content
            document.getElementById('main-nav').innerHTML = renderNavigation(navigationData);
            document.getElementById('mobile-nav-list').innerHTML = renderMobileNavigation(navigationData);
            document.getElementById('featured-products').innerHTML = renderFeaturedProducts(featuredProductsData);
            document.getElementById('order-steps').innerHTML = renderOrderSteps(orderStepsData);
            document.getElementById('product-categories').innerHTML = renderCategories(categoriesData);
            document.getElementById('testimonials').innerHTML = renderTestimonials(testimonialsData);
            document.getElementById('footer-links').innerHTML = renderFooterLinks(footerLinksData);
            document.getElementById('footer-categories').innerHTML = renderFooterLinks(footerCategoriesData);

            // Mobile Menu Toggle
            document.getElementById('mobile-menu-btn').addEventListener('click', function() {
                const mobileNav = document.getElementById('mobile-nav');
                const icon = this.querySelector('i');
                
                mobileNav.classList.toggle('hidden');
                if (mobileNav.classList.contains('hidden')) {
                    icon.className = 'fas fa-bars';
                } else {
                    icon.className = 'fas fa-times';
                }
            });

            // Cart Modal Toggle
            document.getElementById('cart-btn').addEventListener('click', function(e) {
                e.preventDefault();
                document.getElementById('cart-modal').classList.remove('hidden');
            });

            document.getElementById('close-cart').addEventListener('click', function() {
                document.getElementById('cart-modal').classList.add('hidden');
            });

            document.getElementById('cart-modal').addEventListener('click', function(e) {
                if (e.target === this) {
                    this.classList.add('hidden');
                }
            });

            // Checkout Button
            document.getElementById('checkout-btn').addEventListener('click', function() {
                if (cartData.length === 0) {
                    alert('Tu carrito está vacío');
                    return;
                }
                alert(`¡Pedido realizado por $${cartTotal.toFixed(2)}! Te contactaremos para confirmar los detalles.`);
                cartData.length = 0;
                updateCartDisplay();
                document.getElementById('cart-modal').classList.add('hidden');
            });

            // Newsletter Form
            document.getElementById('newsletter-form').addEventListener('submit', function(e) {
                e.preventDefault();
                const email = this.querySelector('input[type="email"]').value;
                if (email) {
                    alert('¡Gracias por suscribirte! Te hemos enviado un correo de confirmación.');
                    this.reset();
                }
            });

            // Smooth Scrolling for Navigation Links
            document.addEventListener('click', function(e) {
                const link = e.target.closest('a[href^="#"]');
                if (!link) return;
                
                const href = link.getAttribute('href');
                if (href === '#') return;
                
                e.preventDefault();
                
                if (href === '#cart') {
                    document.getElementById('cart-modal').classList.remove('hidden');
                    return;
                }
                
                const target = document.querySelector(href);
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    
                    // Close mobile menu if open
                    const mobileNav = document.getElementById('mobile-nav');
                    if (!mobileNav.classList.contains('hidden')) {
                        mobileNav.classList.add('hidden');
                        document.querySelector('#mobile-menu-btn i').className = 'fas fa-bars';
                    }
                }
            });

            // Close mobile menu when clicking outside
            document.addEventListener('click', function(e) {
                const mobileNav = document.getElementById('mobile-nav');
                const menuBtn = document.getElementById('mobile-menu-btn');
                
                if (!mobileNav.classList.contains('hidden') && 
                    !mobileNav.contains(e.target) && 
                    !menuBtn.contains(e.target)) {
                    mobileNav.classList.add('hidden');
                    menuBtn.querySelector('i').className = 'fas fa-bars';
                }
            });
        });

        // Make cart functions globally available for onclick handlers
        window.addToCart = addToCart;
        window.updateQuantity = updateQuantity;
        window.removeFromCart = removeFromCart;
    </script>
</body>
</html>