/**
 * JavaScript para el proceso de checkout
 */

document.addEventListener('DOMContentLoaded', function() {
    // Validar que se seleccione un método de pago
    const form = document.querySelector('form');
    const metodoPago = document.querySelectorAll('input[name="metodo_pago"]');
    
    if (form && metodoPago.length > 0) {
        form.addEventListener('submit', function(e) {
            let metodoSeleccionado = false;
            metodoPago.forEach(radio => {
                if (radio.checked) {
                    metodoSeleccionado = true;
                }
            });
            
            if (!metodoSeleccionado) {
                e.preventDefault();
                alert('Por favor selecciona un método de pago');
            }
        });
    }
});
