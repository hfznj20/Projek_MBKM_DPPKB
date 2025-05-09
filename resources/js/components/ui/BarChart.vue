<template>
  <div>
    <h2 class="text-xl font-bold mb-4">Distribusi Data per Kecamatan</h2>
    <canvas id="kategoriChart" height="100"></canvas>
  </div>
</template>

<script setup lang="ts">
import { onMounted, ref } from 'vue'
import axios from 'axios'
import {
  Chart,
  BarElement,
  CategoryScale,
  LinearScale,
  Tooltip,
  Legend,
  Title
} from 'chart.js'

Chart.register(BarElement, CategoryScale, LinearScale, Tooltip, Legend, Title)

const dataPerKecamatan = ref<any[]>([])

const colors = {
  BADUTA: 'rgba(255, 99, 132, 0.7)',
  BUMIL: 'rgba(255, 206, 86, 0.7)',
  CATIN: 'rgba(54, 162, 235, 0.7)',
  Pasca_Persalinan: 'rgba(153, 102, 255, 0.7)',
  Penduduk: 'rgba(75, 192, 192, 0.7)',
}

onMounted(async () => {
  const response = await axios.get('/api/kategori-per-kecamatan')
  dataPerKecamatan.value = response.data

  const labels = dataPerKecamatan.value.map((item) => item.kecamatan)

  const chartData = {
    labels,
    datasets: [
      {
        label: 'BADUTA',
        data: dataPerKecamatan.value.map((item) => item.BADUTA),
        backgroundColor: colors.BADUTA
      },
      {
        label: 'BUMIL',
        data: dataPerKecamatan.value.map((item) => item.BUMIL),
        backgroundColor: colors.BUMIL
      },
      {
        label: 'CATIN',
        data: dataPerKecamatan.value.map((item) => item.CATIN),
        backgroundColor: colors.CATIN
      },
      {
        label: 'Pasca Persalinan',
        data: dataPerKecamatan.value.map((item) => item.Pasca_Persalinan),
        backgroundColor: colors.Pasca_Persalinan
      },
      {
        label: 'Penduduk',
        data: dataPerKecamatan.value.map((item) => item.Penduduk),
        backgroundColor: colors.Penduduk
      }
    ]
  }

  const ctx = document.getElementById('kategoriChart') as HTMLCanvasElement
  new Chart(ctx, {
    type: 'bar',
    data: chartData,
    options: {
      responsive: true,
      interaction: {
        mode: 'index',
        intersect: false
      },
      plugins: {
        title: {
          display: true,
          text: 'Jumlah Data per Kecamatan'
        },
        tooltip: {
          mode: 'index',
          intersect: false
        }
      },
      scales: {
        x: {
          stacked: false
        },
        y: {
          stacked: false,
          beginAtZero: true
        }
      }
    }
  })
})
</script>