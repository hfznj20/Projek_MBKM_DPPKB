<script lang="ts" setup>
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';
import { BreadcrumbItem } from '@/types';
import Modal from '@/components/Modal.vue';
import axios from 'axios';

// Ambil 'nik' dari URL (query param)
const penduduk_nik = ref<string>(new URLSearchParams(window.location.search).get('nik') || '');
const namaPasangan = ref<string>('');

// Breadcrumbs
const breadcrumbs: BreadcrumbItem[] = [
  { title: 'Tambah Data Catin', href: '/catin/create' },
];

type Kecamatan = 'Ujung' | 'Bacukiki' | 'Bacukiki Barat' | 'Soreang';

const sumberAirOptions = [
  "Air kemasan/Isi ulang", "Ledeng/PAM", "Sumur bor/Pompa", "Sumur terlindungi",
  "Sumur tak terlindungi", "Mata air terlindungi", "Mata air tak terlindungi",
  "Air permukaan (sungai/danau/waduk/kolam/irigasi)", "Air hujan", "Lainnya"
];

const fasilitasBABOptions = [
  "Jamban milik sendiri dengan leher angsa dan tangki septik/IPAL",
  "Jamban pada MCK komunal dengan eher angsa dan tangki/septik/IPAL", "Lainnya", "Tidak ada"
];

const kelurahanMap: Record<Kecamatan, string[]> = {
  Ujung: ['Kelurahan Ujung A', 'Kelurahan Ujung B', 'Kelurahan Ujung C'],
  Bacukiki: ['Kelurahan Bacukiki A', 'Kelurahan Bacukiki B'],
  'Bacukiki Barat': ['Kelurahan Bacukiki Barat A', 'Kelurahan Bacukiki Barat B'],
  Soreang: ['Kelurahan Soreang A', 'Kelurahan Soreang B', 'Kelurahan Soreang C']
};

const kelurahanOptions = ref<string[]>([]);

const onKecamatanChange = () => {
  const selected = formPasangan.kecamatan;
  kelurahanOptions.value = selected && kelurahanMap[selected as Kecamatan]
    ? kelurahanMap[selected as Kecamatan]
    : [];
};

// Form state untuk Catin
const form = useForm({
  nik_catin1: penduduk_nik.value, // Set nik_catin1 from URL
  nik_catin2: '',
  nama: '',
  tanggal_pernikahan: '',
  tinggi_badan: 0,
  berat_badan: 0,
  indeks_massa_tubuh: 0,
  kadar_hemoglobin: 0,
  LILA: 0,
  menggunakan_alat_kontrasepsi: '',
  catin_wanita_merokok_terpapar: '',
  catin_pria_merokok_terpapar: '',
  sumber_air_minum: '',
  fasilitas_BAB: '',
  longitude: '',
  latitude: '',
  mendapatkan_tablet_tambah_darah: '',
  meminum_tablet_tambah_darah: '',
  penyuluhan_KIE: '',
  fasilitas_layanan_rujukan: '',
  fasilitas_bantuan_sosial: '',
  penduduk_nik: penduduk_nik.value,
});

const goToFormPendudukBaru = () => {
  showModal.value = true;
};

// Step Control
const step = ref(1);
const errors = ref<string[]>([]);

//lokasi
onMounted(() => {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(
      (position) => {
        form.latitude = position.coords.latitude.toString()
        form.longitude = position.coords.longitude.toString()
      },
      (error) => {
        console.error('Gagal mengambil lokasi:', error)
      }
    )
  } else {
    console.warn('Geolocation tidak didukung browser ini.')
  }
})

// Form state untuk Pasangan Baru
const showModal = ref(false);

const formPasangan = useForm({
  nik: '',
  nama: '',
  tanggal_lahir: '',
  jenis_kelamin: '',
  kecamatan: '' as Kecamatan | '',
  kelurahan: '',
  RT: '',
  RW: '',
  alamat: '',
  no_hp: '',
  kategori: 'CATIN'
});

