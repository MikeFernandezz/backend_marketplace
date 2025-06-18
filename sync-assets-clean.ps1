# Script para sincronizar archivos CSS y JS modulares
# Ejecutar desde la raiz del proyecto Laravel

Write-Host "Sincronizando archivos CSS y JS modulares..." -ForegroundColor Green

# Crear directorios si no existen
$directories = @(
    "public\css\admin",
    "public\css\ventas"
)

foreach ($dir in $directories) {
    if (!(Test-Path $dir)) {
        New-Item -Path $dir -ItemType Directory -Force
        Write-Host "Creado directorio: $dir" -ForegroundColor Yellow
    }
}

# Copiar archivos CSS
$cssFiles = @{
    "resources\css\admin\usuarios.css" = "public\css\admin\usuarios.css"
    "resources\css\producto-detalle.css" = "public\css\producto-detalle.css"
    "resources\css\checkout.css" = "public\css\checkout.css"
    "resources\css\detalle-compra.css" = "public\css\detalle-compra.css"
    "resources\css\mis-compras.css" = "public\css\mis-compras.css"
    "resources\css\ventas\ventas-shared.css" = "public\css\ventas\ventas-shared.css"
    "resources\css\ventas\venta-detalle.css" = "public\css\ventas\venta-detalle.css"
}

foreach ($source in $cssFiles.Keys) {
    $destination = $cssFiles[$source]
    if (Test-Path $source) {
        Copy-Item $source $destination -Force
        Write-Host "Copiado: $source -> $destination" -ForegroundColor Green
    } else {
        Write-Host "No encontrado: $source" -ForegroundColor Red
    }
}

# Copiar archivos JS
$jsFiles = @{
    "resources\js\producto-detalle.js" = "public\js\producto-detalle.js"
    "resources\js\checkout.js" = "public\js\checkout.js"
    "resources\js\detalle-compra.js" = "public\js\detalle-compra.js"
}

foreach ($source in $jsFiles.Keys) {
    $destination = $jsFiles[$source]
    if (Test-Path $source) {
        Copy-Item $source $destination -Force
        Write-Host "Copiado: $source -> $destination" -ForegroundColor Green
    } else {
        Write-Host "No encontrado: $source" -ForegroundColor Red
    }
}

Write-Host "Sincronizacion completada!" -ForegroundColor Cyan
Write-Host ""
Write-Host "Archivos sincronizados:" -ForegroundColor Yellow
Write-Host "   CSS: $($cssFiles.Count) archivos" -ForegroundColor White
Write-Host "   JS:  $($jsFiles.Count) archivos" -ForegroundColor White
Write-Host ""
Write-Host "Tip: Ejecuta este script cada vez que modifiques archivos en resources/" -ForegroundColor Blue
