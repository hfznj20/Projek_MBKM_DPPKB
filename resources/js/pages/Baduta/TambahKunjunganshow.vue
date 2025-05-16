<script setup lang="ts">
import { usePage, Head } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import type { BreadcrumbItem } from '@/types';

// Define interface for Baduta data
interface Baduta {
  penduduk_nik: string;
}

interface Kunjungan {
  id: number;
  tanggal_kunjungan: string;
  berat_badan: string;
  tinggi_badan: string;
  menggunakan_alat_kontrasepsi: string;
  sumber_air_minum: string;
  fasilitas_BAB: string;
  asi_eksklusif: string;
  imunisasi_hepatitis_B: string;
  meerokok_terpapar: string;
  mengisi_KKA: string;
  longitude: string;
  latitude: string;
  kehadiran_posyandu: string;
  penyuluhan_KIE: string;
  fasilitas_bantuan_sosial: string;
}

const { props } = usePage();
const baduta = props.baduta as Baduta; // Cast the data to the 'Baduta' type

const kunjungan = props.kunjungan as Kunjungan;
const breadcrumbs: BreadcrumbItem[] = [
  { title: 'Baduta', href: '/baduta' },
  { title: 'Detail Baduta', href: `/baduta/${baduta.penduduk_nik}` },
  { title: 'Detail Kunjungan', href: '' },
];
</script>

<template>
  <Head title="Detail Kunjungan Baduta" />
  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="p-6 space-y-6">
      <h1 class="text-center text-white text-lg font-semibold bg-[#071556] px-4 py-2 rounded-t-xl">
        Detail Kunjungan Baduta
      </h1>

      <!-- Menampilkan NIK dan Nama Baduta -->
      <div class="text-center my-4">
        <p><strong>NIK Baduta:</strong> {{ baduta.penduduk_nik }}</p>
      </div>

      <div class="p-6 border rounded-md border-orange-400 space-y-3 text-sm">
        <p><strong>Tanggal Kunjungan:</strong> {{ kunjungan.tanggal_kunjungan }}</p>
        <p><strong>Berat Badan:</strong> {{ kunjungan.berat_badan }} kg</p>
        <p><strong>Tinggi Badan:</strong> {{ kunjungan.tinggi_badan }} cm</p>
        <p><strong>Alat Kontrasepsi:</strong> {{ kunjungan.menggunakan_alat_kontrasepsi }}</p>
        <p><strong>Sumber Air Minum:</strong> {{ kunjungan.sumber_air_minum }}</p>
        <p><strong>Fasilitas BAB:</strong> {{ kunjungan.fasilitas_BAB }}</p>
        <p><strong>ASI Eksklusif:</strong> {{ kunjungan.asi_eksklusif }}</p>
        <p><strong>Imunisasi Hepatitis B:</strong> {{ kunjungan.imunisasi_hepatitis_B }}</p>
        <p><strong>Terpapar Asap Rokok:</strong> {{ kunjungan.meerokok_terpapar }}</p>
        <p><strong>Status KKA:</strong> {{ kunjungan.mengisi_KKA }}</p>
        <p><strong>Koordinat Lokasi:</strong> {{ kunjungan.latitude }}, {{ kunjungan.longitude }}</p>
        <p><strong>Kehadiran Posyandu:</strong> {{ kunjungan.kehadiran_posyandu }}</p>
        <p><strong>Penyuluhan KIE:</strong> {{ kunjungan.penyuluhan_KIE }}</p>
        <p><strong>Bantuan Sosial:</strong> {{ kunjungan.fasilitas_bantuan_sosial }}</p>
      </div>
    </div>
  </AppLayout>
</template>