// Cek data pasangan
const checkPasangan = async () => {
  try {
    const response = await axios.post('/cek-nik', {
      nik: form.nik_catin2
    });

    if (response.data.status === 'data ada') {
      namaPasangan.value = response.data.nama;
    } else {
      namaPasangan.value = '';
      alert("Data pasangan tidak ditemukan. Anda dapat menambah data pasangan baru.");
      showModal.value = true;
    }
  } catch (error: unknown) {
    namaPasangan.value = '';
    if (error instanceof Error) {
      alert("Terjadi kesalahan: " + error.message);
    } else {
      alert("Terjadi kesalahan tidak diketahui");
    }
  }
};

// Submit data pasangan baru
const submitPasangan = () => {
  formPasangan.post('/penduduk', {
    preserveScroll: true,
    preserveState: true,
    onSuccess: () => {
      form.nik_catin2 = formPasangan.nik;
      namaPasangan.value = formPasangan.nama;
      showModal.value = false;
    },
    onError: (errors) => {
      console.error('Error saving partner data:', errors);
    }
  });
};


const nextStep = () => {
  step.value++;
};

const prevStep = () => {
  step.value--;
};

const goToNextStep = () => {
  if (step.value === 1 && (!form.nik_catin2 || !namaPasangan.value)) {
    alert('Silakan isi dan cek NIK Ibu terlebih dahulu.');
    return;
  }
  step.value++;
};

