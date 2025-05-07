<script setup lang="ts">
import { usePage, Head } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import type { BreadcrumbItem } from '@/types';

interface Penduduk {
  nik: string;
  nama: string;
  tanggal_lahir: string;
  jenis_kelamin: string;
  alamat: string;
  no_hp: string;
  usia: number;
}

interface Catin {
  catin1: Penduduk;
  catin2: Penduduk;
  tanggal_pernikahan: string;
  tinggi_badan: number;
  berat_badan: number;
  indeks_massa_tubuh: number;
  kadar_hemoglobin: number;
  LILA: number;
  menggunakan_alat_kontrasepsi: string;
  catin_wanita_meerokok_terpapar: string;
  catin_pria_meerokok_terpapar: string;
  sumber_air_minum: string;
  fasilitas_BAB: string;
  longitude: string;
  latitude: string;
  fasilitas_bantuan_sosial: string;
}

const breadcrumbs: BreadcrumbItem[] = [
  { title: 'Data Catin', href: '/catin' },
  { title: 'Detail Data Catin', href: '/catin' },
];

const { props } = usePage();
const catin = props.catin as Catin;
</script>

<template>
  <Head title="Detail Catin" />
  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="p-6 border rounded-md border-orange-400">
      <h2 class="text-lg font-bold mb-4">BIODATA Catin 1</h2>
      <ul class="space-y-1 text-sm">
        <li><strong>Nama:</strong> {{ catin.catin1.nama }}</li>
        <li><strong>NIK:</strong> {{ catin.catin1.nik }}</li>
        <li><strong>Tanggal Lahir:</strong> {{ catin.catin1.tanggal_lahir }}</li>
        <li><strong>Jenis Kelamin:</strong> {{ catin.catin1.jenis_kelamin }}</li>
        <li><strong>Alamat:</strong> {{ catin.catin1.alamat }}</li>
        <li><strong>No HP:</strong> {{ catin.catin1.no_hp }}</li>
        <li><strong>Usia:</strong> {{ catin.catin1.usia }} tahun</li>
      </ul>

      <h2 class="text-lg font-bold mt-6 mb-4">BIODATA Catin 2</h2>
      <ul class="space-y-1 text-sm">
        <li><strong>Nama:</strong> {{ catin.catin2.nama }}</li>
        <li><strong>NIK:</strong> {{ catin.catin2.nik }}</li>
        <li><strong>Tanggal Lahir:</strong> {{ catin.catin2.tanggal_lahir }}</li>
        <li><strong>Jenis Kelamin:</strong> {{ catin.catin2.jenis_kelamin }}</li>
        <li><strong>Alamat:</strong> {{ catin.catin2.alamat }}</li>
        <li><strong>No HP:</strong> {{ catin.catin2.no_hp }}</li>
        <li><strong>Usia:</strong> {{ catin.catin2.usia }} tahun</li>
      </ul>

      <h2 class="text-lg font-bold mt-6 mb-4">DATA PERNIKAHAN</h2>
      <ul class="space-y-1 text-sm">
        <li><strong>Tanggal Pernikahan:</strong> {{ catin.tanggal_pernikahan }}</li>
        <li><strong>Tinggi Badan:</strong> {{ catin.tinggi_badan }} cm</li>
        <li><strong>Berat Badan:</strong> {{ catin.berat_badan }} kg</li>
        <li><strong>Indeks Massa Tubuh (IMT):</strong> {{ catin.indeks_massa_tubuh }}</li>
        <li><strong>Kadar Hemoglobin:</strong> {{ catin.kadar_hemoglobin }} g/dL</li>
        <li><strong>Lingkar Lengan Atas (LILA):</strong> {{ catin.LILA }} cm</li>
        <li><strong>Menggunakan Alat Kontrasepsi:</strong> {{ catin.menggunakan_alat_kontrasepsi }}</li>
        <li><strong>Catin Wanita Merokok/Terpapar Rokok:</strong> {{ catin.catin_wanita_meerokok_terpapar }}</li>
        <li><strong>Catin Pria Merokok/Terpapar Rokok:</strong> {{ catin.catin_pria_meerokok_terpapar }}</li>
        <li><strong>Sumber Air Minum:</strong> {{ catin.sumber_air_minum }}</li>
        <li><strong>Fasilitas BAB:</strong> {{ catin.fasilitas_BAB }}</li>
        <li><strong>Fasilitas Bantuan Sosial:</strong> {{ catin.fasilitas_bantuan_sosial }}</li>
      </ul>
    </div>
  </AppLayout>
</template>
