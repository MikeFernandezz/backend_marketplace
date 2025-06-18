// Script temporal para debug de imágenes del carrito
console.log('=== DEBUG CARRITO IMÁGENES ===');

// Verificar que las rutas de imagen sean correctas
function verificarImagenCarrito() {
    const itemsCarrito = document.querySelectorAll('.carrito-item img');
    
    itemsCarrito.forEach((img, index) => {
        console.log(`Imagen ${index + 1}:`, {
            src: img.src,
            alt: img.alt,
            existe: img.complete && img.naturalHeight !== 0
        });
          // Si la imagen no carga, usar placeholder
        img.onerror = function() {
            console.log('Error cargando imagen:', this.src);
            this.src = '/img/webres/placeholder.jpg';
        };
    });
}

// Verificar imágenes del checkout
function verificarImagenCheckout() {
    const itemsCheckout = document.querySelectorAll('.checkout img');
    
    itemsCheckout.forEach((img, index) => {
        console.log(`Imagen checkout ${index + 1}:`, {
            src: img.src,
            alt: img.alt,
            existe: img.complete && img.naturalHeight !== 0
        });
          img.onerror = function() {
            console.log('Error cargando imagen checkout:', this.src);
            this.src = '/img/webres/placeholder.jpg';
        };
    });
}

// Ejecutar verificaciones cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', function() {
    setTimeout(() => {
        verificarImagenCarrito();
        verificarImagenCheckout();
    }, 1000);
});

// Verificar imágenes cada vez que se actualice el carrito
const originalActualizarCarrito = window.carritoManager?.actualizarCarrito;
if (originalActualizarCarrito) {
    window.carritoManager.actualizarCarrito = function(data) {
        originalActualizarCarrito.call(this, data);
        setTimeout(verificarImagenCarrito, 100);
    };
}
