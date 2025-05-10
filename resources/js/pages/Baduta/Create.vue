<script lang="ts" setup>
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';
import { BreadcrumbItem } from '@/types';
import axios from 'axios';
import Modal from '@/components/Modal.vue';
import { MagnifyingGlassIcon, PlusIcon } from '@heroicons/vue/24/solid';

// Ambil 'nik' dari URL (query param)
const penduduk_nik = ref<string>(new URLSearchParams(window.location.search).get('nik') || '');
const namaIbu = ref<string>('');

// Breadcrumbs
const breadcrumbs: BreadcrumbItem[] = [
  { title: 'Tambah Data Baduta', href: '/baduta/create' },
];

type Kecamatan = 'Ujung' | 'Bacukiki' | 'Bacukiki Barat' | 'Soreang';

const sumberAirOptions = [
  "Air kemasan", "Ledeng", "Sumur bor", "Sumur terlindungi", "Sumur tak terlindungi",
  "Mata air terlindungi", "Mata air tak terlindungi", "Air permukaan", "Air hujan", "Lainnya"
];

const fasilitasBABOptions = [
  "Jamban milik sendiri", "Jamban pada MCK", "Lainnya", "Tidak Ada"
];

const kelurahanMap: Record<Kecamatan, string[]> = {
  Ujung: ['Kelurahan Ujung A', 'Kelurahan Ujung B', 'Kelurahan Ujung C'],
  Bacukiki: ['Kelurahan Bacukiki A', 'Kelurahan Bacukiki B'],
  'Bacukiki Barat': ['Kelurahan Bacukiki Barat A', 'Kelurahan Bacukiki Barat B'],
  Soreang: ['Kelurahan Soreang A', 'Kelurahan Soreang B', 'Kelurahan Soreang C']
};

const kelurahanOptions = ref<string[]>([]);

const onKecamatanChange = () => {
  const selected = formIbu.kecamatan;
  kelurahanOptions.value = selected && kelurahanMap[selected as Kecamatan]
    ? kelurahanMap[selected as Kecamatan]
    : [];
};

// Form state
const form = useForm({
  penduduk_nik: penduduk_nik.value,
  penduduk_ibu_nik: '',
  jumlah_anak_kandung: 0,
  tanggal_lahir_anak_terakhir: '',
  menggunakan_alat_kontrasepsi: '',
  sumber_air_minum: '',
  fasilitas_BAB: '',
  berat_badan: null,
  tinggi_badan: null,
  urutan_anak: null,
  umur_kehamilan_saat_lahir: null,
  asi_eksklusif: '',
  imunisasi_hepatitis_B: '',
  merokok_terpapar: '',
  mengisi_KKA: '',
  longitude: '',
  latitude: '',
  kehadiran_posyandu: '',
  penyuluhan_KIE: '',
  fasilitas_bantuan_sosial: '',
  stunting: '',
});

const goToFormPendudukBaru = () => {
  showModal.value = true; // Menampilkan modal untuk input data ibu
};

const step = ref(1);
const errors = ref<string[]>([]);

// Longitude
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

// Modal
const showModal = ref(false);

const formIbu = useForm({
    nik: '',
    nama: '',
    tanggal_lahir: '',
    jenis_kelamin: '',
    kecamatan: '',
    kelurahan: '',
    RT: '',
    RW: '',
    alamat: '',
    no_hp: '',
    kategori: 'penduduk'
});

// Cek NIK ibu
const checkNIK = async () => {
  try {
    const response = await axios.post('/cek-nik', {
      nik: form.penduduk_ibu_nik
    });
    
    if (response.data.status === 'data ada') {
      namaIbu.value = response.data.nama;
    } else {
      namaIbu.value = '';
      alert("Data tidak ada");
    }
  } catch (error: unknown) {
    namaIbu.value = '';
    if (axios.isAxiosError(error)) {
      alert("Terjadi kesalahan: " + error.message);
    } else {
      alert("Terjadi kesalahan tidak diketahui");
    }
  }
};

const submitPendudukBaru = () => {
  formIbu.post('/penduduk', {
    preserveScroll: true,
    preserveState: true,
    onSuccess: () => {
      form.penduduk_ibu_nik = formIbu.nik;
      namaIbu.value = formIbu.nama;
      showModal.value = false;
      step.value = 1;
    },
    onError: () => {
      console.log(formIbu.errors); // tampilkan error validasi di console
    }
  });
};

