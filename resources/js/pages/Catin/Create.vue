<script lang="ts" setup>
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { ref, onMounted, watch } from 'vue';
import { BreadcrumbItem } from '@/types';
import Modal from '@/components/Modal.vue';
import axios from 'axios';
import { MagnifyingGlassIcon, PlusIcon } from '@heroicons/vue/24/solid';

const penduduk_nik = ref<string>(new URLSearchParams(window.location.search).get('nik') || '');
const namaCatin = ref<string>('');

// Breadcrumbs
const breadcrumbs: BreadcrumbItem[] = [
  { title: 'Tambah Data Catin', href: '/catin/create' },
];

// Opsi dropdown
const sumberAirOptions = [
  "Air kemasan/Isi ulang", "Ledeng/PAM", "Sumur bor/Pompa", "Sumur terlindungi",
  "Sumur tak terlindungi", "Mata air terlindungi", "Mata air tak terlindungi",
  "Air permukaan (sungai/danau/waduk/kolam/irigasi)", "Air hujan", "Lainnya"
];

type Kecamatan = 'Ujung' | 'Bacukiki' | 'Bacukiki Barat' | 'Soreang';

const fasilitasBABOptions = [
  "Jamban milik sendiri dengan leher angsa dan tangki septik/IPAL",
  "Jamban pada MCK komunal dengan leher angsa dan tangki/septik/IPAL", "Lainnya", "Tidak ada"
];

const kelurahanMap: Record<Kecamatan, string[]> = {
  Ujung: ['Kelurahan Ujung A', 'Kelurahan Ujung B', 'Kelurahan Ujung C'],
  Bacukiki: ['Kelurahan Bacukiki A', 'Kelurahan Bacukiki B'],
  'Bacukiki Barat': ['Kelurahan Bacukiki Barat A', 'Kelurahan Bacukiki Barat B'],
  Soreang: ['Kelurahan Soreang A', 'Kelurahan Soreang B', 'Kelurahan Soreang C']
};

const kelurahanOptions = ref<string[]>([]);

// Form state untuk Catin
const form = useForm({
  nik_catin1: penduduk_nik.value,
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

// Form state untuk Pasangan Baru
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
  kategori: 'catin'
});

const errors = ref<string[]>([]);
const showModal = ref(false);
const namaPasangan = ref<string>('');

// Step Control
const step = ref(1);
const isSubmitting = ref(false);
const noHpWithoutCode = ref<string>('');

// Fetch catin data when component mounts
onMounted(async () => {
  if (penduduk_nik.value) {
    try {
      const response = await axios.post('/cek-nik', {
        nik: penduduk_nik.value
      });
      if (response.data.status === 'data ada') {
        namaCatin.value = response.data.nama;
        form.nama = response.data.nama;
      }
    } catch (error) {
      console.error('Error fetching catin data:', error);
    }
  }

  // Ambil lokasi GPS
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(
      position => {
        form.latitude = position.coords.latitude.toString();
        form.longitude = position.coords.longitude.toString();
      },
      error => {
        console.warn('Gagal mendapatkan lokasi:', error.message);
      }
    );
  }
});

// Watcher for BMI calculation
watch(
  () => [form.berat_badan, form.tinggi_badan],
  ([berat, tinggi]) => {
    if (berat > 0 && tinggi > 0) {
      const tinggiMeter = tinggi / 100;
      form.indeks_massa_tubuh = parseFloat((berat / (tinggiMeter * tinggiMeter)).toFixed(2));
    } else {
      form.indeks_massa_tubuh = 0;
    }
  }
);

const onKecamatanChange = () => {
  const selected = formPasangan.kecamatan;
  kelurahanOptions.value = selected && kelurahanMap[selected as Kecamatan]
    ? kelurahanMap[selected as Kecamatan]
    : [];
};

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
const submitPasangan = async () => {
  if (isSubmitting.value) return;
  isSubmitting.value = true;

  try {
    await formPasangan.post('/catin/storePasanganBaru', {
      preserveScroll: true,
      preserveState: true,
      onSuccess: () => {
        form.nik_catin2 = formPasangan.nik;
        namaPasangan.value = formPasangan.nama;
        showModal.value = false;
        formPasangan.reset();
      },
      onError: (errors) => {
        console.error('Error saving partner data:', errors);
        alert("Kesalahan saat menyimpan data pasangan: " + JSON.stringify(errors));
      }
    });
  } catch (error) {
    console.error('Error saving partner data:', error);
    alert("Terjadi kesalahan: " + (error.response?.data?.message || "Kesalahan tidak diketahui"));
  } finally {
    isSubmitting.value = false;
  }
};

