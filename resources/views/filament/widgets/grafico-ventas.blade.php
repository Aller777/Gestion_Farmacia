<!-- Asegúrate de que este script está antes del cierre de body -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div id="miGrafico" style="width: 100%; height: 400px;" 
    data-labels="{{ json_encode($labels ?? []) }}" 
    data-data="{{ json_encode($data ?? []) }}">
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('miGrafico').getContext('2d');

        const labels = JSON.parse(document.getElementById('miGrafico').getAttribute('data-labels'));
        const data = JSON.parse(document.getElementById('miGrafico').getAttribute('data-data'));

        console.log(labels);  // Verifica que los labels estén correctos
        console.log(data);    // Verifica que los datos estén correctos

        // Verifica si hay datos antes de crear el gráfico
        if (labels.length > 0 && data.length > 0) {
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Ventas Mensuales',
                        data: data,
                        borderColor: 'rgba(75, 192, 192, 1)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        fill: true,
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                    },
                },
            });
        } else {
            console.log("No hay datos para mostrar el gráfico.");
        }
    });
</script>
