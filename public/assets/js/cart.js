(function () {
    const LEGACY_STORAGE_KEY = 'cart';

    function getStorageKey() {
        return window.cartUserKey ? `cart:${window.cartUserKey}` : 'cart:guest';
    }

    function readItems() {
        try {
            const items = JSON.parse(localStorage.getItem(getStorageKey()));
            return Array.isArray(items) ? items : [];
        } catch (error) {
            return [];
        }
    }

    function makeKey(item) {
        return [
            item.id,
            item.size || '',
            item.fill || '',
            item.extra || ''
        ].join('|');
    }

    function normalizeItem(item) {
        return {
            ...item,
            quantity: Number(item.quantity) || 1,
            cartKey: item.cartKey || makeKey(item)
        };
    }

    function escapeHtml(value) {
        return String(value || '')
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    function getItems() {
        return readItems().map(normalizeItem);
    }

    function saveItems(items) {
        localStorage.setItem(getStorageKey(), JSON.stringify(items.map(normalizeItem)));
    }

    function mergeItems(baseItems, incomingItems) {
        const mergedItems = baseItems.map(normalizeItem);

        incomingItems.map(normalizeItem).forEach((incomingItem) => {
            const existingItem = mergedItems.find((item) => item.cartKey === incomingItem.cartKey);

            if (existingItem) {
                existingItem.quantity += incomingItem.quantity;
            } else {
                mergedItems.push(incomingItem);
            }
        });

        return mergedItems;
    }

    function migrateGuestCart() {
        if (!window.cartUserKey) {
            return;
        }

        const guestKey = 'cart:guest';
        const userKey = getStorageKey();

        if (guestKey === userKey) {
            return;
        }

        try {
            const guestItems = JSON.parse(localStorage.getItem(guestKey));

            if (!Array.isArray(guestItems) || guestItems.length === 0) {
                return;
            }

            const userItems = getItems();
            localStorage.setItem(userKey, JSON.stringify(mergeItems(userItems, guestItems)));
            localStorage.removeItem(guestKey);
        } catch (error) {
            localStorage.removeItem(guestKey);
        }
    }

    function getCount() {
        return getItems().reduce((sum, item) => sum + item.quantity, 0);
    }

    function getTotal() {
        return getItems().reduce((sum, item) => sum + (Number(item.price) * item.quantity), 0);
    }

    function updateBadges() {
        const count = getCount();
        document.querySelectorAll('#cart-count, [data-cart-count], [data-cart-button] span').forEach((badge) => {
            badge.textContent = count;
        });
    }

    function renderItems() {
        const cartItems = document.getElementById('cart-items');
        const emptyCart = document.getElementById('empty-cart');
        const items = getItems();

        if (!cartItems) {
            return;
        }

        if (items.length === 0) {
            if (emptyCart) {
                emptyCart.classList.remove('hidden');
            }
            cartItems.innerHTML = '';
            return;
        }

        if (emptyCart) {
            emptyCart.classList.add('hidden');
        }

        cartItems.innerHTML = items.map((item) => {
            const encodedKey = encodeURIComponent(item.cartKey);

            return `
            <div class="flex items-center bg-gray-50 p-4 rounded-lg">
                <div class="w-20 h-20 rounded-lg overflow-hidden mr-4">
                    <img src="${escapeHtml(item.image)}" alt="${escapeHtml(item.name || 'Producto')}" class="w-full h-full object-cover">
                </div>
                <div class="flex-grow">
                    <h4 class="font-bold text-gray-800">${escapeHtml(item.name || 'Producto')}</h4>
                    <p class="text-gray-600 text-sm">${escapeHtml(item.description)}</p>
                    <p class="text-xs text-gray-500 mt-1">Tama&ntilde;o: ${escapeHtml(item.size || 'Normal')}</p>
                    <p class="text-xs text-gray-500">Relleno: ${escapeHtml(item.fill || 'Ninguno')}</p>
                    <p class="text-xs text-gray-500">${escapeHtml(item.extra)}</p>
                    <div class="flex items-center justify-between mt-2">
                        <div class="flex items-center">
                            <button onclick="Cart.updateQuantity(decodeURIComponent('${encodedKey}'), -1)" class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center hover:bg-gray-300">
                                <i class="fas fa-minus text-sm"></i>
                            </button>
                            <span class="mx-4 font-bold">${item.quantity}</span>
                            <button onclick="Cart.updateQuantity(decodeURIComponent('${encodedKey}'), 1)" class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center hover:bg-gray-300">
                                <i class="fas fa-plus text-sm"></i>
                            </button>
                        </div>
                        <span class="font-bold text-primary">$${(Number(item.price) * item.quantity).toFixed(2)}</span>
                    </div>
                </div>
                <button onclick="Cart.removeItem(decodeURIComponent('${encodedKey}'))" class="ml-4 text-red-500 hover:text-red-700">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        `;
        }).join('');
    }

    function updateDisplay() {
        const cartTotal = document.getElementById('cart-total');

        updateBadges();
        renderItems();

        if (cartTotal) {
            cartTotal.textContent = `$${getTotal().toFixed(2)}`;
        }
    }

    function pulse() {
        document.querySelectorAll('#cart-btn, [data-cart-button]').forEach((button) => {
            button.classList.add('animate-pulse');
            setTimeout(() => button.classList.remove('animate-pulse'), 1000);
        });
    }

    function addItem(product, options = {}) {
        const nextItem = normalizeItem({
            ...product,
            ...options,
            quantity: Number(options.quantity) || 1
        });

        const items = getItems();
        const existingItem = items.find((item) => item.cartKey === nextItem.cartKey);

        if (existingItem) {
            existingItem.quantity += nextItem.quantity;
        } else {
            items.push(nextItem);
        }

        saveItems(items);
        localStorage.removeItem(LEGACY_STORAGE_KEY);
        migrateGuestCart();
        updateDisplay();
        pulse();
    }

    function updateQuantity(cartKey, change) {
        const items = getItems();
        const item = items.find((currentItem) => currentItem.cartKey === cartKey);

        if (!item) {
            return;
        }

        item.quantity += change;

        saveItems(items.filter((currentItem) => currentItem.quantity > 0));
        updateDisplay();
    }

    function removeItem(cartKey) {
        saveItems(getItems().filter((item) => item.cartKey !== cartKey));
        updateDisplay();
    }

    function open() {
        const modal = document.getElementById('cart-modal');

        if (modal) {
            modal.classList.remove('hidden');
        } else {
            window.location.href = 'Catalogocompleto.php#cart';
        }
    }

    function close() {
        const modal = document.getElementById('cart-modal');

        if (modal) {
            modal.classList.add('hidden');
        }
    }

    function checkout() {
        if (getItems().length === 0) {
            alert('Tu carrito esta vacio');
            return;
        }

        if (window.cartRequiresLogin && !window.cartUserLoggedIn) {
            alert('Debes iniciar sesion para continuar con tu pedido');
            window.location.href = 'login.php';
            return;
        }

        window.location.href = window.cartCheckoutUrl || 'pago.php';
    }

    function init() {
        document.querySelectorAll('#cart-btn, [data-cart-button]').forEach((button) => {
            button.addEventListener('click', (event) => {
                event.preventDefault();
                open();
            });
        });

        const closeButton = document.getElementById('close-cart');
        if (closeButton) {
            closeButton.addEventListener('click', close);
        }

        const modal = document.getElementById('cart-modal');
        if (modal) {
            modal.addEventListener('click', (event) => {
                if (event.target === modal) {
                    close();
                }
            });
        }

        const checkoutButton = document.getElementById('checkout-btn');
        if (checkoutButton) {
            checkoutButton.addEventListener('click', checkout);
        }

        updateDisplay();

        if (window.location.hash === '#cart') {
            open();
        }
    }

    window.Cart = {
        addItem,
        updateQuantity,
        removeItem,
        updateDisplay,
        updateBadges,
        getItems,
        getCount,
        getTotal,
        open,
        close,
        checkout,
        pulse,
        init
    };

    window.openCart = open;
    window.closeCart = close;

    document.addEventListener('DOMContentLoaded', init);
})();