const goToNextStep = () => {
  if (step.value === 1 && (!form.penduduk_ibu_nik || !namaIbu.value)) {
    alert('Silakan isi dan cek NIK Ibu terlebih dahulu.');
    return;
  }
  step.value++;
};

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

  // Jika lokasi sudah tersedia, langsung kirim form
  form.post('/baduta', {
    onSuccess: () => {
      window.location.href = '/penduduk';
    },
    onError: () => {
      errors.value = Object.values(form.errors).flat();
    },
  });
};

</script>

<template>
  <Head title="Penduduk TPK" />
  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="p-6">
      <div class="bg-white shadow rounded p-4 relative">
        <div v-if="errors.length" class="alert alert-danger">
          <ul>
            <li v-for="(error, index) in errors" :key="index">{{ error }}</li>
          </ul>
        </div>

        <form @submit.prevent="submitForm">
          <div class="mb-6 max-w-md">
            <label for="nikIbu" class="block text-sm">NIK Ibu :</label>
            <input
              id="nikIbu"
              v-model="form.penduduk_ibu_nik"
              type="text"
              maxlength="16"
              placeholder="Masukkan NIK Ibu"
              class="w-full border border-orange-500 rounded px-3 py-1 outline-none focus:ring-2 focus:ring-orange-400"
            />
            <div class="flex gap-3 mt-4">
              <button
                type="button"
                @click="checkNIK"
                class="flex items-center gap-2 px-4 py-1 bg-orange-500 text-white text-sm font-normal rounded-lg shadow-md"
              >
                <MagnifyingGlassIcon class="w-5 h-5" />
                Cek Data Ibu
              </button>

              <button
                type="button"
                @click="goToFormPendudukBaru"
                class="flex items-center gap-2 px-4 py-1 bg-green-600 text-white text-sm font-normal rounded-lg shadow-md"
              >
                <PlusIcon class="w-5 h-5" />
                Tambah Data Baru
              </button>
            </div>

            <div class="flex justify-between mt-4">
              <p v-if="namaIbu" class="mt-4 text-gray-700">
                <strong>Nama Ibu:</strong> {{ namaIbu }}
              </p>
            </div>
          </div>

          <!-- Step 1 -->
          <div v-if="step === 1">
            <button type="button" @click="goToNextStep" class="flex items-center gap-2 px-4 py-1 bg-[#2F2E81] text-white text-sm font-normal rounded-lg shadow-md">
              Berikutnya
            </button>
          </div>

            <!-- Step 2 -->
         <div v-if="step === 2">
  <!-- Tanggal Lahir Anak Terakhir -->
  <div class="mb-4">
    <label for="tanggal_lahir_anak_terakhir" class="block text-sm font-medium text-black">Tanggal Lahir Anak Terakhir:</label>
    <input
      v-model="form.tanggal_lahir_anak_terakhir"
      id="tanggal_lahir_anak_terakhir"
      type="date"
      class="mt-1 block w-full px-4 py-1 border border-orange-500 rounded-lg focus:ring-orange-500 focus:border-orange-500"
      required
    />
  </div>

  <!-- Menggunakan Kontrasepsi Saat Ini (Dropdown) -->
  <div class="mb-4">
    <label for="menggunakan_alat_kontrasepsi" class="block text-sm font-medium text-black">Menggunakan Kontrasepsi Saat Ini?</label>
    <select
      v-model="form.menggunakan_alat_kontrasepsi"
      id="menggunakan_alat_kontrasepsi"
      class="mt-1 block w-full px-4 py-1 border border-orange-500 rounded-lg focus:ring-orange-500 focus:border-orange-500"
    >
      <option value="" disabled>Pilih</option>
      <option value="Ya">Ya</option>
      <option value="Tidak">Tidak</option>
    </select>
  </div>

  <!-- Sumber Air Minum Utama -->
  <div class="mb-4">
    <label for="sumber_air_minum" class="block text-sm font-medium text-black">Sumber Air Minum Utama:</label>
    <select
      v-model="form.sumber_air_minum"
      id="sumber_air_minum"
      class="mt-1 block w-full px-4 py-1 border border-orange-500 rounded-lg focus:ring-orange-500 focus:border-orange-500"
    >
      <option value="" disabled>Pilih</option>
      <option v-for="option in sumberAirOptions" :key="option" :value="option">{{ option }}</option>
    </select>
  </div>

  <!-- Navigasi -->
  <div class="flex justify-between mt-6">
  <button
    type="button"
    @click="step--"
    class="px-6 py-1 text-sm font-medium text-white bg-gray-700 rounded-lg hover:bg-gray-800 w-32"
  >Kembali</button>
  
  <button
    type="button"
    @click="step++"
    class="px-6 py-1 text-sm font-medium text-white bg-[#37347E] rounded-lg w-32"
  >Berikutnya</button>
