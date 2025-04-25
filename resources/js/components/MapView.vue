<template>
  <div ref="mapContainer" class="map-container"></div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue';
import L from 'leaflet';

const mapContainer = ref<HTMLElement | null>(null);

onMounted(() => {
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
});
</script>

<style scoped>
.map-container {
  width: 100%;
  height: 100%;
  min-height: 400px; /* tinggi minimum agar selalu terlihat */
}
</style>