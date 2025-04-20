import './bootstrap';
import Chart from 'chart.js/auto'; // Solo importa Chart.js una vez

document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('miGrafico').getContext('2d'); // ID del canvas
    new Chart(ctx, {
        type: 'line', // Tipo de gráfico
        data: {
            labels: ['Enero', 'Febrero', 'Marzo', 'Abril'], // Meses
            datasets: [{
                label: 'Ventas Mensuales',
                data: [1000, 1500, 2000, 1800], // Valores de ventas
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
});
