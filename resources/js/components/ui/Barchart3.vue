<script setup lang="ts">
import {
  Chart as ChartJS,
  Title,
  Tooltip,
  Legend,
  BarElement,
  CategoryScale,
  LinearScale,
  ChartOptions,
  ChartData,
} from 'chart.js';
import { Bar } from 'vue-chartjs';

// Register Chart.js components
ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale);

// Data setup
const chartData: ChartData<'bar'> = {
  labels: [], // Labels will be populated later
  datasets: [
    {
      label: 'Jumlah Pengunjung',
      backgroundColor: '#3b82f6',
      data: [], // Data will be populated later
    },
  ],
};

const chartOptions: ChartOptions<'bar'> = {
  responsive: true,
  maintainAspectRatio: false, // Allow chart to fill the container
  plugins: {
    legend: {
      position: 'top',
    },
    title: {
      display: true,
      text: 'Jumlah Pengunjung per Waktu', // Set an appropriate title
    },
  },
  scales: {
    y: {
      beginAtZero: true,
    },
  },
};
</script>

<template>
  <div class="chart-container">
    <Bar :data="chartData" :options="chartOptions" />
  </div>
</template>

<style scoped>
.chart-container {
  position: relative;
  width: 100%;
  height: 400px; /* Adjust this height as needed */
}
</style>