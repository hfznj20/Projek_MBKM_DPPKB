<script lang="ts" setup>
import AppLayout from '@/layouts/AppLayout.vue';
import { BreadcrumbItem } from '@/types';
import { ref } from 'vue';
import { Head, useForm } from '@inertiajs/vue3';

const penduduk_nik = ref<string>(new URLSearchParams(window.location.search).get('nik') || '');

const form = useForm({
  penduduk_nik: penduduk_nik.value,
  usia_kehamilan: '',
  TUF: '',
  jumlah_anak_kandung: '',
  tgl_lahir_ank_terakhir: '',
  tinggi_badan: '',
  berat_badan_sebelum_hamil: '',
  berat_badan_saat_ini: '',
  indeks_massa_tubuh: '',
  kadar_hemoglobin: '',
  LILA: '',
  menggunakan_alat_kontrasepsi: '',
  sumber_air_minum: '',
  fasilitas_BAB: '',
  meerokok_terpapar: '',
  longitude: '',
  latitude: '',
  mendapatkan_tablet_tambah_darah: '',
  meminum_table_tambah_darah: '',
  penyuluhan_KIE: '',
  fasilitas_layanan_rujukan: '',
  fasilitas_bantuan_sosial: '',
  stunting: ''
});

const breadcrumbs: BreadcrumbItem[] = [
  { title: 'Tambah Data Bumil', 
  href: '/bumil/create' }
];

const errors = ref<string[]>([]);

const submitForm = () => {
  form.post('/bumil', {
    onSuccess: () => {
      window.location.href = '/penduduk';
    },
    onError: () => {
      errors.value = Object.values(form.errors).flat();
    }
  });
};
</script>


<template>
  <Head title="Tambah Data Bumil" />
  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="container mx-auto px-4 py-6">
    <div class="bg-[#37347E] py-1.5 rounded flex items-center justify-center mb-2">
  <h2 class="text-sm font-normal text-white">Tambah Data Bumil</h2>
