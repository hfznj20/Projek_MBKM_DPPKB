<template>
  <div id="map" class="w-full h-[500px]"></div>
</template>

<script setup lang="ts">
import { onMounted } from 'vue'
import L from 'leaflet'
import 'leaflet/dist/leaflet.css'
import axios from 'axios'

onMounted(async () => {
  const map = L.map('map').setView([-4.016, 119.630], 13)

  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© OpenStreetMap contributors'
  }).addTo(map)

  const response = await axios.get('/api/baduta-locations')
  const locations = response.data

  locations.forEach((item: any) => {
    if (item.latitude && item.longitude) {
      // Pilih warna marker berdasarkan kategori
      const markerColor = item.kategori === 'BUMIL' ? 'gold' : 'blue'

const icon = L.icon({
  iconUrl: `https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-${markerColor}.png`,
  iconSize: [25, 41],
  iconAnchor: [12, 41],
  popupAnchor: [1, -34],
  shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/images/marker-shadow.png',
  shadowSize: [41, 41]
})

      const popupContent = `
        <div>
          <strong>Nama:</strong> ${item.nama}<br>
          <strong>Kategori:</strong> ${item.kategori}<br>
          <button onclick="window.location='/${item.kategori.toLowerCase()}/${item.penduduk_nik}'" style="margin-top: 8px; padding: 4px 8px; background: #4CAF50; color: white; border: none; border-radius: 4px; cursor: pointer;">
            Detail
          </button>
        </div>
      `

      L.marker([item.latitude, item.longitude], { icon })
        .addTo(map)
        .bindPopup(popupContent)
    }
  })
})
</script>

<style>
#map {
  height: 500px;
}
</style>