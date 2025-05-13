<script lang="ts" setup>
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';
import { BreadcrumbItem } from '@/types';

const props = defineProps<{ 
  catin: {
    latitude?: string;
    longitude?: string;
    nik_catin1?: string;
    nik_catin2?: string;
    tanggal_pernikahan?: string;
    tinggi_badan: string,
    berat_badan: string,
    indeks_massa_tubuh: string,
    kadar_hemoglobin: string,
    LILA: string,
    menggunakan_alat_kontrasepsi: string,
    catin_wanita_merokok_terpapar: string,
    catin_pria_merokok_terpapar: string,
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
  nik_catin1: props.catin.nik_catin1 ?? '',
  nik_catin2: props.catin.nik_catin2 ?? '',
  tanggal_pernikahan: props.catin.tanggal_pernikahan,
  latitude: props.catin.latitude ?? '',
  longitude: props.catin.longitude ?? '',
  tinggi_badan: props.catin.tinggi_badan ?? '',
  berat_badan: props.catin.berat_badan ?? '',
  indeks_massa_tubuh: props.catin.indeks_massa_tubuh ?? '',
  kadar_hemoglobin: props.catin.kadar_hemoglobin ?? '',
  LILA: props.catin.LILA ?? '',
  menggunakan_alat_kontrasepsi: props.catin.menggunakan_alat_kontrasepsi ?? '',
  catin_wanita_merokok_terpapar: props.catin.catin_wanita_merokok_terpapar ?? '',
  catin_pria_merokok_terpapar: props.catin.catin_pria_merokok_terpapar ?? '',
  sumber_air_minum: props.catin.sumber_air_minum ?? '',
  fasilitas_BAB: props.catin.fasilitas_BAB ?? '',
  mendapatkan_tablet_tambah_darah: props.catin.mendapatkan_tablet_tambah_darah ?? '',
  meminum_table_tambah_darah: props.catin.meminum_table_tambah_darah ?? '',
  penyuluhan_KIE: props.catin.penyuluhan_KIE ?? '',
  fasilitas_layanan_rujukan: props.catin.fasilitas_layanan_rujukan ?? '',
  fasilitas_bantuan_sosial: props.catin.fasilitas_bantuan_sosial ?? '',
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
  { title: 'Edit Data',   href: `/catin/${props.catin.nik_catin1}/edit`,}
];

const errors = ref<string[]>([]);

const submitForm = () => {
  form.put(`/catin/${props.catin.nik_catin1}`, {
  onSuccess: () => {
    window.location.href = '/penduduk';
  },
  onError: () => {
    errors.value = Object.values(form.errors).flat();
  }
});

};

// Opsi dropdown
const sumberAirOptions = [
  "Air kemasan/Isi ulang", "Ledeng/PAM", "Sumur bor/Pompa", "Sumur terlindungi",
  "Sumur tak terlindungi", "Mata air terlindungi", "Mata air tak terlindungi",
  "Air permukaan (sungai/danau/waduk/kolam/irigasi)", "Air hujan", "Lainnya"
];

const fasilitasBABOptions = [
  "Jamban milik sendiri dengan leher angsa dan tangki septik/IPAL",
  "Jamban pada MCK komunal dengan eher angsa dan tangki/septik/IPAL", "Lainnya", "Tidak ada"
];
</script>

<template>
  <Head title="Edit Data catin" />
  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="container mt-5">
      <h2 class="mb-4">Edit Data catin</h2>

      <div v-if="errors.length" class="alert alert-danger">
        <ul>
          <li v-for="(error, index) in errors" :key="index">{{ error }}</li>
        </ul>
      </div>

      <form @submit.prevent="submitForm">
        <div class="mb-3">
            <label>Catin1:</label>
            <input v-model="form.nik_catin1" type="text" />
        </div>
        <div class="mb-3">
            <label>Catin2:</label>
            <input v-model="form.nik_catin2" type="text" />
        </div>

        <div class="mb-3">
          <label class="form-label">Tanggal Pernikahan</label>
          <input v-model="form.tanggal_pernikahan" type="date" class="form-control" required />
        </div>
        
        <div class="mb-3">
          <label class="form-label">Tinggi Badan</label>
          <input v-model="form.tinggi_badan" type="number" class="form-control" />
        </div>

        <div class="mb-3">
          <label class="form-label">Berat Badan</label>
          <input v-model="form.berat_badan" type="number" class="form-control" />
        </div>

        <div class="mb-3">
          <label class="form-label">Indeks Massa Tubuh (IMT)</label>
          <input v-model="form.indeks_massa_tubuh" type="number" class="form-control" />
        </div>

        <div class="mb-3">
          <label class="form-label">Kadar Hemoglobin</label>
          <input v-model="form.kadar_hemoglobin" type="number" class="form-control" />
        </div>

        <div class="mb-3">
          <label class="form-label">Lingkar Lengan Atas</label>
          <input v-model="form.LILA" type="number" class="form-control" />
        </div>

        <div class="mb-3">
          <label class="form-label">Apakah Catin Wanita merokok/terpapar rokok?</label>
          <select v-model="form.catin_wanita_merokok_terpapar" class="form-control">
            <option value="Ya">Ya</option>
            <option value="Tidak">Tidak</option>
          </select>
        </div>

        <div class="mb-3">
          <label class="form-label">Sumber Air Minum Utama</label>
          <select v-model="form.sumber_air_minum" class="form-control">
            <option v-for="option in sumberAirOptions" :key="option" :value="option">{{ option }}</option>
          </select>
        </div>

        <div class="mb-3">
          <label class="form-label">Fasilitas Buang Air Besar</label>
          <select v-model="form.fasilitas_BAB" class="form-control">
            <option v-for="option in fasilitasBABOptions" :key="option" :value="option">{{ option }}</option>
          </select>
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

        <button type="submit" class="btn btn-primary">Perbarui Data</button>
      </form>
    </div>
  </AppLayout>
</template>
