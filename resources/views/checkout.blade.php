@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="bi bi-cart-check me-2"></i>Finalizar Compra</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('checkout.procesar') }}">
                        @csrf
                          <!-- Resumen del pedido -->
                        <div class="mb-4">
                            <h5 class="border-bottom pb-2">Resumen del Pedido</h5>
                            @foreach($carrito as $item)                                <div class="d-flex align-items-center py-3 border-bottom">                                    <img src="{{ $item['imagen'] ? asset('img/productos/' . $item['imagen']) : asset('img/webres/placeholder.jpg') }}" 
                                         alt="{{ $item['nombre'] }}" 
                                         class="rounded me-3" 
                                         style="width: 80px; height: 80px; object-fit: cover;"
                                         onerror="this.src='{{ asset('img/webres/placeholder.jpg') }}'">
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">{{ $item['nombre'] }}</h6>
                                        <div class="text-muted small">
                                            Curso digital
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <strong>${{ number_format($item['precio'], 2) }}</strong>
                                    </div>
                                </div>
                            @endforeach
                            
                            <div class="d-flex justify-content-between align-items-center mt-3 pt-3 border-top">
                                <h5 class="mb-0">Total:</h5>
                                <h4 class="mb-0 text-primary">${{ number_format($total, 2) }}</h4>
                            </div>
                        </div>                        <!-- Método de pago -->
                        <div class="mb-4">
                            <h5 class="border-bottom pb-2">Método de Pago</h5>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="metodo_pago" id="tarjeta" value="tarjeta" {{ old('metodo_pago') == 'tarjeta' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="tarjeta">
                                            <i class="bi bi-credit-card me-2"></i>Tarjeta de Crédito/Débito
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="metodo_pago" id="paypal" value="paypal" {{ old('metodo_pago') == 'paypal' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="paypal">
                                            <i class="bi bi-paypal me-2"></i>PayPal
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="metodo_pago" id="transferencia" value="transferencia" {{ old('metodo_pago') == 'transferencia' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="transferencia">
                                            <i class="bi bi-bank me-2"></i>Transferencia Bancaria
                                        </label>
                                    </div>
                                </div>
                            </div>
                            @error('metodo_pago')
                                <div class="text-danger small mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Botones de acción -->
                        <div class="d-flex justify-content-between">
                            <a href="/" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left me-2"></i>Continuar Comprando
                            </a>
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="bi bi-check-circle me-2"></i>Confirmar Compra
                            </button>                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link href="{{ asset('css/checkout.css') }}" rel="stylesheet">
@endpush

@push('scripts')
<script src="{{ asset('js/checkout.js') }}"></script>
@endpush
