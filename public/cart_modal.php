<!-- Cart Modal -->
<div id="cart-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 overflow-y-auto">
    <div class="relative min-h-screen flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-hidden">
            <div class="p-6 border-b">
                <div class="flex justify-between items-center">
                    <h3 class="text-2xl font-bold font-display text-pastel-brown">
                        <i class="fas fa-shopping-cart mr-3"></i>Tu carrito
                    </h3>
                    <button id="close-cart" class="text-3xl text-gray-500 hover:text-gray-800">
                        &times;
                    </button>
                </div>
            </div>

            <div class="p-6 overflow-y-auto max-h-[60vh]">
                <div id="cart-items" class="space-y-4"></div>
                <div id="empty-cart" class="text-center py-12">
                    <i class="fas fa-shopping-cart text-6xl text-gray-300 mb-4"></i>
                    <p class="text-gray-500 text-lg">Tu carrito est&aacute; vac&iacute;o</p>
                    <p class="text-gray-400">Agrega productos del cat&aacute;logo</p>
                </div>
            </div>

            <div class="p-6 border-t bg-gray-50">
                <div class="flex justify-between items-center mb-6">
                    <span class="text-xl font-bold">Total:</span>
                    <span id="cart-total" class="text-2xl font-bold text-primary">$0.00</span>
                </div>
                <button id="checkout-btn" class="w-full bg-pastel-brown hover:bg-secondary text-white py-4 rounded-full font-semibold transition">
                    Proceder al pago
                </button>
            </div>
        </div>
    </div>
</div>
