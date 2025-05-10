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
  
  ChartJS.register(Title, Tooltip, Legend, LineElement, CategoryScale, LinearScale, PointElement);
  
  interface Kunjungan {
    tanggal_kunjungan: string;
    berat_badan: number;
    tinggi_badan: number;
  }
  
  const props = defineProps<{
    kunjungan: Kunjungan[];
  }>();
  
  const chartData = computed(() => {
    const labels = props.kunjungan.map(item => item.tanggal_kunjungan);
    const berat = props.kunjungan.map(item => item.berat_badan);
    const tinggi = props.kunjungan.map(item => item.tinggi_badan);
  
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
          label: 'Tinggi Badan (cm)',
          data: tinggi,
          borderColor: 'rgba(255, 99, 132, 1)',
          backgroundColor: 'rgba(255, 99, 132, 0.2)',
          tension: 0.3,
        },
      ],
    };
  });
  
  const chartOptions = {
    responsive: true,
    plugins: {
      legend: {
        position: 'top' as const,
      },
      title: {
        display: true,
        text: 'Perkembangan Baduta',
      },
    },
  };
  </script>
  