</div>
</div>

<!-- Step 3 -->
<div v-if="step === 3" class="">
  <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
    <!-- Form Jumlah Anak Kandung & Fasilitas Buang Air Besar -->
    <div class="mb-1">
      <label for="jumlah_anak_kandung" class="block text-sm font-medium text-gray-700">Jumlah Anak Kandung:</label>
      <input v-model.number="form.jumlah_anak_kandung" id="jumlah_anak_kandung" type="number" class="mt-0 block w-full px-4 py-1 border border-orange-500 rounded-lg focus:ring-orange-500 focus:border-orange-500" required />
    </div>

    <div class="mb-1">
      <label for="fasilitas_BAB" class="block text-sm font-medium text-gray-700">Fasilitas Buang Air Besar:</label>
      <select v-model="form.fasilitas_BAB" id="fasilitas_BAB" class="mt-0 block w-full px-4 py-1 border border-orange-500 rounded-lg focus:ring-orange-500 focus:border-orange-500">
        <option value="" disabled>Pilih</option>
        <option v-for="option in fasilitasBABOptions" :key="option" :value="option">{{ option }}</option>
      </select>
    </div>

    <!-- Form lainnya -->
    <div class="mb-1">
      <label for="berat_badan" class="block text-sm font-medium text-gray-700">Berat Badan (kg):</label>
      <input v-model.number="form.berat_badan" id="berat_badan" type="number" step="0.01" class="mt-0 block w-full px-4 py-1 border border-orange-500 rounded-lg focus:ring-orange-500 focus:border-orange-500" required />
    </div>

    <div class="mb-1">
      <label for="tinggi_badan" class="block text-sm font-medium text-gray-700">Tinggi Badan (cm):</label>
      <input v-model.number="form.tinggi_badan" id="tinggi_badan" type="number" step="0.1" class="mt-0 block w-full px-4 py-1 border border-orange-500 rounded-lg focus:ring-orange-500 focus:border-orange-500" required />
    </div>

    <div class="mb-1">
      <label for="urutan_anak" class="block text-sm font-medium text-gray-700">Urutan Anak:</label>
      <input v-model.number="form.urutan_anak" id="urutan_anak" type="number" class="mt-0 block w-full px-4 py-1 border border-orange-500 rounded-lg focus:ring-orange-500 focus:border-orange-500" required />
    </div>

    <div class="mb-1">
      <label for="umur_kehamilan_saat_lahir" class="block text-sm font-medium text-gray-700">Umur Kehamilan Saat Lahir (minggu):</label>
      <input v-model.number="form.umur_kehamilan_saat_lahir" id="umur_kehamilan_saat_lahir" type="number" class="mt-0 block w-full px-4 py-1 border border-orange-500 rounded-lg focus:ring-orange-500 focus:border-orange-500" required />
    </div>
  </div>

  <!-- Pertanyaan Dropdown -->
  <div class="grid grid-cols-1 md:grid-cols-2 gap-2 mt-6">
    <div class="mb-1">
      <label class="block text-sm font-medium text-gray-700">ASI Eksklusif?</label>
      <select v-model="form.asi_eksklusif" class="mt-0 block w-full px-4 py-1 border border-orange-500 rounded-lg focus:ring-orange-500 focus:border-orange-500">
        <option value="" disabled>Pilih</option>
        <option value="Ya">Ya</option>
        <option value="Tidak">Tidak</option>
      </select>
    </div>

    <div class="mb-1">
      <label class="block text-sm font-medium text-gray-700">Imunisasi Hepatitis B?</label>
      <select v-model="form.imunisasi_hepatitis_B" class="mt-0 block w-full px-4 py-1 border border-orange-500 rounded-lg focus:ring-orange-500 focus:border-orange-500">
        <option value="" disabled>Pilih</option>
        <option value="Ya">Ya</option>
        <option value="Tidak">Tidak</option>
      </select>
    </div>

    <div class="mb-1">
      <label class="block text-sm font-medium text-gray-700">Terpapar Rokok?</label>
      <select v-model="form.merokok_terpapar" class="mt-0 block w-full px-4 py-1 border border-orange-500 rounded-lg focus:ring-orange-500 focus:border-orange-500">
        <option value="" disabled>Pilih</option>
        <option value="Ya">Ya</option>
        <option value="Tidak">Tidak</option>
      </select>
    </div>

    <div class="mb-1">
      <label class="block text-sm font-medium text-gray-700">Mengisi KKA?</label>
      <select v-model="form.mengisi_KKA" class="mt-0 block w-full px-4 py-1 border border-orange-500 rounded-lg focus:ring-orange-500 focus:border-orange-500">
        <option value="" disabled>Pilih</option>
        <option value="Ya">Ya</option>
        <option value="Tidak">Tidak</option>
      </select>
    </div>
  </div>

  <div class="flex justify-between mt-6">
  <button
    type="button"
    @click="step--"
    class="px-6 py-1 text-sm font-medium text-white bg-gray-700 rounded-lg hover:bg-gray-800 w-32"
  >Kembali</button>
  
  <button
    type="button"
    @click="step++"
    class="px-6 py-1 text-sm font-medium text-white bg-[#37347E] rounded-lg w-32"
  >Berikutnya</button>
