<script lang="ts" setup>
import AppLayout from '@/layouts/AppLayout.vue';
import { BreadcrumbItem } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const breadcrumbs: BreadcrumbItem[] = [
  { title: 'Tambah Data Catin', href: '/catin/create' },
];

const form = useForm({
  penduduk_nik: 0,
  nama: '',
  jenis_kelamin: '',
  tanggal_lahir: '',
  kelurahan: '',
  kecamatan: '',
  RT: '',
  RW: '',
  alamat: '',
  tinggi_badan: 0,
  berat_badan: 0,
  indeks_massa_tubuh: 0,
  kadar_hemoglobin: 0,
  LILA: 0,
  menggunakan_alat_kontrasepsi: '',
  catin_wanita_meerokok_terpapar: '',
  catin_pria_meerokok_terpapar: '',
  sumber_air_minum: '',
  fasilitas_BAB: '',
  longitude: '',
  latitude: '',
  mendapatkan_tablet_tambah_darah: '',
  meminum_table_tambah_darah: '',
  penyuluhan_KIE: '',
  fasilitas_layanan_rujukan: '',
  fasilitas_bantuan_sosial: '',
});

const errors = ref<string[]>([]);

const submitForm = () => {
  form.post('/catin/store', {
    onSuccess: () => {
      window.location.href = '/Catin';
    },
    onError: () => {
      errors.value = Object.values(form.errors).flat();
    }
  });
};
</script>

<template>
  <Head title="Tambah Data Catin" />
  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="container mt-5">
      <h2 class="mb-4">Tambah Data Catin</h2>

      <div v-if="errors.length" class="alert alert-danger">
        <ul>
          <li v-for="(error, index) in errors" :key="index">{{ error }}</li>
        </ul>
      </div>

      <form @submit.prevent="submitForm">
        <input type="hidden" v-model="form.penduduk_nik" />

        <div class="mb-3">
          <label class="form-label">Nama Catin</label>
          <input type="text" v-model="form.nama" class="form-control" required />
        </div>

        <div class="mb-3">
          <label class="form-label">Jenis Kelamin</label>
          <select v-model="form.jenis_kelamin" class="form-control" required>
            <option value="">- Pilih -</option>
            <option value="Laki-laki">Laki-laki</option>
            <option value="Perempuan">Perempuan</option>
          </select>
        </div>

        <div class="mb-3">
          <label class="form-label">Tanggal Lahir</label>
          <input type="date" v-model="form.tanggal_lahir" class="form-control" required />
        </div>

        <div class="mb-3">
          <label class="form-label">Kelurahan</label>
          <input type="text" v-model="form.kelurahan" class="form-control" required />
        </div>

        <div class="mb-3">
          <label class="form-label">Kecamatan</label>
          <select v-model="form.kecamatan" class="form-control" required>
            <option value="">- Pilih -</option>
            <option value="Ujung">Ujung</option>
            <option value="Bacukiki">Bacukiki</option>
            <option value="Bacukiki Barat">Bacukiki Barat</option>
            <option value="Soreang">Soreang</option>
          </select>
        </div>

        <div class="row">
          <div class="col-md-6 mb-3">
            <label class="form-label">RT</label>
            <input type="text" v-model="form.RT" class="form-control" required />
          </div>
          <div class="col-md-6 mb-3">
            <label class="form-label">RW</label>
            <input type="text" v-model="form.RW" class="form-control" required />
          </div>
        </div>

        <div class="mb-3">
          <label class="form-label">Alamat</label>
          <textarea v-model="form.alamat" class="form-control" required></textarea>
        </div>

        <!-- Tambahkan bagian lainnya sesuai dengan data kesehatan dan pendampingan -->

        <button type="submit" class="btn btn-success">Simpan Data</button>
      </form>
    </div>
  </AppLayout>
</template>
