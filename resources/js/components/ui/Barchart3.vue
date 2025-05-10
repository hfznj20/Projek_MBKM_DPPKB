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

// BARCHAR PERKEMBANGAN

ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale);

// Data sementara kosong
const chartData: ChartData<'bar'> = {
  labels: [], // Label kosong, nanti diisi dengan data waktu (misalnya bulan atau tahun)
  datasets: [
    {
      label: 'Jumlah Pengunjung',
      backgroundColor: '#3b82f6',
      data: [], // Data kosong, akan diisi nanti
    },
  ],
};

const chartOptions: ChartOptions<'bar'> = {
  responsive: true,
  plugins: {
    legend: {
      position: 'top',
    },
    title: {
      display: true,
      text: '', 
    },
  },
};
</script>

<template>
  <Bar :data="chartData" :options="chartOptions" />
</template>
