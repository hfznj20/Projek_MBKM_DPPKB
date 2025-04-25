<script setup lang="ts">
import {
  Chart as ChartJS,
  Title,
  Tooltip,
  Legend,
  LineElement,
  PointElement,
  CategoryScale,
  LinearScale,
  ChartOptions,
  ChartData,
} from 'chart.js';
import { Line } from 'vue-chartjs';

// LINE CHART PERKEMBANGAN

ChartJS.register(Title, Tooltip, Legend, LineElement, PointElement, CategoryScale, LinearScale);

// Data sementara kosong untuk stunting
const chartData: ChartData<'line'> = {
  labels: [], // Label kosong, nanti diisi dengan data waktu (misalnya bulan atau tahun)
  datasets: [
    {
      label: 'Persentase Stunting',
      borderColor: '#FF5733', // Bisa diganti warna sesuai tema
      backgroundColor: 'rgba(255, 87, 51, 0.2)', // Warna transparan
      tension: 0.3, // Kurva sedikit melengkung
      data: [], // Data kosong, akan diisi dari API atau props
      fill: true, // Isi area grafik dengan warna transparan
    },
  ],
};

// Opsi konfigurasi chart
const chartOptions: ChartOptions<'line'> = {
  responsive: true,
  plugins: {
    legend: {
      position: 'top',
    },
    title: {
      display: true,
      text: 'Tren Persentase Stunting',
    },
  },
};
</script>

<template>
  <Line :data="chartData" :options="chartOptions" />
</template>
