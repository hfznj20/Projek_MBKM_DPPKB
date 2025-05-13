<template>
  <div class="bg-red-700 w-full">
    <Bar
      v-if="umurLabels.length"
      :data="{
        labels: umurLabels,
        datasets: [{
          label: 'Jumlah',
          data: umurData,
          backgroundColor: '#ffffff',
          borderRadius: 6
        }]
      }"
      :options="chartOptions"
    />
  </div>
</template>

<script lang="ts" setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { Bar } from 'vue-chartjs';
import {
  Chart as ChartJS,
  Title,
  Tooltip,
  Legend,
  BarElement,
  CategoryScale,
  LinearScale
} from 'chart.js';

ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale);

const umurLabels = ref<string[]>([]);
const umurData = ref<number[]>([]);

onMounted(async () => {
  try {
    const res = await axios.get('/api/baduta/umur');
    const data = res.data;

    umurLabels.value = Object.keys(data);
    umurData.value = Object.values(data);
  } catch (e) {
    console.error(e);
  }
});

const chartOptions = {
  responsive: true,
  indexAxis: 'y' as const,
  scales: {
    x: {
      grid: {
        display: false // Hilangkan garis X
      },
      ticks: {
        color: '#fff' // Warna label sumbu X
      }
    },
    y: {
      grid: {
        display: false // Hilangkan garis Y
      },
      ticks: {
        color: '#fff' // Warna label sumbu Y
      }
    }
  },
  plugins: {
    legend: { display: false },
    title: {
      display: true,
      text: 'Balita Berdasarkan Umur (Bulan)',
      color: '#fff',
      font: {
        size: 16
      }
    }
  }
};
</script>


<style scoped>
.w-full {
  width: 100%;
}

.grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 1.5rem;
}

.w-full {
  width: 100%;
}

.bg-white {
  background-color: white;
}

.p-6 {
  padding: 1.5rem;
}

.rounded-3xl {
  border-radius: 1.5rem;
}

.shadow {
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.text-5xl {
  font-size: 3rem;
}
</style>