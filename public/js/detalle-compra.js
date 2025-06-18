/**
 * JavaScript para el detalle de compras
 */

/**
 * Función para descargar recibo (placeholder)
 */
function descargarRecibo() {
    // Por ahora solo mostrar un mensaje, aquí se podría implementar la generación de PDF
    alert('Función de descarga de PDF próximamente disponible.\n\nPor el momento puedes usar la opción de imprimir.');
}

/**
 * Auto-scroll al mensaje de éxito cuando la página carga
 */
document.addEventListener('DOMContentLoaded', function() {
    const alert = document.querySelector('.alert-success');
    if (alert) {
        alert.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }
});
