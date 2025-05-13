<script setup lang="ts">
import { usePage, Head } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import TambahKunjungan from './TambahKunjungan.vue';
import Chartbumilkunjungan from '../../components/Chartbumilkunjungan.vue';
import { Link } from '@inertiajs/vue3';
import type { BreadcrumbItem } from '@/types';

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
  merokok_terpapar: string;
  mendapatkan_tablet_tambah_darah: string;
  meminum_tablet_tambah_darah: string;
  penyuluhan_KIE: string;
  fasilitas_layanan_rujukan: string;
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
  merokok_terpapar: string;
  stunting: string;
  kunjungan: Kunjungan[];
}

const breadcrumbs: BreadcrumbItem[] = [
  { title: 'Bumil', href: '/bumil' },
  { title: 'Detail Data Bumil', href: '/bumil' },
];

const { props } = usePage();
const bumil = props.bumil as Bumil;
const kunjungan = props.kunjungan as Kunjungan[];
</script>

<template>
  <Head title="Detail BUMIL" />
  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="p-6 border rounded-md border-orange-400">
      <h2 class="text-lg font-bold mb-4">BIODATA BUMIL</h2>
      <ul class="space-y-1 text-sm">
        <li><strong>Nama:</strong> {{ bumil.nama }}</li>
        <li><strong>NIK:</strong> {{ bumil.nik }}</li>
        <li><strong>No Hp:</strong> {{ bumil.no_hp }}</li>
        <li><strong>Tanggal Lahir:</strong> {{ bumil.tanggal_lahir }}</li>
        <li><strong>Usia:</strong> {{ bumil.usia }} tahun</li>
        <li><strong>Usia Kehamilan:</strong> {{ bumil.usia_kehamilan }} minggu</li>
        <li><strong>Jumlah Anak Kandung:</strong> {{ bumil.jumlah_anak_kandung }}</li>
        <li><strong>Tanggal Lahir Anak Terakhir:</strong> {{ bumil.tgl_lahir_ank_terakhir }}</li>
        <li><strong>Berat Badan:</strong> {{ bumil.berat_badan_saat_ini }} kg</li>
        <li><strong>Tinggi Badan:</strong> {{ bumil.tinggi_badan }} cm</li>
        <li><strong>Indeks Massa Tubuh:</strong> {{ bumil.indeks_massa_tubuh }}</li>
        <li><strong>LILA:</strong> {{ bumil.LILA }} cm</li>
        <li><strong>Kadar Hemoglobin:</strong> {{ bumil.kadar_hemoglobin }} g/dL</li>
        <li><strong>Penggunaan KB:</strong> {{ bumil.menggunakan_alat_kontrasepsi }}</li>
        <li><strong>Sumber Air Minum:</strong> {{ bumil.sumber_air_minum }}</li>
        <li><strong>Fasilitas BAB:</strong> {{ bumil.fasilitas_BAB }}</li>
        <li><strong>Terpapar Asap Rokok:</strong> {{ bumil.merokok_terpapar }}</li>
      </ul>

      <div v-if="bumil.stunting?.trim().toLowerCase() === 'ya'">
        <h3 class="text-lg font-bold mt-6 mb-4">RIWAYAT KUNJUNGAN</h3>

        <div v-if="Array.isArray(bumil.kunjungan) && bumil.kunjungan.length > 0">
          <div class="grid grid-cols-3 font-semibold border-b pb-2 mb-2">
            <div>Kunjungan ke-</div>
            <div>Tanggal Kunjungan</div>
            <div>Detail</div>
          </div>

          <div
            v-for="(item, index) in bumil.kunjungan"
            :key="item.id"
            class="grid grid-cols-3 py-1 border-b text-sm"
          >
            <div>Kunjungan ke-{{ index + 1 }}</div>
            <div>{{ item.tanggal }}</div>
            <div>
              <Link
                :href="`/bumil/${bumil.nik}/kunjungan/${item.id}`"
                class="text-blue-600 hover:underline"
              >
                Detail &gt;&gt;
              </Link>
            </div>
          </div>
        </div>
        <div v-else class="text-sm text-gray-500">
          Belum ada data kunjungan.
        </div>

        <div class="mt-6">
          <h2 class="text-lg font-bold mb-4">Grafik Perkembangan Bumil</h2>
          <Chartbumilkunjungan :kunjungan="kunjungan" />
        </div>

        <div class="mt-6 border border-red-500 p-2 rounded-md">
          <TambahKunjungan :penduduk_nik="bumil.nik" :nama="bumil.nama" />
        </div>
      </div>
    </div>
  </AppLayout>
</template>
