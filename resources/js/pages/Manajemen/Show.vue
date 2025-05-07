<script setup lang="ts">
import { onMounted, ref } from 'vue'
import { usePage } from '@inertiajs/vue3'
import type { PageProps } from '@inertiajs/core'
import { Chart, registerables } from 'chart.js'


Chart.register(...registerables)

const canvasRef = ref<HTMLCanvasElement | null>(null)

interface TPK {
  nama: string
  kelurahan: string
  kecamatan: string
}

const genderCanvasRef = ref<HTMLCanvasElement | null>(null)


interface Props extends PageProps {
  tpk: TPK
  dataInput: Record<string, number>
  genderCount: Record<string, number>
}
const props = usePage<Props>().props
const tpk = props.tpk
const dataInput = props.dataInput
const genderCount = props.genderCount

onMounted(() => {
    const genderCtx = genderCanvasRef.value?.getContext('2d')
if (genderCtx) {
  new Chart(genderCtx, {
    type: 'pie',
    data: {
      labels: ['Laki-laki', 'Perempuan'],
      datasets: [{
        data: [genderCount['Laki'], genderCount['Perempuan']],
        backgroundColor: ['#60a5fa', '#f472b6']
      }]
    },
    options: {
      responsive: true
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
        borderWidth: 2
      }]
    },
    options: {
      responsive: true,
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  })
})


</script>

<template>
  <div class="p-6 space-y-6">
    <h1 class="text-2xl font-bold">Kinerja TPK: {{ tpk.nama }}</h1>
    <p class="text-gray-600">Kelurahan: {{ tpk.kelurahan }}, Kecamatan: {{ tpk.kecamatan }}</p>

    <canvas ref="canvasRef" class="w-full max-w-xl h-64"></canvas>

    <div class="mt-8">
  <h2 class="text-xl font-semibold mb-2">Diagram Jenis Kelamin Penduduk</h2>
  <canvas ref="genderCanvasRef" class="w-64 h-64 mx-auto"></canvas>

</div>

    <div class="mt-8">

      <h2 class="text-xl font-semibold mb-2">Detail Jumlah Inputan</h2>
      <table class="w-full text-left border border-gray-300">
        <thead class="bg-gray-100">
          <tr>
            <th class="p-2 border">Kategori</th>
            <th class="p-2 border">Jumlah</th>
          </tr>
        </thead>
        <tbody>
          <tr><td class="p-2 border">Penduduk</td><td class="p-2 border">{{ dataInput.penduduk }}</td></tr>
          <tr><td class="p-2 border">Bumil</td><td class="p-2 border">{{ dataInput.bumil }}</td></tr>
          <tr><td class="p-2 border">Catin</td><td class="p-2 border">{{ dataInput.catin }}</td></tr>
          <tr><td class="p-2 border">Baduta</td><td class="p-2 border">{{ dataInput.baduta }}</td></tr>
          <tr><td class="p-2 border">Pasper</td><td class="p-2 border">{{ dataInput.pasper }}</td></tr>
          <tr><td class="p-2 border">Laki-Laki</td><td class="p-2 border">{{ genderCount.Laki }}</td></tr>
          <tr><td class="p-2 border">Perempuan</td><td class="p-2 border">{{ genderCount.Perempuan }}</td></tr>
        </tbody>
      </table>


    </div>
  </div>
</template>