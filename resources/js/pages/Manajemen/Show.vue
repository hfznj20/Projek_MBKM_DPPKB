<!-- SHOW -->
<script setup lang="ts">
import { onMounted, ref } from 'vue'
import { usePage } from '@inertiajs/vue3'
import { Chart, registerables } from 'chart.js'
import AppLayout from '@/layouts/AppLayout.vue'
import type { BreadcrumbItem } from '@/types'
import Index from '@/pages/Penduduk/Index.vue'

Chart.register(...registerables) // Only register the default Chart.js modules

const canvasRef = ref<HTMLCanvasElement | null>(null)
const genderCanvasRef = ref<HTMLCanvasElement | null>(null)

interface TPK {
  nama: string
  kelurahan: string
  kecamatan: string
}

interface Props {
  tpk: TPK
  dataInput: Record<string, number>
  genderCount: Record<string, number>
}

const props = usePage<Props>().props
const tpk = props.tpk
const dataInput = props.dataInput
const genderCount = props.genderCount

const breadcrumbs: BreadcrumbItem[] = [
  { title: 'Manajemen User', href: '/manajemen' },
  { title: 'Detail TPK ${tpk.nama}', href: '#' }
]

onMounted(() => {
  const genderCtx = genderCanvasRef.value?.getContext('2d')
  if (genderCtx) {
    new Chart(genderCtx, {
      type: 'pie',
      data: {
        labels: ['Laki-laki', 'Perempuan'],
        datasets: [{
          data: [genderCount['Laki'], genderCount['Perempuan']],
          backgroundColor: ['#60a5fa', '#f472b6'],
          borderWidth: 3,
          hoverOffset: 10,
        }]
      },
      options: {
        responsive: true,
        animation: {
          animateRotate: true,
          animateScale: true
        },
        plugins: {
          tooltip: {
            callbacks: {
              label: (tooltipItem) => {
                return '${tooltipItem.label}: ${tooltipItem.raw}'
              }
            }
          }
        }
      }
    })
  }

  const ctx = canvasRef.value?.getContext('2d')
  if (!ctx) return

  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: ['Penduduk', 'Bumil', 'Catin', 'Baduta', 'Pasper'],
      datasets: [{
        label: 'Jumlah Inputan',
        data: [
          dataInput.penduduk,
          dataInput.bumil,
          dataInput.catin,
          dataInput.baduta,
          dataInput.pasper
        ],
        backgroundColor: [
          '#3b82f6',
          '#10b981',
          '#f59e0b',
          '#ef4444',
          '#8b5cf6'
        ],
        borderWidth: 2,
        hoverBackgroundColor: '#60a5fa',
      }]
    },
    options: {
      responsive: true,
      scales: {
        y: {
          beginAtZero: true
        }
      },
      animation: {
        easing: 'easeInOutBounce'
      }
    }
  })
})
</script>

<template>
  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="p-6 space-y-8">
      <h1 class="text-4xl font-bold text-gray-800">Kinerja TPK: {{ tpk.nama }}</h1>
      <p class="text-lg text-gray-600">Kelurahan: {{ tpk.kelurahan }}, Kecamatan: {{ tpk.kecamatan }}</p>

      <!-- Chart Section -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Bar Chart -->
        <div class="bg-white p-6 rounded-lg shadow-lg">
          <canvas ref="canvasRef" class="w-full h-72"></canvas>
        </div>

        <!-- Pie Chart -->
        <div class="bg-white p-6 rounded-lg shadow-lg">
          <h2 class="text-xl font-semibold mb-4 text-gray-700">Diagram Jenis Kelamin Penduduk</h2>
          <canvas ref="genderCanvasRef" class="w-72 h-72 mx-auto"></canvas>
        </div>
      </div>

      <!-- Data Table Section -->
      <div class="mt-8 bg-white p-6 rounded-lg shadow-lg">
        <h2 class="text-xl font-semibold mb-4 text-gray-700">Detail Jumlah Inputan</h2>
        <table class="min-w-full table-auto border-collapse text-sm text-gray-800">
          <thead class="bg-orange-500 text-white">
            <tr>
              <th class="px-4 py-3 border border-orange-400 text-left">Kategori</th>
              <th class="px-4 py-3 border border-orange-400 text-left">Jumlah</th>
            </tr>
          </thead>
          <tbody>
            <tr class="hover:bg-orange-50">
              <td class="px-4 py-2 border border-orange-200">Penduduk</td>
              <td class="px-4 py-2 border border-orange-200">{{ dataInput.penduduk }}</td>
            </tr>
            <tr class="hover:bg-orange-50">
              <td class="px-4 py-2 border border-orange-200">Bumil</td>
              <td class="px-4 py-2 border border-orange-200">{{ dataInput.bumil }}</td>
            </tr>
            <tr class="hover:bg-orange-50">
              <td class="px-4 py-2 border border-orange-200">Catin</td>
              <td class="px-4 py-2 border border-orange-200">{{ dataInput.catin }}</td>
            </tr>
            <tr class="hover:bg-orange-50">
              <td class="px-4 py-2 border border-orange-200">Baduta</td>
              <td class="px-4 py-2 border border-orange-200">{{ dataInput.baduta }}</td>
            </tr>
            <tr class="hover:bg-orange-50">
              <td class="px-4 py-2 border border-orange-200">Pasper</td>
              <td class="px-4 py-2 border border-orange-200">{{ dataInput.pasper }}</td>
            </tr>
            <tr class="hover:bg-orange-50">
              <td class="px-4 py-2 border border-orange-200">Laki-Laki</td>
              <td class="px-4 py-2 border border-orange-200">{{ genderCount.Laki }}</td>
            </tr>
            <tr class="hover:bg-orange-50">
              <td class="px-4 py-2 border border-orange-200">Perempuan</td>
              <td class="px-4 py-2 border border-orange-200">{{ genderCount.Perempuan }}</td>
            </tr>
          </tbody>
        </table>
      </div>
      
      <div class="mt-8 bg-white p-6 rounded-lg shadow-lg">
        <h2 class="text-xl font-semibold mb-4 text-gray-700">Detail Inputan</h2>
        <!-- <Index/> -->
      </div>
    </div>
  </AppLayout>
</template>