</div>

      <div v-if="errors.length" class="bg-red-100 text-red-700 p-4 rounded mb-4">
        <ul class="list-disc list-inside">
          <li v-for="(error, index) in errors" :key="index">{{ error }}</li>
        </ul>
      </div>

      <form @submit.prevent="submitForm" class="space-y-4">
        <input type="hidden" v-model="form.penduduk_nik" />

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="text-sm font-normal">Usia Kehamilan</label>
            <input v-model="form.usia_kehamilan" type="text" class="w-full border border-orange-500 rounded px-3 py-1 text-sm" required />
          </div>

          <div>
            <label class="text-sm font-normal">TUF</label>
            <input v-model="form.TUF" type="text" class="w-full border border-orange-500 rounded px-3 py-1 text-sm" required />
          </div>

          <div>
            <label class="text-sm font-normal">Jumlah Anak Kandung</label>
            <input v-model="form.jumlah_anak_kandung" type="text" class="w-full border border-orange-500 rounded px-3 py-1 text-sm" required />
          </div>

          <div>
            <label class="text-sm font-normal">Tanggal Lahir Anak Terakhir</label>
            <input v-model="form.tgl_lahir_ank_terakhir" type="date" class="w-full border border-orange-500 rounded px-3 py-1 text-sm" required />
          </div>

          <div>
            <label class="text-sm font-normal">Tinggi Badan</label>
            <input v-model="form.tinggi_badan" type="text" class="w-full border border-orange-500 rounded px-3 py-1 text-sm" required />
          </div>

          <div>
            <label class="text-sm font-normal">Berat Badan Sebelum Hamil</label>
            <input v-model="form.berat_badan_sebelum_hamil" type="text" class="w-full border border-orange-500 rounded px-3 py-1 text-sm" required />
          </div>

          <div>
            <label class="text-sm font-normal">Berat Badan Saat Ini</label>
            <input v-model="form.berat_badan_saat_ini" type="text" class="w-full border border-orange-500 rounded px-3 py-1 text-sm" required />
          </div>

          <div>
            <label class="text-sm font-normal">Indeks Massa Tubuh</label>
            <input v-model="form.indeks_massa_tubuh" type="text" class="w-full border border-orange-500 rounded px-3 py-1 text-sm" required />
          </div>

          <div>
            <label class="text-sm font-normal">Kadar Hemoglobin</label>
            <input v-model="form.kadar_hemoglobin" type="text" class="w-full border border-orange-500 rounded px-3 py-1 text-sm" required />
          </div>

          <div>
            <label class="text-sm font-normal">LILA</label>
            <input v-model="form.LILA" type="text" class="w-full border border-orange-500 rounded px-3 py-1 text-sm" required />
          </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="text-sm font-normal">Menggunakan Alat Kontrasepsi?</label>
            <select v-model="form.menggunakan_alat_kontrasepsi" class="w-full border border-orange-500 rounded px-3 py-1 text-sm">
              <option disabled value="">Pilih</option>
              <option value="Ya">Ya</option>
              <option value="Tidak">Tidak</option>
            </select>
          </div>

          <div>
            <label class="text-sm font-normal">Terpapar Asap Rokok?</label>
            <select v-model="form.meerokok_terpapar" class="w-full border border-orange-500 rounded px-3 py-1 text-sm">
              <option disabled value="">Pilih</option>
              <option value="Ya">Ya</option>
              <option value="Tidak">Tidak</option>
            </select>
          </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="text-sm font-normal">Sumber Air Minum</label>
            <input v-model="form.sumber_air_minum" type="text" class="w-full border border-orange-500 rounded px-3 py-1 text-sm" />
          </div>

          <div>
            <label class="text-sm font-normal">Fasilitas Buang Air Besar</label>
            <input v-model="form.fasilitas_BAB" type="text" class="w-full border border-orange-500 rounded px-3 py-1 text-sm" />
          </div>

          <div>
            <label class="text-sm font-normal">Longitude</label>
            <input v-model="form.longitude" type="text" class="w-full border border-orange-500 rounded px-3 py-1 text-sm" required />
          </div>

          <div>
            <label class="text-sm font-normal">Latitude</label>
            <input v-model="form.latitude" type="text" class="w-full border border-orange-500 rounded px-3 py-1 text-sm" required />
          </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="text-sm font-normal">Mendapatkan Tablet Tambah Darah?</label>
            <select v-model="form.mendapatkan_tablet_tambah_darah" class="w-full border border-orange-500 rounded px-3 py-1 text-sm">
              <option disabled value="">Pilih</option>
              <option value="Ya">Ya</option>
              <option value="Tidak">Tidak</option>
            </select>
          </div>

          <div>
            <label class="text-sm font-normal">Meminum Tablet Tambah Darah?</label>
            <select v-model="form.meminum_table_tambah_darah" class="w-full border border-orange-500 rounded px-3 py-1 text-sm">
              <option disabled value="">Pilih</option>
              <option value="Ya">Ya</option>
              <option value="Tidak">Tidak</option>
            </select>
          </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="text-sm font-normal">Penyuluhan KIE</label>
            <input v-model="form.penyuluhan_KIE" type="text" class="w-full border border-orange-500 rounded px-3 py-1 text-sm" />
          </div>

          <div>
            <label class="text-sm font-normal">Fasilitas Layanan Rujukan</label>
            <input v-model="form.fasilitas_layanan_rujukan" type="text" class="w-full border border-orange-500 rounded px-3 py-1 text-sm" />
          </div>

          <div>
            <label class="text-sm font-normal">Fasilitas Bantuan Sosial</label>
            <input v-model="form.fasilitas_bantuan_sosial" type="text" class="w-full border border-orange-500 rounded px-3 py-1 text-sm" />
          </div>

          <div>
            <label class="text-sm font-normal">Ibu Mengalami Stunting?</label>
            <select v-model="form.stunting" class="w-full border border-orange-500 rounded px-3 py-1 text-sm">
              <option disabled value="">Pilih</option>
              <option value="Ya">Ya</option>
              <option value="Tidak">Tidak</option>
            </select>
          </div>
        </div>

        <div class="mt-6">
          <div class="flex justify-end">
  <button
    type="submit"
    class="bg-green-600 hover:bg-green-700 text-white text-sm font-normal py-1 px-6 rounded shadow"
  >
    Simpan Data
  </button>
</div>
        </div>
      </form>
    </div>
  </AppLayout>
</template>

<style scoped>
/* Tambahan style jika diperlukan */
</style>

