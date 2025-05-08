<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, Link, usePage } from '@inertiajs/vue3';
import type { BreadcrumbItem } from '@/types';

interface Pandugenre {
  nama: string;
  nik: string;
  tanggal_lahir: string;
  usia: number;
  jenis_kelamin: string;
  berat_badan: string;
  tinggi_badan: string;
  alamat: string;
  no_hp: string;

  terapi_gizi : string;
  terapi_psikososial : string;
  kunjungan_rumah : string;
}

const { props } = usePage();
const pandugenre = props.pandugenre as Pandugenre;

const breadcrumbs: BreadcrumbItem[] = [
  { title: 'Pandu Genre', href: '/pandu-genre' },
  { title: 'Detail Data', href: '/pandu-genre' },
];
</script>

<template>
  <Head title="Detail Pandu Genre" />
  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="p-6 space-y-6">
      <h1 class="text-center text-white text-lg font-semibold bg-[#071556] px-4 py-2 rounded-t-xl">
        Detail Data Pandu Genre
      </h1>

      
        <div class="p-6 border rounded-md border-orange-400">
          <h2 class="text-lg font-bold mb-4">BIODATA BADUTA</h2>
          <ul class="space-y-1 text-sm">
            <li><strong>Nama:</strong> {{ pandugenre.nama }}</li>
            <li><strong>NIK:</strong> {{ pandugenre.nik }}</li>
            <li><strong>Tanggal Lahir:</strong> {{ pandugenre.tanggal_lahir }}</li>
            <li><strong>Usia:</strong> {{ pandugenre.usia }}</li>
            <li><strong>Jenis Kelamin:</strong> {{ pandugenre.jenis_kelamin }}</li>
            <li><strong>Berat Badan:</strong> {{ pandugenre.berat_badan }} kg</li>
            <li><strong>Tinggi Badan:</strong> {{ pandugenre.tinggi_badan }} cm</li>
            <li><strong>Alamat:</strong> {{ pandugenre.alamat }}</li>
            <li><strong>No Hp:</strong> {{ pandugenre.no_hp }}</li>
          </ul>

          <h2 class="text-lg font-bold mt-6 mb-4">TERAPI YANG DIBERIKAN</h2>
          <ul class="space-y-1 text-sm">
            <li><strong>Terapi Gizi:</strong> {{ pandugenre.terapi_gizi }}</li>
            <li><strong>Terapi Psikososial:</strong> {{ pandugenre.terapi_psikososial }}</li>
            <li><strong>Kunjungan Rumah:</strong> {{ pandugenre.kunjungan_rumah }}</li>
          </ul>
        </div>

    </div>
    <!-- Tombol -->
    <div class="text-right">
        <Link
          href="/baduta/tambah-kunjungan"
          class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded shadow"
        >
          Tambah Kunjungan
        </Link>
      </div>
  </AppLayout>
</template>
