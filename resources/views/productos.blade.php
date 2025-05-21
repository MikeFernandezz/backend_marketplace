<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Productos</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="container">
        <h1>Lista de Productos</h1>

        <form id="productoForm" method="POST" action="{{ route('productos.store') }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" id="productoId" name="id">
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" name="nombre" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="descripcion">Descripción</label>
                <textarea id="descripcion" name="descripcion" class="form-control" required></textarea>
            </div>
            <div class="form-group">
                <label for="precio">Precio</label>
                <input type="number" id="precio" name="precio" class="form-control" step="0.01" required>
            </div>
            <div class="form-group">
                <label for="archivo">Archivo</label>
                <input type="text" id="archivo" name="archivo" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Guardar</button>
        </form>

        <table class="table mt-4">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Precio</th>
                    <th>Archivo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($productos as $producto)
                    <tr>
                        <td>{{ $producto->id }}</td>
                        <td>{{ $producto->nombre }}</td>
                        <td>{{ $producto->descripcion }}</td>
                        <td>{{ $producto->precio }}</td>
                        <td><a href="{{ asset('storage/' . $producto->archivo) }}" target="_blank">Ver archivo</a></td>
                        <td>
                            <button class="btn btn-warning btn-sm" onclick="editarProducto({{ $producto }})">Editar</button>
                            <form method="POST" action="{{ route('productos.destroy', $producto->id) }}" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script>
        function editarProducto(producto) {
            document.getElementById('productoId').value = producto.id;
            document.getElementById('nombre').value = producto.nombre;
            document.getElementById('descripcion').value = producto.descripcion;
            document.getElementById('precio').value = producto.precio;
            document.getElementById('productoForm').action = `{{ url('productos') }}/${producto.id}`;
            document.getElementById('productoForm').method = 'POST';
            const methodInput = document.createElement('input');
            methodInput.type = 'hidden';
            methodInput.name = '_method';
            methodInput.value = 'PUT';
            document.getElementById('productoForm').appendChild(methodInput);
        }
    </script>
</body>
</html>
