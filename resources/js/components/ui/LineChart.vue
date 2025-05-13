<template>
  <div class="chart-container">
    <canvas id="lineChart"></canvas>
  </div>
</template>

<script setup lang="ts">
import { onMounted } from 'vue';
import axios from 'axios';
import {
  Chart,
  LineElement,
  PointElement,
  LineController,
  CategoryScale,
  LinearScale,
  Title,
  Tooltip,
  Legend,
} from 'chart.js';

Chart.register(LineElement, PointElement, LineController, CategoryScale, LinearScale, Title, Tooltip, Legend);

interface StuntingData {
  waktu: string;
  total: number;
}

onMounted(async () => {
  const response = await axios.get('/api/grafik-stunting-per-bulan');
  const data: StuntingData[] = response.data;

  const labels = data.map((item: StuntingData) => item.waktu);
  const values = data.map((item: StuntingData) => item.total);

  const ctx = document.getElementById('lineChart') as HTMLCanvasElement;
  new Chart(ctx, {
    type: 'line',
    data: {
      labels,
      datasets: [{
        label: 'Jumlah Bayi Stunting',
        data: values,
        borderColor: 'rgba(255, 99, 132, 50)',
        backgroundColor: 'rgba(255, 99, 132, 50)',
        fill: true,
        tension: 0.3,
      }],
    },
    options: {
      responsive: true,
      maintainAspectRatio: false, // Allow chart to fill container
      plugins: {
        title: {
          display: true,
          text: 'Jumlah Bayi Stunting per Bulan',
        },
      },
      scales: {
        y: {
          beginAtZero: true,
        },
      },
    },
  });
});
</script>

<style scoped>
.chart-container {
  position: relative;
  width: 100%;
  height: 400px; /* Adjust this height as needed */
}

canvas {
  width: 100% !important;
  height: 100% !important;
}
</style>