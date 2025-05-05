<script setup lang="ts">
import { usePage, Head } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import type { BreadcrumbItem } from '@/types';

interface Baduta {
  nama: string;
  nik: string;
  tanggal_lahir: string;
  usia: number;
  jenis_kelamin: string;
  berat_badan: string;
  tinggi_badan: string;
  asi_eksklusif: string;
  imunisasi_hepatitis_B: string;
  mengisi_KKA: string;
  meerokok_terpapar: string;

  nama_ibu: string;
  nik_ibu: string;
  tanggal_lahir_ibu: string;
  usia_ibu: number;
  no_hp: string;
  alamat: string;
  jumlah_anak_kandung: number;
  tanggal_lahir_anak_terakhir: string;
  menggunakan_alat_kontrasepsi: string;
  sumber_air_minum: string;
  fasilitas_BAB: string;
}

const breadcrumbs: BreadcrumbItem[] = [
  { title: 'Baduta', href: '/baduta' },
  { title: 'Detail Data Baduta', href: '/baduta' },
];

const { props } = usePage();
const baduta = props.baduta as Baduta;
</script>

<template>
  <Head title="Detail Baduta TPK" />
  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="p-6 border rounded-md border-orange-400">
      <h2 class="text-lg font-bold mb-4">BIODATA BADUTA</h2>
      <ul class="space-y-1 text-sm">
        <li><strong>Nama:</strong> {{ baduta.nama }}</li>
        <li><strong>NIK:</strong> {{ baduta.nik }}</li>
        <li><strong>Tanggal Lahir:</strong> {{ baduta.tanggal_lahir }}</li>
        <li><strong>Usia:</strong> {{ baduta.usia }} bulan </li>
        <li><strong>Jenis Kelamin:</strong> {{ baduta.jenis_kelamin }}</li>
        <li><strong>Berat Badan:</strong> {{ baduta.berat_badan }} kg</li>
        <li><strong>Tinggi Badan:</strong> {{ baduta.tinggi_badan }} cm</li>
        <li><strong>Pemberian ASI Eksklusif:</strong> {{ baduta.asi_eksklusif }}</li>
        <li><strong>Pemberian Imunisasi Hepatitis B:</strong> {{ baduta.imunisasi_hepatitis_B }}</li>
        <li><strong>Status Kartu Kembang Anak:</strong> {{ baduta.mengisi_KKA }}</li>
        <li><strong>Terpapar Asap Rokok:</strong> {{ baduta.meerokok_terpapar }}</li>
      </ul>

      <h2 class="text-lg font-bold mt-6 mb-4">BIODATA IBU</h2>
      <ul class="space-y-1 text-sm">
        <li><strong>Nama:</strong> {{ baduta.nama_ibu }}</li>
        <li><strong>NIK:</strong> {{ baduta.nik_ibu }}</li>
        <li><strong>Tanggal Lahir:</strong> {{ baduta.tanggal_lahir_ibu }}</li>
        <li><strong>Usia:</strong> {{ baduta.usia_ibu }} tahun</li>
        <li><strong>No Hp:</strong> {{ baduta.no_hp }}</li>
        <li><strong>Alamat:</strong> {{ baduta.alamat }}</li>
        <li><strong>Jumlah Anak:</strong> {{ baduta.jumlah_anak_kandung }}</li>
        <li><strong>Tanggal Lahir Anak Terakhir:</strong> {{ baduta.tanggal_lahir_anak_terakhir }}</li>
        <li><strong>Penggunaan KB:</strong> {{ baduta.menggunakan_alat_kontrasepsi }}</li>
        <li><strong>Sumber Air Minum:</strong> {{ baduta.sumber_air_minum }}</li>
        <li><strong>Fasilitas BAB:</strong> {{ baduta.fasilitas_BAB }}</li>
      </ul>
    </div>
  </AppLayout>
</template>