// Submit Form Catin
const submitForm = () => {
  errors.value = [];

  // Cek apakah latitude dan longitude belum terisi
  if (!form.latitude || !form.longitude) {
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(
        (position) => {
          form.latitude = position.coords.latitude.toString();
          form.longitude = position.coords.longitude.toString();

          // Setelah dapat lokasi, baru kirim form
          form.post('/baduta', {
            onSuccess: () => {
              window.location.href = '/penduduk';
            },
            onError: () => {
              errors.value = Object.values(form.errors).flat();
            },
          });
        },
        (error) => {
          alert('Gagal mengambil lokasi: ' + error.message);
        }
      );
    } else {
      alert('Geolocation tidak didukung browser ini.');
    }
    return; // hentikan proses sampai lokasi diambil
  }

  form.post('/catin', {
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
  <Head title="Tambah Data Catin" />
  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="container mt-5">
      <h2 class="mb-4">Tambah Data Catin</h2>

      <!-- Error Message -->
      <div v-if="errors.length" class="alert alert-danger">
        <ul>
          <li v-for="(error, index) in errors" :key="index">{{ error }}</li>
        </ul>
      </div>

      <!-- Step 1: Data Catin -->
      <div v-if="step === 1">
        <h3>Data Pasangan</h3>
        
        <div v-if="errors.length" class="alert alert-danger">
          <ul>
            <li v-for="(error, index) in errors" :key="index">{{ error }}</li>
          </ul>
        </div>

        <!-- NIK Catin -->
        <div class="mb-3">
          <label class="form-label">NIK Catin</label>
          <input type="text" v-model="form.nik_catin1" class="form-control" disabled />
        </div>

        <!-- Nama Catin -->
        <div class="mb-3">
          <label class="form-label">Nama Catin</label>
          <input type="text" v-model="form.nama" class="form-control" disabled />
        </div>

        <div class="mb-3">
          <label class="form-label">NIK Pasangan</label>
          <input v-model="form.nik_catin2" type="text" class="form-control" placeholder="Masukkan NIK Pasangan" maxlength="16"/>
          <button type="button" @click="checkPasangan" class="btn btn-info mt-2">Cek Data Pasangan</button>
        </div>

        <div v-if="namaPasangan">
          <p><strong>Nama Pasangan:</strong> {{ namaPasangan }}</p>
        </div>

        <div v-if="!namaPasangan && form.nik_catin2">
          <button type="button" @click="goToFormPendudukBaru" class="btn btn-warning">Tambah Pasangan Baru</button>
        </div>

        <button type="button" @click="goToNextStep">Next</button>
      </div>

      <!-- Step 2: Form Data Kesehatan Catin -->
      <div v-if="step === 2">
        <h3>Form Data Kesehatan Catin</h3>
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

        <button type="button" @click="prevStep" class="btn btn-secondary">Back</button>
        <button type="button" @click="nextStep" class="btn btn-primary">Next</button>
      </div>

      <!-- Step 3: Data Pendampingan Bulanan -->
      <div v-if="step === 3">
        <h3>Data Pendampingan</h3>

        <button type="button" @click="prevStep" class="btn btn-secondary">Back</button>
        <button type="submit" class="btn btn-success" @click="submitForm">Simpan Data</button>
      </div>

      <!-- Modal Untuk Input Data Pasangan -->
      <Modal v-model:show="showModal">
        <h3>Tambah Data Pasangan Baru</h3>
        <form @submit.prevent="submitPasangan">
          <div class="mb-3">
            <label class="form-label">NIK Pasangan</label>
            <input v-model="formPasangan.nik" type="text" class="form-control" maxlength="16" required />
          </div>

          <div class="mb-3">
            <label class="form-label">Nama Pasangan</label>
            <input v-model="formPasangan.nama" type="text" class="form-control" required />
          </div>

          <div class="mb-3">
            <label class="form-label">Tanggal Lahir</label>
            <input v-model="formPasangan.tanggal_lahir" type="date" class="form-control" required />
          </div>

          <div class="mb-3">
            <label class="form-label">Jenis Kelamin</label>
            <select v-model="formPasangan.jenis_kelamin" class="form-control" required>
              <option value="">-- Pilih --</option>
              <option value="Laki-laki">Laki-laki</option>
              <option value="Perempuan">Perempuan</option>
            </select>
          </div>
          
          <div class="mb-3">
            <label for="kecamatan" class="form-label">Kecamatan</label>
            <select v-model="formPasangan.kecamatan" @change="onKecamatanChange" class="form-select" id="kecamatan" required>
              <option value="">-- Pilih --</option>
              <option value="Ujung">Ujung</option>
              <option value="Bacukiki">Bacukiki</option>
              <option value="Bacukiki Barat">Bacukiki Barat</option>
              <option value="Soreang">Soreang</option>
            </select>
          </div>
        
          <div class="mb-3">
            <label for="kelurahan" class="form-label">Kelurahan</label>
            <select v-model="formPasangan.kelurahan" class="form-select" id="kelurahan" required>
              <option value="">-- Pilih Kelurahan --</option>
              <option v-for="kelurahan in kelurahanOptions" :key="kelurahan" :value="kelurahan">
                {{ kelurahan }}
              </option>
            </select>
          </div>

          <div class="mb-3">
            <label class="form-label">RT</label>
            <input v-model="formPasangan.RT" type="text" class="form-control" required />
          </div>

          <div class="mb-3">
            <label class="form-label">RW</label>
            <input v-model="formPasangan.RW" type="text" class="form-control" required />
          </div>

          <div class="mb-3">
            <label for="alamat" class="form-label">Alamat</label>
            <textarea v-model="formPasangan.alamat" id="alamat" class="form-control" rows="3" required></textarea>
          </div>

          <div class="mb-3">
            <label for="no_hp" class="form-label">No HP</label>
            <input v-model="formPasangan.no_hp" type="text" class="form-control" id="no_hp" required />
          </div>
          <button type="button" class="btn btn-success" @click="submitPasangan">Simpan Data</button>
          <button type="button" class="btn btn-secondary" @click="showModal = false">Tutup</button>
        </form>
      </Modal>
    </div>
  </AppLayout>
</template>

<style scoped>
/* Styling */
input, select, button {
  display: block;
  margin-bottom: 10px;
  width: 100%;
}
label {
  font-weight: 500;
}
button {
  margin-top: 15px;
}
</style>