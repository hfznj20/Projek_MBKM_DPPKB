<script setup lang="ts">
import { usePage, Head } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import type { BreadcrumbItem } from '@/types';

interface Bumil {
  nama: string;
  nik: string;
  tanggal_lahir: string;
  usia: number;
  no_hp: string;
  jenis_kelamin: string;
  usia_kehamilan: number;
  jumlah_anak_kandung: number;
  tgl_lahir_ank_terakhir: string;
  berat_badan_saat_ini: string;
  tinggi_badan: string;
  indeks_massa_tubuh: string;
  LILA: string;
  kadar_hemoglobin: string;
  menggunakan_alat_kontrasepsi: string;
  sumber_air_minum: string;
  fasilitas_BAB: string;
  meerokok_terpapar: string;
}

const breadcrumbs: BreadcrumbItem[] = [
  { title: 'Bumil', href: '/bumil' },
  { title: 'Detail Data Bumil', href: '/bumil' },
];

const { props } = usePage();
const bumil = props.bumil as Bumil;
</script>

<template>
  <Head title="Detail BUMIL" />
  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="p-6 border rounded-md border-orange-400">
      <h2 class="text-lg font-bold mb-4">BIODATA BUMIL</h2>
      <ul class="space-y-1 text-sm">
        <li><strong>Nama :</strong> {{ bumil.nama }}</li>
        <li><strong>NIK :</strong> {{ bumil.nik }}</li>
        <li><strong>No Hp :</strong> {{ bumil.no_hp }}</li>
        <li><strong>Tanggal Lahir :</strong> {{ bumil.tanggal_lahir }}</li>
        <li><strong>Usia :</strong> {{ bumil.usia }} tahun</li>
        <li><strong>Usia Kehamilan :</strong> {{ bumil.usia_kehamilan }} minggu</li>
        <li><strong>Jumlah Anak Kandung :</strong> {{ bumil.jumlah_anak_kandung }}</li>
        <li><strong>Tanggal Lahir Anak Terakhir :</strong> {{ bumil.tgl_lahir_ank_terakhir }}</li>
        <li><strong>Berat Badan :</strong> {{ bumil.berat_badan_saat_ini }} kg</li>
        <li><strong>Tinggi Badan :</strong> {{ bumil.tinggi_badan }} cm</li>
        <li><strong>Indeks Masa Tubuh :</strong> {{ bumil.indeks_massa_tubuh }}</li>
        <li><strong>Ukuran LILA :</strong> {{ bumil.LILA }} cm</li>
        <li><strong>Kadar HB :</strong> {{ bumil.kadar_hemoglobin }} g/dL</li>
        <li><strong>Penggunaan KB :</strong> {{ bumil.menggunakan_alat_kontrasepsi }}</li>
        <li><strong>Sumber Air Minum :</strong> {{ bumil.sumber_air_minum }}</li>
        <li><strong>Fassilitas BAB :</strong> {{ bumil.fasilitas_BAB }}</li>
        <li><strong>Terpapar Asap Rokok :</strong> {{ bumil.meerokok_terpapar }}</li>
      </ul>
    </div>
  </AppLayout>
</template>
