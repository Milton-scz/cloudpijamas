<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';
import Graficos from '@/Components/Graficos.vue';

const page = usePage();
const ventapormes = ref(page.props.ventasPorMes);

const monthNames = [
  'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
  'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
];

// Inicializar un arreglo de ceros para todas las ventas por mes
const ventasPorMes = new Array(12).fill(0);


ventapormes.value.forEach(venta => {
  const monthIndex = venta.mes - 1; // Ajustar para que el índice de mes sea 0-11
  ventasPorMes[monthIndex] = venta.monto_total;
});


const barChartData = ref({
  labels: monthNames,
  datasets: [
    {
      label: 'Ventas por mes',
      data: ventasPorMes,
      backgroundColor: '#42A5F5',
      borderColor: '#1E88E5',
      borderWidth: 1
    }
  ]
});

const chartOptions = ref({
  responsive: true,
  plugins: {
    legend: {
      position: 'top',
    },
    tooltip: {
      callbacks: {
        label: function(tooltipItem) {
          return tooltipItem.dataset.label + ': ' + tooltipItem.raw;
        }
      }
    }
  }
});
</script>

<template>
  <Head title="Graficos" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-gray-800">
        Graficos
      </h2>
    </template>
    <div>
      <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
              <section id="contenido_principal">
                <div class="grafico-container">
                  <Graficos :type="'bar'" :chartData="barChartData" :chartOptions="chartOptions" />
                </div>
              </section>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<style scoped>
/* Estilo para los gráficos */
.grafico-container {
  width: 600px;  /* Limitar el tamaño máximo del gráfico */
  height: 650px;     /* Limitar la altura del gráfico */
  margin: 0 auto;    /* Centrar el gráfico */
}
</style>
