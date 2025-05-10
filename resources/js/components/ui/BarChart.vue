<template>
    <div>
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
    Title,
    BarController
  } from 'chart.js'

  Chart.register(BarController,BarElement, CategoryScale, LinearScale, Tooltip, Legend, Title)

  const dataPerKecamatan = ref<any[]>([])

  const colors = {
    BADUTA: 'rgba(255, 99, 132, 50)',
    BUMIL: 'rgba(255, 206, 86, 50)',
    CATIN: 'rgba(54, 162, 235, 50)',
    Pasca_Persalinan: 'rgba(153, 102, 255, 50)',
    Penduduk: 'rgba(75, 192, 192, 50)',
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
data: dataPerKecamatan.value.map((item) => item['Pasca Persalinan']),
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
            text: 'Jumlah Data Kategori Per-Kecamatan'
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