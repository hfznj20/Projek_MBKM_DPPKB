<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue'
import { Head, usePage } from '@inertiajs/vue3'
import { computed, onMounted } from 'vue'

import L from 'leaflet'


interface Penduduk {
  nik: string
  nama: string
  tanggal_lahir: string
  alamat: string
  jenis_kelamin: string
}

interface Baduta {
  id: number
  stunting: string
  berat_badan: number
  tinggi_badan: number
  anak: Penduduk
  ibu: Penduduk
  jumlah_anak_kandung: string
  tanggal_lahir_anak_terakhir: string
  umur_kehamilan_saat_lahir: string
  menggunakan_alat_kontrasepsi: string
  sumber_air_minum: string
  fasilitas_BAB: string
  asi_eksklusif: string
  imunisasi_hepatitis_B: string
  meerokok_terpapar: string
  fasilitas_bantuan_sosial: string
  penyuluhan_KIE: string
  kehadiran_posyandu: string
  urutan_anak: string
  latitude: number
  longitude: number
}

const page = usePage()
const baduta = computed(() => page.props.baduta as Baduta)
onMounted(() => {
  if (baduta.value.latitude && baduta.value.longitude) {
    const map = L.map('map').setView(
      [baduta.value.latitude, baduta.value.longitude],
      15
    )

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '© OpenStreetMap contributors',
    }).addTo(map)

    L.marker([baduta.value.latitude, baduta.value.longitude]).addTo(map)
      .bindPopup('Lokasi Anak')
      .openPopup()
  }
})
</script>

<template>
  <Head title="Detail Baduta" />

  <AppLayout>
    <div class="container mt-4" v-if="baduta">
      <h3 class="mb-4">Detail Baduta</h3>

      <h5>Biodata Anak</h5>
      <p><strong>NIK:</strong> {{ baduta.anak?.nik }}</p>
      <p><strong>Nama:</strong> {{ baduta.anak?.nama }}</p>
      <p><strong>Tanggal Lahir:</strong> {{ baduta.anak?.tanggal_lahir }}</p>
      <p><strong>Alamat:</strong> {{ baduta.anak?.alamat }}</p>
      <p><strong>Jenis Kelamin:</strong> {{ baduta.anak?.jenis_kelamin }}</p>
      <p><strong>Berat Badan:</strong> {{ baduta.berat_badan }} kg</p>
      <p><strong>Tinggi Badan:</strong> {{ baduta.tinggi_badan }} cm</p>
      <p><strong>Status Stunting:</strong> {{ baduta.stunting }}</p>

      <h5 class="mt-4">Biodata Ibu</h5>
      <p><strong>NIK:</strong> {{ baduta.ibu?.nik }}</p>
      <p><strong>Nama:</strong> {{ baduta.ibu?.nama }}</p>
      <p><strong>Alamat:</strong> {{ baduta.ibu?.alamat }}</p>
      <p><strong>Jumlah Anak Kandung:</strong> {{ baduta.jumlah_anak_kandung }}</p>
      <p><strong>Tanggal Lahir Anak Terakhir:</strong> {{ baduta.tanggal_lahir_anak_terakhir }}</p>
      <p><strong>Umur Kehamilan Saat Lahir:</strong> {{ baduta.umur_kehamilan_saat_lahir }}</p>
      <p><strong>Menggunakan Alat Kontrasepsi:</strong> {{ baduta.menggunakan_alat_kontrasepsi }}</p>

      <h5 class="mt-4">Informasi Tambahan</h5>
      <p><strong>Sumber Air Minum:</strong> {{ baduta.sumber_air_minum }}</p>
      <p><strong>Fasilitas BAB:</strong> {{ baduta.fasilitas_BAB }}</p>
      <p><strong>ASI Eksklusif:</strong> {{ baduta.asi_eksklusif }}</p>
      <p><strong>Imunisasi Hepatitis B:</strong> {{ baduta.imunisasi_hepatitis_B }}</p>
      <p><strong>Merokok/Terpapar Rokok:</strong> {{ baduta.meerokok_terpapar }}</p>
      <p><strong>Fasilitas Bantuan Sosial:</strong> {{ baduta.fasilitas_bantuan_sosial }}</p>
      <p><strong>Penyuluhan KIE:</strong> {{ baduta.penyuluhan_KIE }}</p>
      <p><strong>Kehadiran Posyandu:</strong> {{ baduta.kehadiran_posyandu }}</p>
      <p><strong>Urutan Anak:</strong> {{ baduta.urutan_anak }}</p>
    </div>
    <h5 class="mt-4">Lokasi Anak</h5>
<div id="map" style="height: 200px; width: 30%;"></div>

  </AppLayout>
</template>
