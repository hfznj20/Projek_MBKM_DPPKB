<template>
  <div>
    <Line :data="chartData" :options="chartOptions" />
  </div>
</template>

<script setup lang="ts">
import {
  Chart as ChartJS,
  Title,
  Tooltip,
  Legend,
  LineElement,
  CategoryScale,
  LinearScale,
  PointElement,
} from 'chart.js';
import { Line } from 'vue-chartjs';
import { computed } from 'vue';

// Registrasi plugin Chart.js
ChartJS.register(Title, Tooltip, Legend, LineElement, CategoryScale, LinearScale, PointElement);

// Tipe data kunjungan BUMIL
interface Kunjungan {
  tanggal_kunjungan: string;
  usia_kehamilan: number;
  berat_badan_saat_ini: string;
  indeks_massa_tubuh: string;
  kadar_hemoglobin: string;
  LILA: string;
}

const props = defineProps<{
  kunjungan: Kunjungan[];
}>();

// Data grafik
const chartData = computed(() => {
  const labels = props.kunjungan.map(item => `${item.tanggal_kunjungan} (${item.usia_kehamilan} minggu)`);
  const berat = props.kunjungan.map(item => Number(item.berat_badan_saat_ini));
  const imt = props.kunjungan.map(item => Number(item.indeks_massa_tubuh));
  const hb = props.kunjungan.map(item => Number(item.kadar_hemoglobin));
  const lila = props.kunjungan.map(item => Number(item.LILA));

  return {
    labels,
    datasets: [
      {
        label: 'Berat Badan (kg)',
        data: berat,
        borderColor: 'rgba(54, 162, 235, 1)',
        backgroundColor: 'rgba(54, 162, 235, 0.2)',
        tension: 0.3,
      },
      {
        label: 'IMT',
        data: imt,
        borderColor: 'rgba(255, 206, 86, 1)',
        backgroundColor: 'rgba(255, 206, 86, 0.2)',
        tension: 0.3,
      },
      {
        label: 'Kadar Hemoglobin (g/dL)',
        data: hb,
        borderColor: 'rgba(75, 192, 192, 1)',
        backgroundColor: 'rgba(75, 192, 192, 0.2)',
        tension: 0.3,
      },
      {
        label: 'LILA (cm)',
        data: lila,
        borderColor: 'rgba(153, 102, 255, 1)',
        backgroundColor: 'rgba(153, 102, 255, 0.2)',
        tension: 0.3,
      },
    ],
  };
});

// Opsi grafik
const chartOptions = {
  responsive: true,
  plugins: {
    legend: {
      position: 'top' as const,
    },
    title: {
      display: true,
      text: 'Grafik Perkembangan BUMIL',
    },
  },
};
</script>
