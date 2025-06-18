/**
 * JavaScript para el detalle de productos
 */

/**
 * Funcionalidad de compra de productos
 * @param {number} productoId - ID del producto a comprar
 */
function comprarProducto(productoId) {
    // Mostrar confirmación estilizada
    if (confirm('¿Deseas proceder con la compra de este curso?\n\nSerás redirigido al proceso de pago.')) {
        // Por el momento, mostrar un mensaje
        alert('Funcionalidad de compra será implementada próximamente.\nProducto ID: ' + productoId);
        
        // Aquí se implementará la lógica de compra
        console.log('Comprando producto con ID:', productoId);
    }
}

/**
 * Agregar producto al carrito
 * @param {number} productoId - ID del producto a agregar
 */
function agregarAlCarrito(productoId) {
    // Esta función se define globalmente en el contexto de la vista
    // ya que depende de la sesión del usuario autenticado
    if (typeof window.agregarAlCarrito === 'function') {
        window.agregarAlCarrito(productoId, 1);
    } else {
        console.error('Función agregarAlCarrito no disponible');
    }
}

/**
 * Expandir imagen del producto en modal
 */
function expandImage() {
    const img = document.querySelector('.product-main-image');
    const modal = document.createElement('div');
    modal.className = 'modal fade';
    modal.innerHTML = `
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0">
                    <img src="${img.src}" class="img-fluid w-100" alt="${img.alt}">
                </div>
            </div>
        </div>
    `;
    document.body.appendChild(modal);
    const bootstrapModal = new bootstrap.Modal(modal);
    bootstrapModal.show();
    
    modal.addEventListener('hidden.bs.modal', () => {
        document.body.removeChild(modal);
    });
}
