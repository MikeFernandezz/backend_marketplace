// Funciones del carrito de compras
class CarritoManager {    constructor() {
        this.csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || 
                        document.querySelector('input[name="_token"]')?.value;
        
        // Verificar que el CSRF token esté disponible
        if (!this.csrfToken) {
            console.warn('CSRF token no encontrado. Verificar que esté incluido en el layout.');
        }
        
        this.init();
    }init() {
        document.addEventListener('DOMContentLoaded', () => {
            this.cargarCarrito();
            this.setupEventListeners();
            this.setupAgregarCarritoListeners();
        });
    }    setupAgregarCarritoListeners() {
        // Configurar event listeners para todos los botones de agregar al carrito
        document.addEventListener('click', (e) => {
            // Buscar el botón clickeado o el más cercano
            let boton = e.target;
            if (!boton.matches('button')) {
                boton = boton.closest('button');
            }
            
            // Verificar si es un botón de agregar al carrito
            if (boton && boton.hasAttribute('onclick')) {
                const onclickAttr = boton.getAttribute('onclick');
                
                if (onclickAttr && onclickAttr.includes('agregarAlCarrito')) {
                    console.log('Event listener capturó click en botón carrito');
                    e.preventDefault(); // Prevenir la ejecución del onclick
                    e.stopPropagation();
                    
                    // Extraer el ID del producto del onclick
                    const match = onclickAttr.match(/agregarAlCarrito\((\d+)\)/);
                    if (match) {
                        const productoId = parseInt(match[1]);
                        console.log('Producto ID extraído:', productoId);
                        
                        this.agregarProducto(productoId, 1).then((success) => {
                            if (success) {
                                console.log('Animando botón...');
                                this.animarBotonAgregar(boton);
                            }
                        }).catch((error) => {
                            console.error('Error en promise:', error);
                        });
                    }
                }
            }
        }, true); // Usar captura para interceptar antes del onclick
    }

    setupEventListeners() {
        // Ajustar posición del carrito en resize
        window.addEventListener('resize', () => this.ajustarPosicionCarrito());
        this.ajustarPosicionCarrito();

        // Manejar clicks fuera del carrito en móviles
        document.addEventListener('click', (e) => {
            const carrito = document.getElementById('carritoMenu');
            const botonCarrito = document.getElementById('dropdownCarrito');
            
            if (carrito && botonCarrito && 
                !carrito.contains(e.target) && 
                !botonCarrito.contains(e.target) && 
                window.innerWidth <= 768) {
                this.cerrarCarrito();
            }
        });
    }

    ajustarPosicionCarrito() {
        const carritoMenu = document.getElementById('carritoMenu');
        const screenWidth = window.innerWidth;
        
        if (carritoMenu) {
            if (screenWidth <= 576) {
                carritoMenu.style.right = '10px';
                carritoMenu.style.left = 'auto';
                carritoMenu.style.transform = 'none';
                carritoMenu.style.maxWidth = 'calc(100vw - 20px)';
            } else if (screenWidth <= 768) {
                carritoMenu.style.right = '5px';
                carritoMenu.style.left = 'auto';
                carritoMenu.style.transform = 'none';
                carritoMenu.style.maxWidth = 'calc(100vw - 30px)';
            } else {
                carritoMenu.style.right = '0';
                carritoMenu.style.left = 'auto';
                carritoMenu.style.transform = 'none';
                carritoMenu.style.maxWidth = '350px';
            }
        }
    }

