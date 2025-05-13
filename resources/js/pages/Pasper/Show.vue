<script setup lang="ts">
import { usePage, Head } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import type { BreadcrumbItem } from '@/types';

interface Pasper {
  nama: string;
  nik: string;
  tempat_lahir: string;
  tanggal_lahir: string;
  usia: number;
  jenis_kelamin: string;
  alamat: string;
  no_hp: string;

  tanggal_persalinan: string;
  tempat_persalinan: string;
  penolong_persalinan: string;
  cara_persalinan: string;
  keadaan_bayi: string;
  menggunakan_alat_kontrasepsi: string;
  meerokok_terpapar: string;
  sumber_air_minum: string;
  fasilitas_BAB: string;
}

const breadcrumbs: BreadcrumbItem[] = [
  { title: 'Pasca Persalinan', href: '/pasper' },
  { title: 'Detail Data Pasca Persalinan', href: '/pasper' },
];

const { props } = usePage();
const pasper = props.pasper as Pasper;
</script>

<template>
  <Head title="Detail Pasca Persalinan" />
  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="p-6 border rounded-md border-orange-400">
      <h2 class="text-lg font-bold mb-4">BIODATA Pasca Persalinan</h2>
      <ul class="space-y-1 text-sm">
        <li><strong>Nama:</strong> {{ pasper.nama }}</li>
        <li><strong>NIK:</strong> {{ pasper.nik }}</li>
        <li><strong>Tempat, Tanggal Lahir:</strong> {{ pasper.tempat_lahir }}, {{ pasper.tanggal_lahir }}</li>
        <li><strong>Jenis Kelamin:</strong> {{ pasper.jenis_kelamin }}</li>
        <li><strong>Usia:</strong> {{ pasper.usia }} tahun</li>
        <li><strong>Alamat:</strong> {{ pasper.alamat }}</li>
        <li><strong>No HP:</strong> {{ pasper.no_hp }}</li>
      </ul>

      <h2 class="text-lg font-bold mt-6 mb-4">DATA PERSALINAN</h2>
      <ul class="space-y-1 text-sm">
        <li><strong>Tanggal Persalinan:</strong> {{ pasper.tanggal_persalinan }}</li>
        <li><strong>Tempat Persalinan:</strong> {{ pasper.tempat_persalinan }}</li>
        <li><strong>Penolong Persalinan:</strong> {{ pasper.penolong_persalinan }}</li>
        <li><strong>Cara Persalinan:</strong> {{ pasper.cara_persalinan }}</li>
        <li><strong>Keadaan Bayi:</strong> {{ pasper.keadaan_bayi }}</li>
        <li><strong>Menggunakan Alat Kontrasepsi:</strong> {{ pasper.menggunakan_alat_kontrasepsi }}</li>
        <li><strong>Terpapar Asap Rokok:</strong> {{ pasper.meerokok_terpapar }}</li>
        <li><strong>Sumber Air Minum:</strong> {{ pasper.sumber_air_minum }}</li>
        <li><strong>Fasilitas BAB:</strong> {{ pasper.fasilitas_BAB }}</li>
      </ul>
    </div>
  </AppLayout>
</template>
