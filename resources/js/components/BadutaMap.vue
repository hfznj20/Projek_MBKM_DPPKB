<template>
    <div id="map" class="w-full h-[500px]"></div>
  </template>

  <script setup lang="ts">
  import { onMounted } from 'vue'
  import L from 'leaflet'
  import 'leaflet/dist/leaflet.css'
  import axios from 'axios'

  onMounted(async () => {
    const map = L.map('map').setView([-4.016, 119.630], 13) // Koordinat tengah Indonesia

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '© OpenStreetMap contributors'
    }).addTo(map)

    const response = await axios.get('/api/baduta-locations')
    const locations = response.data

   locations.forEach((item: any) => {
  if (item.latitude && item.longitude) {
    const popupContent = `
      <div>
        <strong>Nama Baduta:</strong> ${item.nama}<br>
        <button onclick="window.location='/baduta/${item.penduduk_nik}'" style="margin-top: 8px; padding: 4px 8px; background: #4CAF50; color: white; border: none; border-radius: 4px; cursor: pointer;">
          Detail
        </button>
      </div>
    `

    L.marker([item.latitude, item.longitude])
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