    cerrarCarrito() {
        const carritoMenu = document.getElementById('carritoMenu');
        const dropdownCarrito = document.getElementById('dropdownCarrito');
        
        if (carritoMenu && dropdownCarrito) {
            carritoMenu.classList.remove('show');
            dropdownCarrito.classList.remove('show');
        }
    }    async agregarProducto(productoId, cantidad = 1) {
        console.log('Agregando producto:', productoId, 'cantidad:', cantidad);
        
        try {
            const response = await fetch('/carrito/agregar', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': this.csrfToken,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    producto_id: productoId,
                    cantidad: cantidad
                })
            });

            console.log('Response status:', response.status, response.ok);
            const data = await response.json();
            console.log('Response data:', data);
            
            if (response.ok && data.success) {
                this.actualizarContadorCarrito(data.carrito_count);
                this.mostrarMensajeExito('Producto agregado al carrito');
                return true;
            } else {
                this.mostrarMensajeError(data.message || 'Error al agregar producto al carrito');
                return false;
            }
        } catch (error) {
            console.error('Error completo:', error);
            this.mostrarMensajeError('Error de conexión al agregar producto al carrito');
            return false;
        }
    }

    async cargarCarrito() {
        try {
            const response = await fetch('/carrito/obtener');
            const data = await response.json();
            this.actualizarCarrito(data);
        } catch (error) {
            console.error('Error:', error);
        }
    }

    actualizarCarrito(data) {
        const contenido = document.getElementById('carrito-contenido');
        const footer = document.getElementById('carrito-footer');
        const total = document.getElementById('carrito-total');
        
        this.actualizarContadorCarrito(data.cantidad_total);
        
        if (data.carrito.length === 0) {
            contenido.innerHTML = `
                <div class="p-3 text-center text-muted">
                    <i class="bi bi-cart-x" style="font-size: 2rem;"></i>
                    <p class="mb-0 mt-2">Tu carrito está vacío</p>
                </div>
            `;
            footer.style.display = 'none';
        } else {
            let html = '';
            data.carrito.forEach(item => {
                html += this.generarItemCarrito(item);
            });
            contenido.innerHTML = html;
            total.textContent = parseFloat(data.total).toFixed(2);
            footer.style.display = 'block';
        }
    }    generarItemCarrito(item) {
        const imagenSrc = item.imagen ? `/img/productos/${item.imagen}` : '/img/webres/placeholder.jpg';
        return `
            <div class="d-flex align-items-center p-3 border-bottom carrito-item" data-producto-id="${item.id}">
                <img src="${imagenSrc}" 
                     alt="${item.nombre}" 
                     class="rounded" 
                     style="width: 50px; height: 50px; object-fit: cover;"
                     onerror="this.src='/img/webres/placeholder.jpg'; console.log('Error imagen carrito:', '${imagenSrc}');">
                <div class="flex-grow-1 ms-3">
                    <h6 class="mb-1 small">${item.nombre}</h6>
                    <p class="mb-0 text-muted small">Curso digital</p>
                </div>
                <div class="text-end">
                    <div class="fw-bold small">$${parseFloat(item.precio).toFixed(2)}</div>
                    <button class="btn btn-sm btn-outline-danger" onclick="carritoManager.eliminarProducto(${item.id})" title="Eliminar">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
            </div>
        `;
    }    async eliminarProducto(productoId) {
        try {
            const response = await fetch(`/carrito/eliminar/${productoId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': this.csrfToken,
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            const data = await response.json();
            this.actualizarCarrito(data);
            this.mostrarMensajeExito('Producto eliminado del carrito');
        } catch (error) {
            console.error('Error:', error);
        }
    }

    async vaciarCarrito() {
        if (confirm('¿Estás seguro de que quieres vaciar tu carrito?')) {
            try {
                const response = await fetch('/carrito/vaciar', {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': this.csrfToken,
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                const data = await response.json();
                if (data.success) {
                    this.actualizarCarrito({carrito: [], total: 0, cantidad_total: 0});
                    this.mostrarMensajeExito('Carrito vaciado');
                }
            } catch (error) {
                console.error('Error:', error);
            }
        }
    }

    actualizarContadorCarrito(cantidad) {
        const contador = document.getElementById('carrito-contador');
        if (contador) {
            contador.textContent = cantidad || 0;
            contador.style.display = cantidad > 0 ? 'inline' : 'none';
        }
    }    animarBotonAgregar(boton) {
        if (!boton || boton.disabled) return;
        
        const textoOriginal = boton.innerHTML;
        const clasesOriginales = boton.className;
        
        boton.innerHTML = '<i class="bi bi-check-circle-fill me-2"></i>¡Agregado!';
        boton.className = boton.className.replace(/btn-outline-\w+|btn-\w+/g, '').trim() + ' btn-success';
        boton.disabled = true;
        
        setTimeout(() => {
            boton.innerHTML = textoOriginal;
            boton.className = clasesOriginales;
            boton.disabled = false;
        }, 2000);
    }

    mostrarMensajeExito(mensaje) {
        this.mostrarToast(mensaje, 'success');
    }

    mostrarMensajeError(mensaje) {
        this.mostrarToast(mensaje, 'danger');
    }

    mostrarToast(mensaje, tipo) {
        const toast = document.createElement('div');
        const icono = tipo === 'success' ? 'bi-check-circle-fill' : 'bi-exclamation-triangle-fill';
        
        toast.className = `alert alert-${tipo} position-fixed`;
        toast.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 250px; max-width: calc(100vw - 40px);';
        toast.innerHTML = `
            <i class="bi ${icono} me-2"></i>${mensaje}
            <button type="button" class="btn-close float-end" onclick="this.parentElement.remove()"></button>
        `;
        
        document.body.appendChild(toast);
        
        setTimeout(() => {
            if (toast.parentElement) {
                toast.remove();
            }
        }, 3000);
    }
}

// Inicializar el manager del carrito
const carritoManager = new CarritoManager();

// Funciones globales para compatibilidad (respaldo)
function agregarAlCarrito(productoId, cantidad = 1) {
    // Esta función actúa como respaldo si el event listener automático no funciona
    console.log('Usando función global agregarAlCarrito como respaldo');
    
    carritoManager.agregarProducto(productoId, cantidad).then((success) => {
        console.log('Producto agregado:', success);
    }).catch((error) => {
        console.error('Error al agregar producto:', error);
    });
}

function cargarCarrito() {
    carritoManager.cargarCarrito();
}

function eliminarDelCarrito(productoId) {
    carritoManager.eliminarProducto(productoId);
}

function vaciarCarrito() {
    carritoManager.vaciarCarrito();
}
