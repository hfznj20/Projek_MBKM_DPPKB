<script lang="ts" setup>
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, Link, usePage } from '@inertiajs/vue3';
import type { BreadcrumbItem } from '@/types';

// Definisikan interface untuk data kunjungan
interface Kunjungan {
  id: number;
  nik: string;
  tanggal_kunjungan: string;
  berat_badan: string;
  tinggi_badan: string;
  terapi_gizi: string;
  terapi_psikososial: string;
  kunjungan_rumah: string;
}

// Ambil props yang dikirim dari controller menggunakan Inertia
const { props } = usePage();
const kunjungan = props.kunjungan as Kunjungan;

// Definisikan breadcrumbs untuk navigasi
const breadcrumbs: BreadcrumbItem[] = [
  { title: 'Pandu Genre', href: '/pandu-genre' },
  { title: 'Detail Kunjungan', href: '' }
];
</script>

<template>
  <Head title="Detail Kunjungan Pandu Genre" />
  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="p-6 space-y-6">
      <h1 class="text-center text-white text-lg font-semibold bg-[#071556] px-4 py-2 rounded-t-xl">
        Detail Kunjungan
      </h1>
      
      <div class="p-6 border rounded-md border-orange-400">
        <h2 class="text-lg font-bold mb-4">Informasi Kunjungan</h2>
        <ul class="space-y-1 text-sm">
          <li><strong>NIK:</strong> {{ kunjungan.nik }}</li>
          <li><strong>Tanggal Kunjungan:</strong> {{ kunjungan.tanggal_kunjungan }}</li>
          <li><strong>Berat Badan:</strong> {{ kunjungan.berat_badan }}</li>
          <li><strong>Tinggi Badan:</strong> {{ kunjungan.tinggi_badan }}</li>
          <li><strong>Terapi Gizi:</strong> {{ kunjungan.terapi_gizi }}</li>
          <li><strong>Terapi Psikososial:</strong> {{ kunjungan.terapi_psikososial }}</li>
          <li><strong>Kunjungan Rumah:</strong> {{ kunjungan.kunjungan_rumah }}</li>
        </ul>
      </div>
      
      <!-- Tombol kembali ke halaman detail Pandu Genre -->
      <div class="text-right">
        <Link :href="`/pandu-genre/${kunjungan.nik}`" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded shadow">
          Kembali ke Detail Pandu Genre
        </Link>
      </div>
    </div>
  </AppLayout>
</template>

<style scoped>
/* Tambahan style jika diperlukan */
</style>
