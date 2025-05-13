<script lang="ts" setup>
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';
import { BreadcrumbItem } from '@/types';

const props = defineProps<{ 
  bumil: {
    nama: string;
    status_hamil: string;
    usia_kehamilan: string;
    latitude?: string;
    longitude?: string;
    penduduk_nik?: string;
    stunting?: string;
    TUF: string,
    jumlah_anak_kandung: string,
    tgl_lahir_ank_terakhir: string,
    tinggi_badan: string,
    berat_badan_sebelum_hamil: string,
    berat_badan_saat_ini: string,
    indeks_massa_tubuh: string,
    kadar_hemoglobin: string,
    LILA: string,
    menggunakan_alat_kontrasepsi: string,
    meerokok_terpapar: string,
    sumber_air_minum: string,
    fasilitas_BAB: string,
    mendapatkan_tablet_tambah_darah: string,
    meminum_table_tambah_darah: string,
    penyuluhan_KIE: string,
    fasilitas_layanan_rujukan: string,
    fasilitas_bantuan_sosial: string,
  };
 }>();


// Inisialisasi form dengan data lama
const form = useForm({
  nama: props.bumil.nama,
  status_hamil: props.bumil.status_hamil,
  usia_kehamilan: props.bumil.usia_kehamilan,
  latitude: props.bumil.latitude ?? '',
  longitude: props.bumil.longitude ?? '',
  penduduk_nik: props.bumil.penduduk_nik ?? '',
  stunting: props.bumil.stunting ?? '',
  TUF: props.bumil.TUF ?? '', // Taksiran Usia Fertilitas
  jumlah_anak_kandung: props.bumil.jumlah_anak_kandung ?? '',
  tgl_lahir_ank_terakhir: props.bumil.tgl_lahir_ank_terakhir ?? '',
  tinggi_badan: props.bumil.tinggi_badan ?? '',
  berat_badan_sebelum_hamil: props.bumil.berat_badan_sebelum_hamil ?? '',
  berat_badan_saat_ini: props.bumil.berat_badan_saat_ini ?? '',
  indeks_massa_tubuh: props.bumil.indeks_massa_tubuh ?? '',
  kadar_hemoglobin: props.bumil.kadar_hemoglobin ?? '',
  LILA: props.bumil.LILA ?? '',
  menggunakan_alat_kontrasepsi: props.bumil.menggunakan_alat_kontrasepsi ?? '',
  meerokok_terpapar: props.bumil.meerokok_terpapar ?? '',
  sumber_air_minum: props.bumil.sumber_air_minum ?? '',
  fasilitas_BAB: props.bumil.fasilitas_BAB ?? '',
  mendapatkan_tablet_tambah_darah: props.bumil.mendapatkan_tablet_tambah_darah ?? '',
  meminum_table_tambah_darah: props.bumil.meminum_table_tambah_darah ?? '',
  penyuluhan_KIE: props.bumil.penyuluhan_KIE ?? '',
  fasilitas_layanan_rujukan: props.bumil.fasilitas_layanan_rujukan ?? '',
  fasilitas_bantuan_sosial: props.bumil.fasilitas_bantuan_sosial ?? '',
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
  { title: 'Edit Data',   href: `/bumil/${props.bumil.penduduk_nik}/edit`,}
];

const errors = ref<string[]>([]);

const submitForm = () => {
  form.put(`/bumil/${props.bumil.penduduk_nik}`, {
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
  <Head title="Edit Data Bumil" />
  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="container mt-5">
      <h2 class="mb-4">Edit Data Bumil</h2>

      <div v-if="errors.length" class="alert alert-danger">
        <ul>
          <li v-for="(error, index) in errors" :key="index">{{ error }}</li>
        </ul>
      </div>

      <form @submit.prevent="submitForm">
        <input type="hidden" v-model="form.penduduk_nik" />

        <div class="mb-3">
          <label for="usia_kehamilan" class="form-label">Usia Kehamilan</label>
          <input v-model="form.usia_kehamilan" type="text" class="form-control" id="usia_kehamilan" required />
        </div>
        
        <div class="mb-3">
          <label for="TUF" class="form-label">TUF</label>
          <input v-model="form.TUF" type="text" class="form-control" id="TUF" required />
        </div>
        <div class="mb-3">
          <label for="jumlah_anak_kandung" class="form-label">Jumlah Anak Kandung</label>
          <input v-model="form.jumlah_anak_kandung" type="text" class="form-control" id="jumlah_anak_kandung" required />
        </div>
        <div class="mb-3">
          <label for="tgl_lahir_ank_terakhir" class="form-label">Tanggal Lahir anak terakhir</label>
          <input v-model="form.tgl_lahir_ank_terakhir" type="date" class="form-control" id="tgl_lahir_ank_terakhir" required />
        </div>
        <div class="mb-3">
          <label for="tinggi_badan" class="form-label">Tinggi Badan</label>
          <input v-model="form.tinggi_badan" type="text" class="form-control" id="tinggi_badan" required />
        </div>
        <div class="mb-3">
          <label for="berat_badan_sebelum_hamil" class="form-label">Berat Badan Sebelum Hamil</label>
          <input v-model="form.berat_badan_sebelum_hamil" type="text" class="form-control" id="berat_badan_sebelum_hamil" required />
        </div>
        <div class="mb-3">
          <label for="berat_badan_saat_ini" class="form-label">Berat Badan Saat Ini</label>
          <input v-model="form.berat_badan_saat_ini" type="text" class="form-control" id="berat_badan_saat_ini" required />
        </div>
        <div class="mb-3">
          <label for="indeks_massa_tubuh" class="form-label">Indeks Massa Tubuh</label>
          <input v-model="form.indeks_massa_tubuh" type="text" class="form-control" id="indeks_massa_tubuh" required />
        </div>
        <div class="mb-3">
          <label for="kadar_hemoglobin" class="form-label">Kadar Hemoglobin</label>
          <input v-model="form.kadar_hemoglobin" type="text" class="form-control" id="kadar_hemoglobin" required />
        </div>
        <div class="mb-3">
          <label for="LILA" class="form-label">LILA</label>
          <input v-model="form.LILA" type="text" class="form-control" id="LILA" required />
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

        <div class="mb-3">
          <label for="fasilitas_bantuan_sosial" class="form-label">Fasilitas Bantuan Sosial</label>
          <input v-model="form.fasilitas_bantuan_sosial" type="text" class="form-control" id="fasilitas_bantuan_sosial" />
        </div>
        
        <div>
            <label>Ibu Mengalami Stunting?</label><br>
            <label><input type="radio" value="Ya" v-model="form.stunting" /> Ya</label>
            <label><input type="radio" value="Tidak" v-model="form.stunting" /> Tidak</label>
        </div>

        <button type="submit" class="btn btn-primary">Perbarui Data</button>
      </form>
    </div>
  </AppLayout>
</template>
