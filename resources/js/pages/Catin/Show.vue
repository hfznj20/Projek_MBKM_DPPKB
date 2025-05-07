<script setup lang="ts">
import { usePage, Head } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import type { BreadcrumbItem } from '@/types';

interface Penduduk {
  nik: string;
  nama: string;
  jenis_kelamin: string;
  tanggal_lahir: string;
  kelurahan: string;
  kecamatan: string;
  RT: string;
  RW: string;
  alamat: string;
  no_hp: string;
}

interface Catin {
  tanggal_pernikahan: string;
  tinggi_badan: string;
  berat_badan: string;
  indeks_massa_tubuh: string;
  kadar_hemoglobin: string;
  LILA: string;
  menggunakan_alat_kontrasepsi: string;
  catin_wanita_meerokok_terpapar: string;
  catin_pria_meerokok_terpapar: string;
  sumber_air_minum: string;
  fasilitas_BAB: string;
  catin_wanita: Penduduk;
  catin_pria: Penduduk;
}

const breadcrumbs: BreadcrumbItem[] = [
  { title: 'Catin', href: '/catin' },
  { title: 'Detail Data Catin', href: '/catin' },
];

const { props } = usePage();
const catin = props.catin as Catin;
</script>

<template>
  <Head title="Detail Catin" />
  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="p-6 border rounded-md border-orange-400 space-y-6">
      <!-- Biodata Calon Wanita -->
      <div>
        <h2 class="text-lg font-bold mb-2">Biodata Calon Wanita</h2>
        <ul class="space-y-1 text-sm">
          <li><strong>Nama:</strong> {{ catin.catin_wanita.nama }}</li>
          <li><strong>NIK:</strong> {{ catin.catin_wanita.nik }}</li>
          <li><strong>No HP:</strong> {{ catin.catin_wanita.no_hp }}</li>
          <li><strong>Tanggal Lahir:</strong> {{ catin.catin_wanita.tanggal_lahir }}</li>
          <li><strong>Jenis Kelamin:</strong> {{ catin.catin_wanita.jenis_kelamin }}</li>
          <li><strong>Alamat:</strong> {{ catin.catin_wanita.alamat }}</li>
          <li><strong>RT/RW:</strong> {{ catin.catin_wanita.RT }}/{{ catin.catin_wanita.RW }}</li>
          <li><strong>Kelurahan/Kecamatan:</strong> {{ catin.catin_wanita.kelurahan }} / {{ catin.catin_wanita.kecamatan }}</li>
        </ul>
      </div>

      <!-- Biodata Calon Pria -->
      <div>
        <h2 class="text-lg font-bold mb-2">Biodata Calon Pria</h2>
        <ul class="space-y-1 text-sm">
          <li><strong>Nama:</strong> {{ catin.catin_pria.nama }}</li>
          <li><strong>NIK:</strong> {{ catin.catin_pria.nik }}</li>
          <li><strong>No HP:</strong> {{ catin.catin_pria.no_hp }}</li>
          <li><strong>Tanggal Lahir:</strong> {{ catin.catin_pria.tanggal_lahir }}</li>
          <li><strong>Jenis Kelamin:</strong> {{ catin.catin_pria.jenis_kelamin }}</li>
          <li><strong>Alamat:</strong> {{ catin.catin_pria.alamat }}</li>
          <li><strong>RT/RW:</strong> {{ catin.catin_pria.RT }}/{{ catin.catin_pria.RW }}</li>
          <li><strong>Kelurahan/Kecamatan:</strong> {{ catin.catin_pria.kelurahan }} / {{ catin.catin_pria.kecamatan }}</li>
        </ul>
      </div>

      <!-- Data Kesehatan Catin -->
      <div>
        <h2 class="text-lg font-bold mb-2">Data Kesehatan & Lingkungan</h2>
        <ul class="space-y-1 text-sm">
          <li><strong>Tanggal Rencana Pernikahan:</strong> {{ catin.tanggal_pernikahan }}</li>
          <li><strong>Tinggi Badan:</strong> {{ catin.tinggi_badan }} cm</li>
          <li><strong>Berat Badan:</strong> {{ catin.berat_badan }} kg</li>
          <li><strong>Indeks Massa Tubuh:</strong> {{ catin.indeks_massa_tubuh }}</li>
          <li><strong>Ukuran LILA:</strong> {{ catin.LILA }} cm</li>
          <li><strong>Kadar Hemoglobin (HB):</strong> {{ catin.kadar_hemoglobin }} g/dL</li>
          <li><strong>Penggunaan Alat Kontrasepsi:</strong> {{ catin.menggunakan_alat_kontrasepsi }}</li>
          <li><strong>Calon Wanita Terpapar Asap Rokok:</strong> {{ catin.catin_wanita_meerokok_terpapar }}</li>
          <li><strong>Calon Pria Terpapar Asap Rokok:</strong> {{ catin.catin_pria_meerokok_terpapar }}</li>
          <li><strong>Sumber Air Minum:</strong> {{ catin.sumber_air_minum }}</li>
          <li><strong>Fasilitas BAB:</strong> {{ catin.fasilitas_BAB }}</li>
        </ul>
      </div>
    </div>
  </AppLayout>
</template>
