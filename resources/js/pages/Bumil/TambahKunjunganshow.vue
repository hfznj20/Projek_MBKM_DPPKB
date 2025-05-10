<script setup lang="ts">
import { usePage, Head } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import type { BreadcrumbItem } from '@/types';

// Interface untuk data Bumil
interface Bumil {
  penduduk_nik: string;
}

// Interface untuk data Kunjungan
interface Kunjungan {
  id: number;
  tanggal: string;
  usia_kehamilan: string;
  TUF: string;
  tinggi_badan: string;
  berat_badan_sebelum_hamil: string;
  berat_badan_saat_ini: string;
  indeks_massa_tubuh: string;
  kadar_hemoglobin: string;
  LILA: string;
  menggunakan_alat_kontrasepsi: string;
  sumber_air_minum: string;
  fasilitas_BAB: string;
  meerokok_terpapar: string;
  mendapatkan_tablet_tambah_darah: string;
  meminum_table_tambah_darah: string;
  penyuluhan_KIE: string;
  fasilitas_layanan_rujukan: string;
  fasilitas_bantuan_sosial: string;
}

const { props } = usePage();
const bumil = props.bumil as Bumil;
const kunjungan = props.kunjungan as Kunjungan;

const breadcrumbs: BreadcrumbItem[] = [
  { title: 'Bumil', href: '/bumil' },
  { title: 'Detail Data Bumil', href: '/bumil' },
  { title: 'Detail Kunjungan', href: '' },
];
</script>

<template>
  <Head title="Detail Kunjungan Bumil" />
  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="p-6 space-y-6">
      <h1 class="text-center text-white text-lg font-semibold bg-[#071556] px-4 py-2 rounded-t-xl">
        Detail Kunjungan Bumil
      </h1>

      <div class="text-center my-4">
        <p><strong>NIK Bumil:</strong> {{ bumil.penduduk_nik }}</p>
      </div>

      <div class="p-6 border rounded-md border-orange-400 space-y-3 text-sm">
        <p><strong>Tanggal Kunjungan:</strong> {{ kunjungan.tanggal }}</p>
        <p><strong>Usia Kehamilan:</strong> {{ kunjungan.usia_kehamilan }}</p>
        <p><strong>Taksiran Usia Fetus (TUF):</strong> {{ kunjungan.TUF }}</p>
        <p><strong>Tinggi Badan:</strong> {{ kunjungan.tinggi_badan }} cm</p>
        <p><strong>Berat Badan Sebelum Hamil:</strong> {{ kunjungan.berat_badan_sebelum_hamil }} kg</p>
        <p><strong>Berat Badan Saat Ini:</strong> {{ kunjungan.berat_badan_saat_ini }} kg</p>
        <p><strong>Indeks Massa Tubuh:</strong> {{ kunjungan.indeks_massa_tubuh }}</p>
        <p><strong>Kadar Hemoglobin:</strong> {{ kunjungan.kadar_hemoglobin }} g/dL</p>
        <p><strong>LILA:</strong> {{ kunjungan.LILA }} cm</p>
        <p><strong>Alat Kontrasepsi:</strong> {{ kunjungan.menggunakan_alat_kontrasepsi }}</p>
        <p><strong>Sumber Air Minum:</strong> {{ kunjungan.sumber_air_minum }}</p>
        <p><strong>Fasilitas BAB:</strong> {{ kunjungan.fasilitas_BAB }}</p>
        <p><strong>Terpapar Asap Rokok:</strong> {{ kunjungan.meerokok_terpapar }}</p>
        <p><strong>Mendapatkan Tablet Tambah Darah:</strong> {{ kunjungan.mendapatkan_tablet_tambah_darah }}</p>
        <p><strong>Meminum Tablet Tambah Darah:</strong> {{ kunjungan.meminum_table_tambah_darah }}</p>
        <p><strong>Penyuluhan KIE:</strong> {{ kunjungan.penyuluhan_KIE }}</p>
        <p><strong>Fasilitas Layanan Rujukan:</strong> {{ kunjungan.fasilitas_layanan_rujukan }}</p>
        <p><strong>Bantuan Sosial:</strong> {{ kunjungan.fasilitas_bantuan_sosial }}</p>
      </div>
    </div>
  </AppLayout>
</template>
