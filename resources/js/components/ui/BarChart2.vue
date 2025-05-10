<template>
  <div>
    <canvas id="stuntingChart" height="100"></canvas>
  </div>
</template>

<script setup lang="ts">
import { onMounted } from 'vue'
import axios from 'axios'
import {
  Chart,
  BarElement,
  CategoryScale,
  LinearScale,
  Tooltip,
  Legend,
  Title,
  BarController
} from 'chart.js'

Chart.register(BarController, BarElement, CategoryScale, LinearScale, Tooltip, Legend, Title)

onMounted(async () => {
  const response = await axios.get('/api/grafik-stunting')
  const result = response.data

  const labels = ['Ya', 'Tidak'] // X-axis = status stunting

  // Map data per kategori dan status
  const badutaData = { 'Ya': 0, 'Tidak': 0 }
  const bumilData = { 'Ya': 0, 'Tidak': 0 }

  result.forEach((item: any) => {
    if (item.kategori === 'Baduta') {
      badutaData[item.stunting] = item.total
    } else if (item.kategori === 'Bumil') {
      bumilData[item.stunting] = item.total
    }
  })

  const ctx = document.getElementById('stuntingChart') as HTMLCanvasElement

  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: labels,
      datasets: [
        {
          label: 'Baduta',
          data: [badutaData['Ya'], badutaData['Tidak']],
          backgroundColor:  'rgba(255, 99, 132, 50)'
        },
        {
          label: 'Bumil',
          data: [bumilData['Ya'], bumilData['Tidak']],
          backgroundColor: 'rgba(255, 206, 86, 50)'
        }
      ]
    },
    options: {
      responsive: true,
      plugins: {
        title: {
          display: true,
          text: 'Jumlah Status Stunting Baduta dan Bumil'
        },
        legend: {
          position: 'top'
        }
      },
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  })
})
</script>
