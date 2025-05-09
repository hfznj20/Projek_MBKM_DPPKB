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
  stunting: string;
  kunjungan: Kunjungan[];
}

const breadcrumbs: BreadcrumbItem[] = [
  { title: 'Bumil', href: '/bumil' },
  { title: 'Detail Data Bumil', href: '/bumil' },
];

const { props } = usePage();
const bumil = props.bumil as Bumil;
const stunting = bumil.stunting;

console.log("Props:", props);

console.log("Stunting Status:", bumil.stunting); </script>

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
        <li><strong>Fasilitas BAB :</strong> {{ bumil.fasilitas_BAB }}</li>
        <li><strong>Terpapar Asap Rokok :</strong> {{ bumil.meerokok_terpapar }}</li>
      </ul>

```
  <div v-if="stunting && stunting.trim().toLowerCase() === 'ya'">
    <h3 class="text-lg font-bold mt-6 mb-4">RIWAYAT KUNJUNGAN</h3>
    <div v-if="Array.isArray(bumil.kunjungan) && bumil.kunjungan.length" class="space-y-4">
      <div
        v-for="(kunjungan, index) in bumil.kunjungan"
        :key="kunjungan.id"
        class="border p-4 mb-4"
      >
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
    <div class="mt-6 border border-red-500 p-2">
      <TambahKunjungan :penduduk_nik="bumil.nik" :nama="bumil.nama" />
    </div>
  </div>
</div>
```

  </AppLayout>
</template>
