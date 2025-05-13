<script lang="ts" setup>
import AppLayout from '@/layouts/AppLayout.vue';
import { BreadcrumbItem } from '@/types';
import { ref, onMounted } from 'vue';
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

onMounted(() => {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(
      (position) => {
        form.latitude = position.coords.latitude.toString();
        form.longitude = position.coords.longitude.toString();
      },
      (error) => {
        console.error('Gagal mengambil lokasi:', error);
      }
    );
  } else {
    console.warn('Geolocation tidak didukung browser ini.');
  }
});

const breadcrumbs: BreadcrumbItem[] = [
  { title: 'Tambah Data Bumil', href: '/bumil/create' }
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
    <div class="container mx-auto my-6 px-6">

      <div v-if="errors.length" class="bg-red-100 text-red-700 p-4 rounded mb-6 border border-red-300 text-sm">
        <ul>
          <li v-for="(error, index) in errors" :key="index">{{ error }}</li>
        </ul>
      </div>

      <form @submit.prevent="submitForm" class="grid grid-cols-1 md:grid-cols-2 gap-6 p-6 rounded-lg bg-white shadow-md text-sm">
        <input type="hidden" v-model="form.penduduk_nik" />

        <div>
          <label for="usia_kehamilan" class="form-label font-normal text-sm">Usia Kehamilan</label>
          <input v-model="form.usia_kehamilan" type="text" class="form-input w-full border border-orange-300 rounded p-2 py-1 text-sm" id="usia_kehamilan" required />
        </div>

        <div>
          <label for="TUF" class="form-label font-normal text-sm">TUF</label>
          <input v-model="form.TUF" type="text" class="form-input w-full border border-orange-300 rounded p-2 py-1 text-sm" id="TUF" required />
        </div>

        <div>
          <label for="jumlah_anak_kandung" class="form-label font-normal text-sm">Jumlah Anak Kandung</label>
          <input v-model="form.jumlah_anak_kandung" type="text" class="form-input w-full border border-orange-300 rounded p-2 py-1 text-sm" id="jumlah_anak_kandung" required />
        </div>

        <div>
          <label for="tgl_lahir_ank_terakhir" class="form-label font-normal text-sm">Tanggal Lahir Anak Terakhir</label>
          <input v-model="form.tgl_lahir_ank_terakhir" type="date" class="form-input w-full border border-orange-300 rounded p-2 py-1 text-sm" id="tgl_lahir_ank_terakhir" required />
        </div>

        <div>
          <label for="tinggi_badan" class="form-label font-normal text-sm">Tinggi Badan</label>
          <input v-model="form.tinggi_badan" type="text" class="form-input w-full border border-orange-300 rounded p-2 py-1 text-sm" id="tinggi_badan" required />
        </div>

        <div>
          <label for="berat_badan_sebelum_hamil" class="form-label font-normal text-sm">Berat Badan Sebelum Hamil</label>
          <input v-model="form.berat_badan_sebelum_hamil" type="text" class="form-input w-full border border-orange-300 rounded p-2 py-1 text-sm" id="berat_badan_sebelum_hamil" required />
        </div>

        <div>
          <label for="berat_badan_saat_ini" class="form-label font-normal text-sm">Berat Badan Saat Ini</label>
          <input v-model="form.berat_badan_saat_ini" type="text" class="form-input w-full border border-orange-300 rounded p-2 py-1 text-sm" id="berat_badan_saat_ini" required />
        </div>

        <div>
          <label for="indeks_massa_tubuh" class="form-label font-normal text-sm">Indeks Massa Tubuh</label>
          <input v-model="form.indeks_massa_tubuh" type="text" class="form-input w-full border border-orange-300 rounded p-2 py-1 text-sm" id="indeks_massa_tubuh" required />
        </div>

        <div>
          <label for="kadar_hemoglobin" class="form-label font-normal text-sm">Kadar Hemoglobin</label>
          <input v-model="form.kadar_hemoglobin" type="text" class="form-input w-full border border-orange-300 rounded p-2 py-1 text-sm" id="kadar_hemoglobin" required />
        </div>

        <div>
          <label for="LILA" class="form-label font-normal text-sm">LILA</label>
          <input v-model="form.LILA" type="text" class="form-input w-full border border-orange-300 rounded p-2 py-1 text-sm" id="LILA" required />
        </div>

        <div>
          <label class="form-label font-normal text-sm">Menggunakan Alat Kontrasepsi?</label>
          <select v-model="form.menggunakan_alat_kontrasepsi" class="form-select w-full border border-orange-300 rounded p-2 py-1 text-sm">
            <option value="">Pilih</option>
            <option value="Ya">Ya</option>
            <option value="Tidak">Tidak</option>
          </select>
        </div>

        <div>
          <label class="form-label font-normal text-sm">Terpapar Asap Rokok?</label>
          <select v-model="form.meerokok_terpapar" class="form-select w-full border border-orange-300 rounded p-2 py-1 text-sm">
            <option value="">Pilih</option>
            <option value="Ya">Ya</option>
            <option value="Tidak">Tidak</option>
          </select>
        </div>

        <div>
          <label for="sumber_air_minum" class="form-label font-normal text-sm">Sumber Air Minum</label>
          <input v-model="form.sumber_air_minum" type="text" class="form-input w-full border border-orange-300 rounded p-2 py-1 text-sm" />
        </div>

        <div>
          <label for="fasilitas_BAB" class="form-label font-normal text-sm">Fasilitas BAB</label>
          <input v-model="form.fasilitas_BAB" type="text" class="form-input w-full border border-orange-300 rounded p-2 py-1 text-sm" />
        </div>

        <div>
          <label for="longitude" class="form-label font-normal text-sm">Longitude</label>
          <input v-model="form.longitude" type="text" class="form-input w-full border border-gray-300 bg-gray-100 rounded p-2 py-1 text-sm" readonly />
        </div>

        <div>
          <label for="latitude" class="form-label font-normal text-sm">Latitude</label>
          <input v-model="form.latitude" type="text" class="form-input w-full border border-gray-300 bg-gray-100 rounded p-2 py-1 text-sm" readonly />
        </div>

        <div>
          <label class="form-label font-normal text-sm">Mendapatkan Tablet Tambah Darah?</label>
          <select v-model="form.mendapatkan_tablet_tambah_darah" class="form-select w-full border border-orange-300 rounded p-2 py-1 text-sm">
            <option value="">Pilih</option>
            <option value="Ya">Ya</option>
            <option value="Tidak">Tidak</option>
          </select>
        </div>

        <div>
          <label class="form-label font-normal text-sm">Meminum Tablet Tambah Darah?</label>
          <select v-model="form.meminum_table_tambah_darah" class="form-select w-full border border-orange-300 rounded p-2 py-1 text-sm">
            <option value="">Pilih</option>
            <option value="Ya">Ya</option>
            <option value="Tidak">Tidak</option>
          </select>
        </div>

        <div>
          <label for="penyuluhan_KIE" class="form-label font-normal text-sm">Penyuluhan KIE</label>
          <input v-model="form.penyuluhan_KIE" type="text" class="form-input w-full border border-orange-300 rounded p-2 py-1 text-sm" />
        </div>

        <div>
          <label for="fasilitas_layanan_rujukan" class="form-label font-normal text-sm">Fasilitas Layanan Rujukan</label>
          <input v-model="form.fasilitas_layanan_rujukan" type="text" class="form-input w-full border border-orange-300 rounded p-2 py-1 text-sm" />
        </div>

        <div>
          <label for="fasilitas_bantuan_sosial" class="form-label font-normal text-sm">Fasilitas Bantuan Sosial</label>
          <input v-model="form.fasilitas_bantuan_sosial" type="text" class="form-input w-full border border-orange-300 rounded p-2 py-1 text-sm" />
        </div>

        <div>
          <label class="form-label font-normal text-sm">Ibu Mengalami Stunting?</label>
          <select v-model="form.stunting" class="form-select w-full border border-orange-300 rounded p-2 py-1 text-sm">
            <option value="">Pilih</option>
            <option value="Ya">Ya</option>
            <option value="Tidak">Tidak</option>
          </select>
        </div>

        <div class="col-span-1 md:col-span-2 flex justify-end">
         <button type="submit" class="bg-green-500 text-white px-6 py-1 rounded hover:bg-green-600 transition text-sm">
  Simpan Data
</button>

        </div>
      </form>
    </div>
  </AppLayout>
</template>

<style scoped>
/* Tambahan gaya jika diperlukan */
</style>
