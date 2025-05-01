<script lang="ts" setup>
import AppLayout from '@/layouts/AppLayout.vue';
import { BreadcrumbItem } from '@/types';
import { ref } from 'vue';
import { Head, useForm } from '@inertiajs/vue3';

// Props dari controller Laravel
const props = defineProps<{
  nik: string
}>();


// Form data termasuk penduduk_id
const form = useForm({
  penduduk_id: props.nik,
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

// Breadcrumbs
const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Tambah Data Persalinan',
    href: '/pasper/create',
  },
];

const errors = ref<string[]>([]);

const submitForm = () => {
  form.post('/pasper', {
    onSuccess: () => {
      window.location.href = '/Pasper/Index';
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
    <div class="container mt-5">
      <h2 class="mb-4">Tambah Data Persalinan</h2>

      <div v-if="errors.length" class="alert alert-danger">
        <ul>
          <li v-for="(error, index) in errors" :key="index">{{ error }}</li>
        </ul>
      </div>

      <form @submit.prevent="submitForm">
        <input type="hidden" v-model="form.penduduk_id" />

        <div class="mb-3">
          <label for="tanggal_persalinan" class="form-label">Tanggal Persalinan</label>
          <input v-model="form.tanggal_persalinan" type="date" class="form-control" id="tanggal_persalinan" required />
        </div>

        <div class="mb-3">
          <label for="tempat_persalinan" class="form-label">Tempat Persalinan</label>
          <input v-model="form.tempat_persalinan" type="text" class="form-control" id="tempat_persalinan" required />
        </div>

        <div class="mb-3">
          <label for="penolong_persalinan" class="form-label">Penolong Persalinan</label>
          <input v-model="form.penolong_persalinan" type="text" class="form-control" id="penolong_persalinan" required />
        </div>

        <div class="mb-3">
          <label for="cara_persalinan" class="form-label">Cara Persalinan</label>
          <input v-model="form.cara_persalinan" type="text" class="form-control" id="cara_persalinan" required />
        </div>

        <div class="mb-3">
          <label for="keadaan_bayi" class="form-label">Keadaan Bayi</label>
          <input v-model="form.keadaan_bayi" type="text" class="form-control" id="keadaan_bayi" required />
        </div>

        <div class="mb-3">
          <label>Menggunakan Alat Kontrasepsi?</label><br />
          <input v-model="form.menggunakan_alat_kontrasepsi" type="radio" name="kontrasepsi" value="Ya" /> Ya
          <input v-model="form.menggunakan_alat_kontrasepsi" type="radio" name="kontrasepsi" value="Tidak" /> Tidak
        </div>

        <div class="mb-3">
          <label>Terpapar Asap Rokok?</label><br />
          <input v-model="form.meerokok_terpapar" type="radio" name="asap" value="Ya" /> Ya
          <input v-model="form.meerokok_terpapar" type="radio" name="asap" value="Tidak" /> Tidak
        </div>

        <div class="mb-3">
          <label for="sumber_air_minum" class="form-label">Sumber Air Minum</label>
          <input v-model="form.sumber_air_minum" type="text" class="form-control" id="sumber_air_minum" />
        </div>

        <div class="mb-3">
          <label for="fasilitas_BAB" class="form-label">Fasilitas Buang Air Besar</label>
          <input v-model="form.fasilitas_BAB" type="text" class="form-control" id="fasilitas_BAB" />
        </div>

        <div class="mb-3">
          <label for="longitude" class="form-label">Longitude</label>
          <input v-model="form.longitude" type="text" class="form-control" id="longitude" required />
        </div>

        <div class="mb-3">
          <label for="latitude" class="form-label">Latitude</label>
          <input v-model="form.latitude" type="text" class="form-control" id="latitude" required />
        </div>

        <div class="mb-3">
          <label>Mendapatkan Tablet Tambah Darah?</label><br />
          <input v-model="form.mendapatkan_tablet_tambah_darah" type="radio" name="tambah_darah" value="Ya" /> Ya
          <input v-model="form.mendapatkan_tablet_tambah_darah" type="radio" name="tambah_darah" value="Tidak" /> Tidak
        </div>

        <div class="mb-3">
          <label>Meminum Tablet Tambah Darah?</label><br />
          <input v-model="form.meminum_table_tambah_darah" type="radio" name="minum_darah" value="Ya" /> Ya
          <input v-model="form.meminum_table_tambah_darah" type="radio" name="minum_darah" value="Tidak" /> Tidak
        </div>

        <div class="mb-3">
          <label for="penyuluhan_KIE" class="form-label">Penyuluhan KIE</label>
          <input v-model="form.penyuluhan_KIE" type="text" class="form-control" id="penyuluhan_KIE" />
        </div>

        <div class="mb-3">
          <label for="fasilitas_layanan_rujukan" class="form-label">Fasilitas Layanan Rujukan</label>
          <input v-model="form.fasilitas_layanan_rujukan" type="text" class="form-control" id="fasilitas_layanan_rujukan" />
        </div>

        <button type="submit" class="btn btn-success">Simpan Data</button>
      </form>
    </div>
  </AppLayout>
</template>

<style scoped>
/* Tambahan style jika diperlukan */
</style>

