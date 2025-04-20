{{-- resources/views/filament/widgets/resumen-productos.blade.php --}}
<div id="carouselResumenProductos" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
        @foreach($stats as $index => $stat)
            <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $stat['label'] }}</h5>
                        <p class="card-text">{{ $stat['description'] }}</p>
                        <h3>{{ $stat['value'] }}</h3>
                        <div class="icon">
                            <!-- Aquí se puede agregar un ícono si se desea -->
                            <i class="{{ $stat['icon'] }}"></i>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <!-- Controles del carrusel -->
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselResumenProductos" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselResumenProductos" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>

<!-- Asegúrate de incluir los scripts de Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>
