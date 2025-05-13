<script lang="ts" setup>
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';
import { BreadcrumbItem } from '@/types';

const props = defineProps<{ 
  pasper: {
    nama: string;
    penduduk_nik?: string;
    tanggal_persalinan: string,
    tempat_persalinan: string,
    penolong_persalinan: string,
    cara_persalinan: string,
    keadaan_bayi: string,
    menggunakan_alat_kontrasepsi: string,
    meerokok_terpapar: string,
    sumber_air_minum: string,
    fasilitas_BAB: string,
    latitude?: string;
    longitude?: string;
    mendapatkan_tablet_tambah_darah: string,
    meminum_table_tambah_darah: string,
    penyuluhan_KIE: string,
    fasilitas_layanan_rujukan: string,
  };
 }>();


// Inisialisasi form dengan data lama
const form = useForm({
  nama: props.pasper.nama,
  latitude: props.pasper.latitude ?? '',
  longitude: props.pasper.longitude ?? '',
  penduduk_nik: props.pasper.penduduk_nik ?? '',
  tanggal_persalinan: props.pasper.tanggal_persalinan ?? '',
  tempat_persalinan: props.pasper.tempat_persalinan ?? '',
  penolong_persalinan: props.pasper.penolong_persalinan ?? '',
  cara_persalinan: props.pasper.cara_persalinan ?? '',
  keadaan_bayi: props.pasper.keadaan_bayi ?? '',
  menggunakan_alat_kontrasepsi: props.pasper.menggunakan_alat_kontrasepsi ?? '',
  meerokok_terpapar: props.pasper.meerokok_terpapar ?? '',
  sumber_air_minum: props.pasper.sumber_air_minum ?? '',
  fasilitas_BAB: props.pasper.fasilitas_BAB ?? '',
  mendapatkan_tablet_tambah_darah: props.pasper.mendapatkan_tablet_tambah_darah ?? '',
  meminum_table_tambah_darah: props.pasper.meminum_table_tambah_darah ?? '',
  penyuluhan_KIE: props.pasper.penyuluhan_KIE ?? '',
  fasilitas_layanan_rujukan: props.pasper.fasilitas_layanan_rujukan ?? '',
});


onMounted(() => {
  if (navigator.geolocation && (!form.latitude || !form.longitude)) {
    navigator.geolocation.getCurrentPosition(
      (position) => {
        form.latitude = position.coords.latitude.toString();
        form.longitude = position.coords.longitude.toString();
      },
      (error) => {
        console.error('Gagal mengambil lokasi:', error);
      }
    );
  }
});

const breadcrumbs: BreadcrumbItem[] = [
  { title: 'Edit Data',   href: `/pasper/${props.pasper.penduduk_nik}/edit`,}
];

const errors = ref<string[]>([]);

const submitForm = () => {
  form.put(`/pasper/${props.pasper.penduduk_nik}`, {
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
  <Head title="Edit Data pasper" />
  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="container mt-5">
      <h2 class="mb-4">Edit Data pasper</h2>

      <div v-if="errors.length" class="alert alert-danger">
        <ul>
          <li v-for="(error, index) in errors" :key="index">{{ error }}</li>
        </ul>
      </div>

      <form @submit.prevent="submitForm">
        <input type="hidden" v-model="form.penduduk_nik" />

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
          <input v-model="form.longitude" type="text" class="form-control" id="longitude" readonly />
        </div>

        <div class="mb-3">
          <label for="latitude" class="form-label">Latitude</label>
          <input v-model="form.latitude" type="text" class="form-control" id="latitude" readonly />
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

        <button type="submit" class="btn btn-primary">Perbarui Data</button>
      </form>
    </div>
  </AppLayout>
</template>
