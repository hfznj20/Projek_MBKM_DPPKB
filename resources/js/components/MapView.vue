<template>
  <div ref="mapContainer" class="map-container"></div>
</template>

<script setup lang="ts">
import { ref, onMounted, onBeforeUnmount } from 'vue';
import L from 'leaflet';

const mapContainer = ref<HTMLElement | null>(null);
let map: L.Map | null = null;
let resizeObserver: ResizeObserver | null = null;

// Lokasi di sekitar Parepare
const locations = [
  { name: 'Soreang', coords: [-4.009722, 119.627778] },
  { name: 'Ujung', coords: [-4.012000, 119.620000] },
  { name: 'Bacukiki', coords: [-4.015000, 119.640000] },
  { name: 'Bacukiki Barat', coords: [-4.020000, 119.630000] },
  { name: 'Lompoe', coords: [-4.005000, 119.610000] },
];

onMounted(() => {
  if (mapContainer.value) {
    map = L.map(mapContainer.value).setView([-4.009722, 119.627778], 13);

    // Tile layer
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '&copy; OpenStreetMap contributors',
    }).addTo(map);

    // Custom red marker icon
    const redIcon = L.icon({
      iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-red.png',
      shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/images/marker-shadow.png',
      iconSize: [25, 41],
      iconAnchor: [12, 41],
      popupAnchor: [1, -34],
      shadowSize: [41, 41],
    });

    // Tambahkan marker
    locations.forEach(loc => {
      L.marker(loc.coords as [number, number], { icon: redIcon })
        .addTo(map!)
        .bindPopup(loc.name);
    });

    // Observer ukuran kontainer
    resizeObserver = new ResizeObserver(() => {
      map?.invalidateSize();
    });

    resizeObserver.observe(mapContainer.value);
  }
});

onBeforeUnmount(() => {
  // Cleanup saat komponen dihancurkan
  if (resizeObserver && mapContainer.value) {
    resizeObserver.unobserve(mapContainer.value);
  }

  if (map) {
    map.remove();
  }
});
</script>

<style scoped>
.map-container {
  width: 100%;
  height: 100%;
  min-height: 400px;
}
</style>
