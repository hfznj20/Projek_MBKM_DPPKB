<script lang="ts" setup>
import AppLayout from '@/layouts/AppLayout.vue';
import { BreadcrumbItem } from '@/types';
import { ref, onMounted } from 'vue';
import { Head, useForm } from '@inertiajs/vue3';

const penduduk_nik = ref<string>(new URLSearchParams(window.location.search).get('nik') || '');

const form = useForm({
  penduduk_nik: penduduk_nik.value,
  tanggal_persalinan: '',
  tempat_persalinan: '',
  penolong_persalinan: '',
  cara_persalinan: '',
  keadaan_bayi: '',
  menggunakan_alat_kontrasepsi: '',
  meerokok_terpapar: '',
  sumber_air_minum: '',
  fasilitas_BAB: '',
  longitude: '',
  latitude: '',
  mendapatkan_tablet_tambah_darah: '',
  meminum_table_tambah_darah: '',
  penyuluhan_KIE: '',
  fasilitas_layanan_rujukan: ''
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
  { title: 'Tambah Data Persalinan', href: '/pasper/create' },
];

const errors = ref<string[]>([]);

const submitForm = () => {
  form.post('/pasper', {
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
  <Head title="Tambah Data Persalinan" />
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
          <label for="tanggal_persalinan" class="form-label font-normal text-sm">Tanggal Persalinan</label>
          <input v-model="form.tanggal_persalinan" type="date" class="form-input w-full border border-orange-300 rounded p-2 py-1 text-sm" id="tanggal_persalinan" required />
        </div>

        <div>
          <label for="tempat_persalinan" class="form-label font-normal text-sm">Tempat Persalinan</label>
          <input v-model="form.tempat_persalinan" type="text" class="form-input w-full border border-orange-300 rounded p-2 py-1 text-sm" id="tempat_persalinan" required />
        </div>

        <div>
          <label for="penolong_persalinan" class="form-label font-normal text-sm">Penolong Persalinan</label>
          <input v-model="form.penolong_persalinan" type="text" class="form-input w-full border border-orange-300 rounded p-2 py-1 text-sm" id="penolong_persalinan" required />
        </div>

        <div>
          <label for="cara_persalinan" class="form-label font-normal text-sm">Cara Persalinan</label>
          <input v-model="form.cara_persalinan" type="text" class="form-input w-full border border-orange-300 rounded p-2 py-1 text-sm" id="cara_persalinan" required />
        </div>

        <div>
          <label for="keadaan_bayi" class="form-label font-normal text-sm">Keadaan Bayi</label>
          <input v-model="form.keadaan_bayi" type="text" class="form-input w-full border border-orange-300 rounded p-2 py-1 text-sm" id="keadaan_bayi" required />
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
          <label for="fasilitas_BAB" class="form-label font-normal text-sm">Fasilitas Buang Air Besar</label>
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

        <div class="col-span-1 md:col-span-2 flex justify-end">
          <button type="submit" class="bg-green-500 text-white px-6 py-1 rounded hover:bg-green-600 transition text-sm">Simpan Data</button>
        </div>
      </form>
    </div>
  </AppLayout>
</template>

<style scoped>
/* Tambahan gaya jika diperlukan */
</style>