</div>
</div>


          <!-- Step 4 -->
         <div v-if="step === 4">
  <!-- Judul -->
  <div class="bg-[#37347E] py-1.5 px-2 rounded mb-4">
    <h2 class="text-center text-lg font-semibold text-white">Data Pendampingan Bulanan</h2>
  </div>

  <!-- Form Grid -->
  <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <!-- Kehadiran Posyandu -->
    <div>
      <label for="kehadiran_posyandu" class="block text-sm font-medium text-gray-700 mb-1">Kehadiran Posyandu?</label>
      <select
        v-model="form.kehadiran_posyandu"
        id="kehadiran_posyandu"
        class="w-full border border-orange-500 rounded-md px-3 py-1 text-sm focus:border-orange-500 focus:ring-orange-500"
      >
        <option disabled value="">Pilih</option>
        <option value="Ya">Ya</option>
        <option value="Tidak">Tidak</option>
      </select>
    </div>

    <!-- Penyuluhan/KIE -->
    <div>
      <label for="penyuluhan_KIE" class="block text-sm font-medium text-gray-700 mb-1">Penyuluhan/KIE:</label>
      <select
        v-model="form.penyuluhan_KIE"
        id="penyuluhan_KIE"
        class="w-full border border-orange-500 rounded-md px-3 py-1 text-sm focus:border-orange-500 focus:ring-orange-500"
      >
        <option disabled value="">Pilih</option>
        <option value="Ya, perorang">Ya, perorang</option>
        <option value="Ya, kelompok">Ya, kelompok</option>
        <option value="Tidak">Tidak</option>
      </select>
    </div>

    <!-- Bantuan Sosial -->
    <div>
      <label for="fasilitas_bantuan_sosial" class="block text-sm font-medium text-gray-700 mb-1">Bantuan Sosial:</label>
      <select
        v-model="form.fasilitas_bantuan_sosial"
        id="fasilitas_bantuan_sosial"
        class="w-full border border-orange-500 rounded-md px-3 py-1 text-sm focus:border-orange-500 focus:ring-orange-500"
      >
        <option disabled value="">Pilih</option>
        <option value="Ya, sedang di proses">Ya, sedang di proses</option>
        <option value="Ya, sudah mendapat bantuan sosial">Ya, sudah mendapat</option>
        <option value="Tidak, karena tidak memenuhi syarat">Tidak, tidak memenuhi syarat</option>
        <option value="Tidak, karena sudah menerima bantuan">Tidak, sudah menerima</option>
      </select>
    </div>

    <!-- Anak Mengalami Stunting -->
    <div>
      <label for="stunting" class="block text-sm font-medium text-gray-700 mb-1">Anak Mengalami Stunting?</label>
      <select
        v-model="form.stunting"
        id="stunting"
        class="w-full border border-orange-500 rounded-md px-3 py-1 text-sm focus:border-orange-500 focus:ring-orange-500"
      >
        <option disabled value="">Pilih</option>
        <option value="Ya">Ya</option>
        <option value="Tidak">Tidak</option>
      </select>
    </div>
  </div>

  <!-- Tombol Navigasi -->
  <div class="flex justify-between mt-6">
    <button
  type="button"
  @click="step--"
  class="px-6 py-1 text-sm font-medium text-white bg-gray-700 rounded-lg hover:bg-gray-800 w-32"
>
  Kembali
</button>

