<script setup lang="ts">
import { usePage, Head } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import type { BreadcrumbItem } from '@/types';
import TambahKunjungan from "./TambahKunjungan.vue";
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
  kunjungan: Kunjungan[];
  stunting: string;
}

const breadcrumbs: BreadcrumbItem[] = [
  { title: 'Baduta', href: '/baduta' },
  { title: 'Detail Data Baduta', href: '/baduta' },
];

const { props } = usePage();
const baduta = props.baduta as Baduta;
const stunting = baduta.stunting;

console.log("Props:", props);

console.log("Stunting:", stunting);
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
        <li><strong>Usia:</strong> {{ baduta.usia }}</li>
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

      <!-- Kondisi untuk menampilkan riwayat kunjungan hanya jika status stunting adalah 'Ya' -->
      <div v-if="stunting && stunting.trim().toLowerCase() === 'ya'">
        <h3 class="text-lg font-bold mt-6 mb-4">RIWAYAT KUNJUNGAN</h3>
        <div v-if="Array.isArray(baduta.kunjungan) && baduta.kunjungan.length" class="space-y-4">
          <div v-for="(kunjungan, index) in baduta.kunjungan" :key="kunjungan.id" class="border p-4 mb-4">
            <p><strong>Kunjungan ke-{{ index + 1 }}</strong></p>
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
            <p><strong>Koordinat:</strong> {{ kunjungan.latitude }}, {{ kunjungan.longitude }}</p>
            <p><strong>Keikutsertaan Posyandu:</strong> {{ kunjungan.kehadiran_posyandu }}</p>
            <p><strong>Penyuluhan KIE:</strong> {{ kunjungan.penyuluhan_KIE }}</p>
            <p><strong>Bantuan Sosial:</strong> {{ kunjungan.fasilitas_bantuan_sosial }}</p>
          </div>
        </div>
        <!-- Tombol tambah kunjungan hanya muncul jika status stunting adalah 'Ya' -->
        <div class="mt-6 border border-red-500 p-2">
          <TambahKunjungan :penduduk_nik="baduta.nik" :nama="baduta.nama"/>
        </div>
      </div>
    </div>
  </AppLayout>
</template>
