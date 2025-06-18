// Script de debug para el carrito de compras
console.log('Debug carrito inicializado');

// Verificar que el manager está disponible
setTimeout(() => {
    if (typeof carritoManager !== 'undefined') {
        console.log('✓ CarritoManager está disponible');
        
        // Verificar CSRF token
        if (carritoManager.csrfToken) {
            console.log('✓ CSRF Token encontrado:', carritoManager.csrfToken.substring(0, 10) + '...');
        } else {
            console.log('✗ CSRF Token NO encontrado');
        }
        
        // Verificar botones de carrito
        const botonesCarrito = document.querySelectorAll('button[onclick*="agregarAlCarrito"]');
        console.log('✓ Botones de carrito encontrados:', botonesCarrito.length);
        
        // Verificar elementos del carrito
        const carritoElementos = {
            contador: document.getElementById('carrito-contador'),
            contenido: document.getElementById('carrito-contenido'),
            footer: document.getElementById('carrito-footer'),
            total: document.getElementById('carrito-total')
        };
        
        Object.entries(carritoElementos).forEach(([nombre, elemento]) => {
            if (elemento) {
                console.log(`✓ Elemento ${nombre} encontrado`);
            } else {
                console.log(`✗ Elemento ${nombre} NO encontrado`);
            }
        });
        
    } else {
        console.log('✗ CarritoManager NO está disponible');
    }
}, 1000);

// Función de prueba manual
window.testAgregarCarrito = function(productoId) {
    console.log('=== PRUEBA MANUAL ===');
    console.log('Intentando agregar producto:', productoId);
    
    if (typeof carritoManager !== 'undefined') {
        carritoManager.agregarProducto(productoId, 1).then((success) => {
            console.log('Resultado:', success ? 'ÉXITO' : 'FALLO');
        }).catch((error) => {
            console.log('Error en prueba:', error);
        });
    } else {
        console.log('CarritoManager no disponible para prueba');
    }
};

console.log('Para probar manualmente, usar: testAgregarCarrito(ID_PRODUCTO)');
