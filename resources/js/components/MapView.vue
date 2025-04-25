<template>
    <div>
      <div ref="mapContainer" class="map-container"></div>
      <div ref="chartContainer" class="chart-container">
        <canvas ref="chart"></canvas>
      </div>
    </div>
  </template>

  <script setup lang="ts">
  import { ref, onMounted } from 'vue';
  import L from 'leaflet';
  import { Chart } from 'chart.js';

  const mapContainer = ref<HTMLElement | null>(null);
  const chartContainer = ref<HTMLElement | null>(null);
  const chartRef = ref<HTMLCanvasElement | null>(null);

  onMounted(() => {
    // Initialize Map
    const map = L.map(mapContainer.value as HTMLElement).setView([-4.009722, 119.627778], 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '&copy; OpenStreetMap contributors',
    }).addTo(map);

    L.marker([-4.009722, 119.627778]).addTo(map)
      .bindPopup('Parepare')
      .openPopup();

    setTimeout(() => {
      map.invalidateSize();
    }, 100);

    // Initialize Chart
    const ctx = chartRef.value?.getContext('2d');
    if (ctx) {
      new Chart(ctx, {
        type: 'bar',
        data: {
          labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May'],
          datasets: [
            {
              label: 'Data Penjualan',
              data: [12, 19, 3, 5, 2],
              backgroundColor: 'rgba(75, 192, 192, 0.2)',
              borderColor: 'rgba(75, 192, 192, 1)',
              borderWidth: 1,
            },
          ],
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
        },
      });
    }
  });
  </script>

  <style scoped>
  .map-container {
    width: 100%;
    height: 50vh;
    min-height: 400px;
  }

  .chart-container {
    width: 100%;
    height: 50vh; /* Setel ini untuk menyesuaikan tinggi grafik dengan map */
    padding: 10px 0;
  }
  </style>
