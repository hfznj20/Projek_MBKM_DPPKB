<!-- SHOW -->
<script setup lang="ts">
import { onMounted, ref } from 'vue'
import { usePage } from '@inertiajs/vue3'
import { Chart, registerables } from 'chart.js'
import AppLayout from '@/layouts/AppLayout.vue'
import type { BreadcrumbItem } from '@/types'
import Index from '@/pages/Penduduk/Index.vue'
import { PageProps } from '@inertiajs/inertia'

Chart.register(...registerables) // Only register the default Chart.js modules

const canvasRef = ref<HTMLCanvasElement | null>(null)
const genderCanvasRef = ref<HTMLCanvasElement | null>(null)

interface TPK {
  nama: string
  kelurahan: string
  kecamatan: string
}

interface Props extends PageProps {
  tpk: TPK
  dataInput: Record<string, number>
  genderCount: Record<string, number>
  penduduks: Penduduk[]
}

interface Penduduk {
  id: number
  nama: string
  nik: string
  jenis_kelamin: string
  kategori: string
  alamat: string
}

const props = usePage<Props>().props
const tpk = props.tpk
const dataInput = props.dataInput
const genderCount = props.genderCount
const penduduks = ref(props.penduduks)

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
<h2 class="text-xl font-semibold mb-4 mt-5 text-center">Inputan TPK Dalam Angka</h2>
    <!-- Container Semua Card -->
<div class="flex flex-wrap gap-4 ml-10">

  <!-- Card Penduduk (warna: #3b82f6) -->
  <div class="bg-[#3b82f6]/20 shadow rounded-lg p-3 w-44 border border-[#3b82f6]">
    <h2 class="text-xl font-semibold text-[#3b82f6] mb-2 text-center">Penduduk</h2>
    <p class="text-[#1e3a8a] text-4xl font-bold text-center">{{ dataInput.penduduk }}</p>
    
  </div>

  <!-- Card Bumil (warna: #10b981) -->
  <div class="bg-[#10b981]/20 shadow rounded-lg p-3 w-44 border border-[#10b981]">
    <h2 class="text-xl font-semibold text-[#10b981] mb-2 text-center">Bumil</h2>
    <p class="text-[#065f46] text-4xl font-bold text-center">{{ dataInput.bumil }}</p>
  </div>

  <!-- Card Catin (warna: #f59e0b) -->
  <div class="bg-[#f59e0b]/20 shadow rounded-lg p-3 w-44 border border-[#f59e0b]">
    <h2 class="text-xl font-semibold text-[#f59e0b] mb-2 text-center">Catin</h2>
    <p class="text-[#b45309] text-4xl font-bold text-center">{{ dataInput.catin }}</p>
  </div>

  <!-- Card Baduta (warna: #ef4444) -->
  <div class="bg-[#ef4444]/20 shadow rounded-lg p-3 w-44 border border-[#ef4444]">
    <h2 class="text-xl font-semibold text-[#ef4444] mb-2 text-center">Baduta</h2>
    <p class="text-[#991b1b] text-4xl font-bold text-center">{{ dataInput.baduta }}</p>
  </div>

  <!-- Card Pasper (warna: #8b5cf6) -->
  <div class="bg-[#8b5cf6]/20 shadow rounded-lg p-3 w-44 border border-[#8b5cf6]">
    <h2 class="text-xl font-semibold text-[#8b5cf6] mb-2 text-center">Pasper</h2>
    <p class="text-[#6b21a8] text-4xl font-bold text-center">{{ dataInput.pasper }}</p>
  </div>

  <!-- Card Gender -->
  <div class="bg-pink-100 shadow rounded-lg p-3 w-44 border border-[#5b1414]">
    <h2 class="text-xl font-semibold text-pink-800 mb-2 text-center">Gender</h2>
    <div class="text-sm text-pink-900 space-y-1 font-bold text-center">
      <div class="flex justify-between">
        <span>Laki:</span>
        <span>{{ genderCount.Laki }}</span>
      </div>
      <div class="flex justify-between">
        <span>Perempuan:</span>
        <span>{{ genderCount.Perempuan }}</span>
      </div>
    </div>
  </div>
</div>
</div>
    <!-- Tabel Penduduk -->
   
      <h2 class="text-xl font-semibold mb-4 mt-5 text-center">Daftar Data Penduduk Inputan TPK</h2>
      
     <div class="overflow-x-auto rounded-xl border border-orange-300">
    <table class="w-full text-left bg-white rounded-xl overflow-hidden">
      <thead class="bg-orange-500 text-white">
        <tr>
          <th class="p-3">No</th>
          <th class="p-3">Nama</th>
          <th class="p-3">NIK</th>
          <th class="p-3">Jenis Kelamin</th>
          <th class="p-3">Kategori</th>
          <th class="p-3">Alamat</th>
        </tr>
      </thead>
      <tbody>
        <tr
          v-for="(p, i) in penduduks"
          :key="p.id"
          :class="i % 2 === 1 ? 'bg-orange-50' : ''"
          class="border-b border-orange-200"
        >
          <td class="p-3">{{ i + 1 }}</td>
          <td class="p-3">{{ p.nama }}</td>
          <td class="p-3">{{ p.nik }}</td>
          <td class="p-3">{{ p.jenis_kelamin }}</td>
          <td class="p-3">{{ p.kategori }}</td>
          <td class="p-3">{{ p.alamat }}</td>
        </tr>
      </tbody>
    </table>
  </div>
  </AppLayout>
</template>