// Submit Form Catin
const submitForm = () => {
  if (isSubmitting.value) return;
  isSubmitting.value = true;

  form.post('/catin', {
    onSuccess: (response) => {
      console.log('Data berhasil disimpan:', response);
      window.location.href = '/penduduk';
    },
    onError: () => {
      errors.value = Object.values(form.errors).flat();
      console.error('Kesalahan saat menyimpan data:', errors.value);
      isSubmitting.value = false;
    }
  });
};

const nextStep = () => {
  step.value++;
};

const prevStep = () => {
  step.value--;
};

const goToFormPendudukBaru = () => {
  showModal.value = true;
};

// Update form.no_hp setiap kali user mengetik
watch(noHpWithoutCode, (val) => {
  formPasangan.no_hp = val ? `+62${val}` : '';
});
</script>

<template>
  <Head title="Tambah Data Catin" />
  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="p-6">
      <div class="bg-white shadow rounded p-4 relative">
        <div v-if="errors.length" class="alert alert-danger">
          <ul>
            <li v-for="(error, index) in errors" :key="index">{{ error }}</li>
          </ul>
        </div>
        <form @submit.prevent="submitForm">
          <!-- Step 1: Data Catin -->
          <div v-if="step === 1">
            <div class="mb-3">
              <label class="form-label text-sm font-normal">NIK Catin:</label>
              <input
                type="text"
                v-model="form.nik_catin1"
                class="form-control py-1 border border-orange-500 rounded-sm text-sm font-normal px-2"
                disabled
              />
            </div>
            <div class="mb-3">
              <label class="form-label text-sm font-normal">Nama Catin:</label>
              <input
                type="text"
                v-model="form.nama"
                class="form-control py-1 border border-orange-500 rounded-sm text-sm font-normal px-2"
                disabled
              />
            </div>
            <div class="mb-3">
              <label class="form-label text-sm font-normal">NIK Pasangan:</label>
              <input
                v-model="form.nik_catin2"
                type="text"
                class="form-control py-1 border border-orange-500 rounded-sm text-sm font-normal px-2"
                placeholder="Masukkan NIK Pasangan"
                maxlength="16"
              />
              <div class="flex gap-3 mt-2">
                <button
                  type="button"
                  @click="checkPasangan"
                  class="flex items-center gap-2 px-4 py-1 bg-orange-500 text-white rounded text-sm font-normal"
                >
                  <MagnifyingGlassIcon class="w-4 h-4" />
                  Cek Data Pasangan
                </button>
                <button
                  type="button"
                  @click="goToFormPendudukBaru"
                  class="flex items-center gap-2 px-4 py-1 bg-green-600 text-white rounded text-sm font-normal"
                >
                  <PlusIcon class="w-4 h-4" />
                  Tambah Pasangan Baru
                </button>
              </div>
            </div>
            <div v-if="namaPasangan" class="mt-2 text-sm font-normal">
              <strong>Nama Pasangan:</strong> {{ namaPasangan }}
            </div>
            <button
              class="bg-[#2F2E81] hover:bg-[#1f1e5e] text-white text-sm font-normal px-4 py-1 rounded shadow"
              @click="nextStep"
              :disabled="!namaPasangan || isSubmitting"
            >
              Berikutnya
            </button>
          </div>

          <!-- Step 2: Form Data Kesehatan Catin -->
          <div v-if="step === 2">
            <h3>Form Data Kesehatan Catin</h3>
            <div class="mb-3">
              <label class="form-label">Tanggal Pernikahan:</label>
              <input v-model="form.tanggal_pernikahan" type="date" class="form-control" required />
            </div>
            <div class="mb-3">
              <label class="form-label">Tinggi Badan:</label>
              <input v-model="form.tinggi_badan" type="number" class="form-control" />
            </div>
            <div class="mb-3">
              <label class="form-label">Berat Badan:</label>
              <input v-model="form.berat_badan" type="number" class="form-control" />
            </div>
            <div class="mb-3">
              <label class="form-label">Indeks Massa Tubuh (IMT):</label>
              <input v-model="form.indeks_massa_tubuh" type="number" class="form-control" readonly />
            </div>
            <div class="mb-3">
              <label class="form-label">Kadar Hemoglobin:</label>
              <input v-model="form.kadar_hemoglobin" type="number" class="form-control" />
            </div>
            <div class="mb-3">
              <label class="form-label">Lingkar Lengan Atas:</label>
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
              <label class="form-label">Sumber Air Minum Utama:</label>
              <select v-model="form.sumber_air_minum" class="form-control">
                <option v-for="option in sumberAirOptions" :key="option" :value="option">{{ option }}</option>
              </select>
            </div>
            <div class="mb-3">
              <label class="form-label">Fasilitas Buang Air Besar:</label>
              <select v-model="form.fasilitas_BAB" class="form-control">
                <option v-for="option in fasilitasBABOptions" :key="option" :value="option">{{ option }}</option>
              </select>
            </div>
            <div class="flex justify-between mt-4">
              <button type="button" @click="prevStep" class="btn btn-secondary">Kembali</button>
              <button type="button" @click="nextStep" class="btn btn-primary">Berikutnya</button>
            </div>
          </div>

          <!-- Step 3: Data Pendampingan Bulanan -->
          <div v-if="step === 3">
            <h3>Data Pendampingan</h3>
            <div class="mb-3">
              <label class="form-label">Longitude:</label>
              <input v-model="form.longitude" type="text" class="form-control" readonly />
            </div>
            <div class="mb-3">
              <label class="form-label">Latitude:</label>
              <input v-model="form.latitude" type="text" class="form-control" readonly />
            </div>
            <div class="mb-3">
              <label class="form-label">Apakah Catin Wanita Mendapatkan Tablet Tambah Darah?</label>
              <select v-model="form.mendapatkan_tablet_tambah_darah" class="form-control">
                <option value="Ya">Ya</option>
                <option value="Tidak">Tidak</option>
              </select>
            </div>
            <div class="mb-3">
              <label class="form-label">Apakah Catin Wanita Meminum Tablet Tambah Darah?</label>
              <select v-model="form.meminum_tablet_tambah_darah" class="form-control">
                <option value="Ya">Ya</option>
                <option value="Tidak">Tidak</option>
              </select>
            </div>
            <div class="mb-3">
              <label class="form-label">Pemberian Penyuluhan/KIE oleh Pendamping Keluarga?</label>
              <select v-model="form.penyuluhan_KIE" class="form-control">
                <option value="Ya">Ya, Perorangan</option>
                <option value="Ya">Ya, Kelompok</option>
                <option value="Tidak">Tidak</option>
              </select>
            </div>
            <div class="mb-3">
              <label class="form-label">Pemberian Fasilitas Pelayanan Rujukan?</label>
              <select v-model="form.fasilitas_layanan_rujukan" class="form-control">
                <option value="Ya">Ya, Sedang di Proses</option>
                <option value="Ya">Ya, Sudah Mendapat Bantuan Sosial</option>
                <option value="Tidak">Tidak</option>
              </select>
            </div>
            <div class="mb-3">
              <label class="form-label">Pemberian Fasilitas Bantuan Sosial oleh Tim Pendamping Keluarga (jika memenuhi syarat)?</label>
              <select v-model="form.fasilitas_bantuan_sosial" class="form-control">
                <option value="Ya">Ya, Sedang di Proses</option>
                <option value="Ya">Ya, Sudah Mendapat Bantuan Sosial</option>
                <option value="Tidak">Tidak, Karena Tidak Memenuhi Syarat</option>
                <option value="Tidak">Tidak, Karena Sudah Menerima Bantuan</option>
              </select>
            </div>
            <div class="flex justify-between mt-4">
              <button type="button" @click="prevStep" class="btn btn-secondary">Kembali</button>
              <button type="submit" class="btn btn-success" :disabled="isSubmitting">Simpan Data</button>
            </div>
          </div>

          <!-- Modal Untuk Input Data Pasangan -->
          <Modal v-model:show="showModal">
            <div class="mt-4 mb-4">
              <form @submit.prevent="submitPasangan">
                <div class="mb-3">
                  <label class="form-label text-sm font-normal">NIK Pasangan:</label>
                  <input
                    v-model="formPasangan.nik"
                    type="text"
                    class="form-control py-1 px-2 border border-orange-500 rounded-sm text-sm font-normal mb-1"
                    maxlength="16"
                    required
                  />
                </div>
                <div class="mb-3">
                  <label class="form-label text-sm font-normal">Nama Pasangan:</label>
                  <input
                    v-model="formPasangan.nama"
                    type="text"
                    class="form-control py-1 px-2 border border-orange-500 rounded-sm text-sm font-normal mb-1"
                    required
                  />
                </div>
                <div class="mb-3">
                  <label class="form-label text-sm font-normal">Tanggal Lahir:</label>
                  <input
                    v-model="formPasangan.tanggal_lahir"
                    type="date"
                    class="form-control py-1 px-2 border border-orange-500 rounded-sm text-sm font-normal mb-1"
                    required
                  />
                </div>
                <div class="mb-3">
                  <label class="form-label text-sm font-normal">Jenis Kelamin:</label>
                  <select
                    v-model="formPasangan.jenis_kelamin"
                    class="form-control py-1 px-2 border border-orange-500 rounded-sm text-sm font-normal mb-1"
                    required
                  >
                    <option value="">-- Pilih --</option>
                    <option value="Laki-laki">Laki-laki</option>
                    <option value="Perempuan">Perempuan</option>
                  </select>
                </div>
                <div class="mb-3">
                  <label class="form-label text-sm font-normal">Kecamatan:</label>
                  <select
                    v-model="formPasangan.kecamatan"
                    @change="onKecamatanChange"
                    class="form-control py-1 px-2 border border-orange-500 rounded-sm text-sm font-normal mb-1"
                    required
                  >
                    <option value="">-- Pilih --</option>
                    <option value="Ujung">Ujung</option>
                    <option value="Bacukiki">Bacukiki</option>
                    <option value="Bacukiki Barat">Bacukiki Barat</option>
                    <option value="Soreang">Soreang</option>
                  </select>
                </div>
                <div class="mb-3">
                  <label class="form-label text-sm font-normal">Kelurahan:</label>
                  <select
                    v-model="formPasangan.kelurahan"
                    class="form-control py-1 px-2 border border-orange-500 rounded-sm text-sm font-normal mb-1"
                    required
                  >
                    <option value="">-- Pilih Kelurahan --</option>
                    <option v-for="kelurahan in kelurahanOptions" :key="kelurahan" :value="kelurahan">
                      {{ kelurahan }}
                    </option>
                  </select>
                </div>
                <div class="mb-3">
                  <label class="form-label text-sm font-normal">RT:</label>
                  <input
                    v-model="formPasangan.RT"
                    type="text"
                    class="form-control py-1 px-2 border border-orange-500 rounded-sm text-sm font-normal mb-1"
                    required
                  />
                </div>
                <div class="mb-3">
                  <label class="form-label text-sm font-normal">RW:</label>
                  <input
                    v-model="formPasangan.RW"
                    type="text"
                    class="form-control py-1 px-2 border border-orange-500 rounded-sm text-sm font-normal mb-1"
                    required
                  />
                </div>
                <div class="mb-3">
                  <label class="form-label text-sm font-normal">Alamat:</label>
                  <textarea
                    v-model="formPasangan.alamat"
                    class="form-control py-1 px-2 border border-orange-500 rounded-sm text-sm font-normal mb-1"
                    rows="3"
                    required
                  ></textarea>
                </div>
                <div>
                  <label class="block font-normal text-sm">No Telepon:</label>
                  <div class="flex items-center border border-orange-500 rounded">
                    <span class="px-2 text-sm text-gray-700 bg-gray-100 border-r border-orange-500">+62</span>
                    <input
                      v-model="noHpWithoutCode"
                      type="text"
                      class="w-full px-3 py-1 text-sm font-normal rounded-r"
                      placeholder="81234567890"
                      required
                    />
                  </div>
                  <p v-if="noHpWithoutCode && !noHpWithoutCode.match(/^\d{9,12}$/)" class="text-red-600 text-xs mt-1">
                    Nomor harus 9–12 digit tanpa kode negara.
                  </p>
                </div>
                <div class="flex justify-end mt-4 gap-3">
                  <button
                    type="button"
                    @click="showModal = false"
                    class="flex items-center justify-center gap-2 w-full bg-red-600 hover:bg-red-700 text-white text-sm font-normal rounded-lg shadow-md h-8"
                  >
                    Batal
                  </button>
                  <button
                    type="submit"
                    class="flex items-center justify-center gap-2 w-full bg-[#2F2E81] text-white text-sm font-normal rounded-lg shadow-md h-8"
                    :disabled="isSubmitting"
                  >
                    Simpan
                  </button>
                </div>
              </form>
            </div>
          </Modal>
        </form>
      </div>
    </div>
  </AppLayout>
</template>

<style scoped>
input, select, textarea {
  display: block;
  margin-bottom: 10px;
  width: 100%;
}
label {
  font-weight: normal;
}
button {
  margin-top: 15px;
}
.alert {
  color: #d9534f;
}
</style>