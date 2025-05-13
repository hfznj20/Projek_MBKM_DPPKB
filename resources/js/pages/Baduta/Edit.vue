<script lang="ts" setup>
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';
import { BreadcrumbItem } from '@/types';

const props = defineProps<{ 
  baduta: {
    nama: string;
    penduduk_nik?: string;  
    penduduk_ibu_nik: string,
    jumlah_anak_kandung: 0,
    tanggal_lahir_anak_terakhir: string,
    berat_badan: null,
    tinggi_badan: null,
    urutan_anak: null,
    umur_kehamilan_saat_lahir: null,
    asi_eksklusif: string,
    imunisasi_hepatitis_B: string,
    merokok_terpapar: string,
    mengisi_KKA: string,
    menggunakan_alat_kontrasepsi: string,
    meerokok_terpapar: string,
    sumber_air_minum: string,
    fasilitas_BAB: string,
    latitude?: string;
    longitude?: string;
    mendapatkan_tablet_tambah_darah: string,
    meminum_table_tambah_darah: string,
    penyuluhan_KIE: string,  
    fasilitas_bantuan_sosial: string,
    stunting: string,
  };
 }>();


// Inisialisasi form dengan data lama
const form = useForm({
  nama: props.baduta.nama,
  latitude: props.baduta.latitude ?? '',
  longitude: props.baduta.longitude ?? '',
  penduduk_nik: props.baduta.penduduk_nik ?? '',
  penduduk_ibu_nik: props.baduta.penduduk_ibu_nik ?? '',
  jumlah_anak_kandung: props.baduta.jumlah_anak_kandung ?? '',
  tanggal_lahir_anak_terakhir: props.baduta.tanggal_lahir_anak_terakhir ?? '',
  berat_badan: props.baduta.berat_badan ?? '',
  tinggi_badan: props.baduta.tinggi_badan ?? '',
  urutan_anak: props.baduta.urutan_anak ?? '',
  umur_kehamilan_saat_lahir: props.baduta.umur_kehamilan_saat_lahir ?? '',
  asi_eksklusif: props.baduta.asi_eksklusif ?? '',
  imunisasi_hepatitis_B: props.baduta.imunisasi_hepatitis_B ?? '',
  mengisi_KKA: props.baduta.mengisi_KKA ?? '',
  stunting: props.baduta.stunting ?? '',

  menggunakan_alat_kontrasepsi: props.baduta.menggunakan_alat_kontrasepsi ?? '',
  merokok_terpapar: props.baduta.merokok_terpapar ?? '',
  sumber_air_minum: props.baduta.sumber_air_minum ?? '',
  fasilitas_BAB: props.baduta.fasilitas_BAB ?? '',
  mendapatkan_tablet_tambah_darah: props.baduta.mendapatkan_tablet_tambah_darah ?? '',
  meminum_table_tambah_darah: props.baduta.meminum_table_tambah_darah ?? '',
  penyuluhan_KIE: props.baduta.penyuluhan_KIE ?? '',
  fasilitas_bantuan_sosial: props.baduta.fasilitas_bantuan_sosial ?? '',
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
  { title: 'Edit Data',   href: `/baduta/${props.baduta.penduduk_nik}/edit`,}
];

const errors = ref<string[]>([]);

const submitForm = () => {
  form.put(`/baduta/${props.baduta.penduduk_nik}`, {
  onSuccess: () => {
    window.location.href = '/penduduk';
  },
  onError: () => {
    errors.value = Object.values(form.errors).flat();
  }
});

};
const sumberAirOptions = [
  "Air kemasan", "Ledeng", "Sumur bor", "Sumur terlindungi", "Sumur tak terlindungi",
  "Mata air terlindungi", "Mata air tak terlindungi", "Air permukaan", "Air hujan", "Lainnya"
];

const fasilitasBABOptions = [
  "Jamban milik sendiri", "Jamban pada MCK", "Lainnya", "Tidak Ada"
];
</script>

<template>
  <Head title="Edit Data baduta" />
  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="container mt-5">
      <h2 class="mb-4">Edit Data baduta</h2>

      <div v-if="errors.length" class="alert alert-danger">
        <ul>
          <li v-for="(error, index) in errors" :key="index">{{ error }}</li>
        </ul>
      </div>

      <form @submit.prevent="submitForm">
        <input type="hidden" v-model="form.penduduk_nik" />

        <div class="mb-3">
           <label>NIK Ibu:</label>
            <input v-model="form.penduduk_ibu_nik" type="text" />
        </div>

        <div>
            <label>Tanggal Lahir Anak Terakhir:</label>
            <input v-model="form.tanggal_lahir_anak_terakhir" type="date" required />
        </div>

        <div>
            <label>Jumlah Anak Kandung:</label>
            <input v-model.number="form.jumlah_anak_kandung" type="number" required />
        </div>

        <div><label>Berat Badan (kg):</label><input v-model.number="form.berat_badan" type="number" step="0.01" required /></div>
        <div><label>Tinggi Badan (cm):</label><input v-model.number="form.tinggi_badan" type="number" step="0.1" required /></div>
        <div><label>Urutan Anak:</label><input v-model.number="form.urutan_anak" type="number" required /></div>
        <div><label>Umur Kehamilan Saat Lahir (minggu):</label><input v-model.number="form.umur_kehamilan_saat_lahir" type="number" required /></div>
        <div>
            <label>ASI Eksklusif?</label><br>
            <label><input type="radio" value="Ya" v-model="form.asi_eksklusif" /> Ya</label>
            <label><input type="radio" value="Tidak" v-model="form.asi_eksklusif" /> Tidak</label>
            </div>
        <div>
            <label>Imunisasi Hepatitis B?</label><br>
            <label><input type="radio" value="Ya" v-model="form.imunisasi_hepatitis_B" /> Ya</label>
            <label><input type="radio" value="Tidak" v-model="form.imunisasi_hepatitis_B" /> Tidak</label>
        </div>

        <div>
            <label>Menggunakan Kontrasepsi Saat Ini?</label><br>
            <label><input type="radio" value="Ya" v-model="form.menggunakan_alat_kontrasepsi" /> Ya</label>
            <label><input type="radio" value="Tidak" v-model="form.menggunakan_alat_kontrasepsi" /> Tidak</label>
        </div>
        <div>
            <label>Sumber Air Minum Utama:</label>
            <select v-model="form.sumber_air_minum">
            <option value="" disabled>Pilih</option>
            <option v-for="option in sumberAirOptions" :key="option" :value="option">{{ option }}</option>
            </select>
        </div>

        <div>
            <label>Terpapar Rokok?</label><br>
            <label><input type="radio" value="Ya" v-model="form.merokok_terpapar" /> Ya</label>
            <label><input type="radio" value="Tidak" v-model="form.merokok_terpapar" /> Tidak</label>
        </div>

        <div>
            <label>Fasilitas Buang Air Besar:</label>
            <select v-model="form.fasilitas_BAB">
            <option value="" disabled>Pilih</option>
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
          <label for="penyuluhan_KIE" class="form-label">Penyuluhan KIE</label>
          <input v-model="form.penyuluhan_KIE" type="text" class="form-control" id="penyuluhan_KIE" />
        </div>

        <div>
            <label>Bantuan Sosial:</label><br>
            <label><input type="radio" value="Ya, sedang di proses" v-model="form.fasilitas_bantuan_sosial" /> Ya, sedang di proses</label>
            <label><input type="radio" value="Ya, sudah mendapat bantuan sosial" v-model="form.fasilitas_bantuan_sosial" /> Ya, sudah mendapat</label>
            <label><input type="radio" value="Tidak, karena tidak memenuhi syarat" v-model="form.fasilitas_bantuan_sosial" /> Tidak, tidak memenuhi syarat</label>
            <label><input type="radio" value="Tidak, karena sudah menerima bantuan" v-model="form.fasilitas_bantuan_sosial" /> Tidak, sudah menerima</label>
        </div>
        <div>
            <label>Anak Mengalami Stunting?</label><br>
            <label><input type="radio" value="Ya" v-model="form.stunting" /> Ya</label>
            <label><input type="radio" value="Tidak" v-model="form.stunting" /> Tidak</label>
        </div>

        <button type="submit" class="btn btn-primary">Perbarui Data</button>
      </form>
    </div>
  </AppLayout>
</template>