<button
  type="submit"
  class="px-6 py-1 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700 w-32 whitespace-nowrap"
>
  Simpan Data
</button>
  </div>
</div>

        </form>
      </div>

      <!-- Modal Input Penduduk Baru -->
      <Modal v-model:show="showModal">
        <template #header>
          <div class="bg-amber-700 text-white px-4 py-2 rounded-t">
            <strong>Tambah Data Ibu</strong>
          </div>
        </template>
        <form @submit.prevent="submitPendudukBaru" class="p-4">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label for="nik" class="form-label">NIK :</label>
              <input v-model="formIbu.nik" type="text" class="w-full border border-amber-500 rounded px-2 py-1" required />
            </div>
            <div>
              <label for="nama">Nama Ibu :</label>
              <input v-model="formIbu.nama" id="nama" type="text" class="w-full border border-amber-500 rounded px-2 py-1" required />
            </div>
            <div>
              <label for="tanggal_lahir">Tanggal Lahir :</label>
              <input v-model="formIbu.tanggal_lahir" id="tanggal_lahir" type="date" class="w-full border border-amber-500 rounded px-2 py-1" required />
            </div>
            <div>
              <label for="jenis_kelamin">Jenis Kelamin :</label>
              <select v-model="formIbu.jenis_kelamin" id="jenis_kelamin" class="w-full border border-amber-500 rounded px-2 py-1" required>
                <option value="">-- Pilih --</option>
                <option value="Laki-laki">Laki-laki</option>
                <option value="Perempuan">Perempuan</option>
              </select>
            </div>
            <div>
              <label for="kecamatan">Kecamatan :</label>
              <select v-model="formIbu.kecamatan" id="kecamatan" @change="onKecamatanChange" class="w-full border border-amber-500 rounded px-2 py-1" required>
                <option value="">-- Pilih --</option>
                <option value="Ujung">Ujung</option>
                <option value="Bacukiki">Bacukiki</option>
                <option value="Bacukiki Barat">Bacukiki Barat</option>
                <option value="Soreang">Soreang</option>
              </select>
            </div>
            <div>
              <label for="kelurahan">Kelurahan :</label>
              <select v-model="formIbu.kelurahan" id="kelurahan" class="w-full border border-amber-500 rounded px-2 py-1" required>
                <option value="">-- Pilih Kelurahan --</option>
                <option v-for="kelurahan in kelurahanOptions" :key="kelurahan" :value="kelurahan">{{ kelurahan }}</option>
              </select>
            </div>
            <div>
              <label for="rt">RT :</label>
              <input v-model="formIbu.RT" id="rt" type="text" class="w-full border border-amber-500 rounded px-2 py-1" required />
            </div>
            <div>
              <label for="rw">RW :</label>
              <input v-model="formIbu.RW" id="rw" type="text" class="w-full border border-amber-500 rounded px-2 py-1" required />
            </div>
            <div class="col-span-2">
              <label for="alamat">Alamat :</label>
              <textarea v-model="formIbu.alamat" id="alamat" class="w-full border border-amber-500 rounded px-2 py-1" required></textarea>
            </div>
            <div class="col-span-2">
              <label for="no_hp">No HP :</label>
              <input v-model="formIbu.no_hp" id="no_hp" type="text" pattern="^\+62\d{10,12}$" minlength="12"
                class="w-full border border-amber-500 rounded px-2 py-1" placeholder="Contoh: +6281234567890" required />
              <p v-if="formIbu.no_hp && !formIbu.no_hp.match(/^\+62\d{10,12}$/)" class="text-red-500 text-sm mt-1">
                Nomor telepon harus dimulai dengan +62 dan memiliki minimal 12 digit.
              </p>
            </div>
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
            >
              Simpan
            </button>
          </div>
        </form>
      </Modal>
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
  font-weight: normal; /* Non-bold */
  font-size: 0.875rem; /* Small font size */
}

button {
  margin-right: 10px;
  margin-top: 15px;
}

.alert {
  color: #d9534f;
}

.modal-backdrop {
  position: fixed;
  inset: 0;
  background: rgba(0, 0, 0, 0.4);
  display: flex;
  justify-content: center;
  align-items: center;
}

.modal-content {
  background: white;
  padding: 20px;
  border-radius: 8px;
  width: 90%;
  max-width: 500px;
}

/* Additional styles for all text */
* {
  font-weight: normal !important; /* Non-bold for all elements */
  font-size: 0.875rem !important; /* Small font size for all elements */
}
</style>