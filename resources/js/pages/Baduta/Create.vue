<script lang="ts" setup>
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import { BreadcrumbItem } from '@/types';
import axios from 'axios'; // pastikan ini diimport
import Modal from '@/components/Modal.vue';
import { onMounted } from 'vue'

type Kecamatan = 'Ujung' | 'Bacukiki' | 'Bacukiki Barat' | 'Soreang';

// Ambil 'nik' dari URL (query param)
const penduduk_nik = ref<string>(new URLSearchParams(window.location.search).get('nik') || '');

// Breadcrumbs
const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Baduta TPK',
    href: '/baduta/create',
  },
];





const goToFormPendudukBaru = () => {
  showModal.value = true; // Menampilkan modal untuk input data ibu
};

const kelurahanMap: Record<Kecamatan, string[]> = {
  Ujung: ['Kelurahan Ujung A', 'Kelurahan Ujung B', 'Kelurahan Ujung C'],
  Bacukiki: ['Kelurahan Bacukiki A', 'Kelurahan Bacukiki B'],
  'Bacukiki Barat': ['Kelurahan Bacukiki Barat A', 'Kelurahan Bacukiki Barat B'],
  Soreang: ['Kelurahan Soreang A', 'Kelurahan Soreang B', 'Kelurahan Soreang C']
};

const onKecamatanChange = () => {
  const selected = formIbu.kecamatan;
  kelurahanOptions.value = selected && kelurahanMap[selected as Kecamatan]
    ? kelurahanMap[selected as Kecamatan]
    : [];
};

const kelurahanOptions = ref<string[]>([]);
const step = ref(1);
const errors = ref<string[]>([]);



// Opsi dropdown
const sumberAirOptions = [
  "Air kemasan", "Ledeng", "Sumur bor", "Sumur terlindungi", "Sumur tak terlindungi",
  "Mata air terlindungi", "Mata air tak terlindungi", "Air permukaan", "Air hujan", "Lainnya"
];
const fasilitasBABOptions = [
  "Jamban milik sendiri", "Jamban pada MCK", "Lainnya", "Tidak Ada"
];

// Form state
const form = useForm({
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
  penduduk_nik: penduduk_nik.value,
});


//longtitude
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


const namaIbu = ref<string>('');

// Modal
const showModal = ref(false);
// function handleNext() {
//   // Pastikan data ibu telah disimpan dan modal tertutup
//   form.penduduk_ibu_nik = formIbu.nik; // Menyimpan NIK ibu dari form Ibu
//   namaIbu.value = formIbu.nama; // Menyimpan nama ibu
//   showModal.value = false; // Menutup modal setelah data disimpan
//   step.value = 2; // Melanjutkan ke langkah berikutnya
// }
const formIbu = useForm({
    nik: '',
  nama: '',
  tanggal_lahir: '',
  jenis_kelamin: '',
  kecamatan: '' ,
  kelurahan: '',
  RT: '',
  RW: '',
  alamat: '',
  no_hp: '',
  kategori: 'penduduk'
});


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

const goToNextStep = () => {
  if (step.value === 1 && (!form.penduduk_ibu_nik || !namaIbu.value)) {
    alert('Silakan isi dan cek NIK Ibu terlebih dahulu.');
    return;
  }
  step.value++;
};


</script>

<template>
  <Head title="Penduduk TPK" />
  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="container mt-5">
      <h2 class="mb-4">Tambah Data Penduduk Baduta</h2>


      <form @submit.prevent="submitForm">
          <!-- Step 1 -->
          <div v-if="step === 1">
            <div v-if="errors.length" class="alert alert-danger">
              <ul>
                <li v-for="(error, index) in errors" :key="index">{{ error }}</li>
              </ul>
            </div>
          <div>
            <label>NIK Ibu:</label>
            <input v-model="form.penduduk_ibu_nik" type="text" />
            <div style="display: flex; gap: 10px; margin-top: 5px;">
              <button type="button" @click="checkNIK">Cek</button>
              <button type="button" @click="goToFormPendudukBaru">Data Baru</button>
            </div>
            <p v-if="namaIbu"><strong>Nama Ibu:</strong> {{ namaIbu }}</p>
          </div>
          <button type="button" @click="goToNextStep">Next</button>
        </div>

        <div v-if="step === 2">
            <h2>Data Ibu</h2>
            <div>
                <label>Tanggal Lahir Anak Terakhir:</label>
                <input v-model="form.tanggal_lahir_anak_terakhir" type="date" required />
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

            <button type="button" @click="step--">Back</button>
            <button type="button" @click="step++">Next</button>
        </div>


        <!-- Step 2 -->
        <div v-if="step === 3">
            <h2>Data Baduta</h2>

            <div>
                <label>Jumlah Anak Kandung:</label>
                <input v-model.number="form.jumlah_anak_kandung" type="number" required />
            </div>
            <div>
                <label>Fasilitas Buang Air Besar:</label>
                <select v-model="form.fasilitas_BAB">
                <option value="" disabled>Pilih</option>
                <option v-for="option in fasilitasBABOptions" :key="option" :value="option">{{ option }}</option>
                </select>
            </div>

            <div><label>NIK Anak (dari URL):</label><input v-model="form.penduduk_nik" type="text" disabled /></div>
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
                <label>Terpapar Rokok?</label><br>
                <label><input type="radio" value="Ya" v-model="form.merokok_terpapar" /> Ya</label>
                <label><input type="radio" value="Tidak" v-model="form.merokok_terpapar" /> Tidak</label>
            </div>
            <div>
                <label>Mengisi KKA?</label><br>
                <label><input type="radio" value="Ya" v-model="form.mengisi_KKA" /> Ya</label>
                <label><input type="radio" value="Tidak" v-model="form.mengisi_KKA" /> Tidak</label>
            </div>

            <button type="button" @click="step--">Back</button>
            <button type="button" @click="step++">Next</button>
            <div><label>NIK Anak (dari URL):</label><input v-model="form.penduduk_nik" type="text" disabled /></div>
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
                <label>Terpapar Rokok?</label><br>
                <label><input type="radio" value="Ya" v-model="form.merokok_terpapar" /> Ya</label>
                <label><input type="radio" value="Tidak" v-model="form.merokok_terpapar" /> Tidak</label>
            </div>
            <div>
                <label>Mengisi KKA?</label><br>
                <label><input type="radio" value="Ya" v-model="form.mengisi_KKA" /> Ya</label>
                <label><input type="radio" value="Tidak" v-model="form.mengisi_KKA" /> Tidak</label>
            </div>

            <button type="button" @click="step--">Back</button>
            <button type="button" @click="step++">Next</button>
        </div>



        <!-- Step 3 -->
        <div v-if="step === 4">
        <div v-if="step === 4">
          <h2>Data Pendampingan Bulanan</h2>
          <!-- <div><label>Longitude:</label><input v-model.number="form.longitude" type="number" step="0.000001" required /></div>
<div><label>Latitude:</label><input v-model.number="form.latitude" type="number" step="0.000001" required /></div> -->
          <div>
            <label>Kehadiran Posyandu?</label><br>
            <label><input type="radio" value="Ya" v-model="form.kehadiran_posyandu" /> Ya</label>
            <label><input type="radio" value="Tidak" v-model="form.kehadiran_posyandu" /> Tidak</label>
          </div>
          <div>
            <label>Penyuluhan/KIE:</label><br>
            <label><input type="radio" value="Ya, perorang" v-model="form.penyuluhan_KIE" /> Ya, perorang</label>
            <label><input type="radio" value="Ya, kelompok" v-model="form.penyuluhan_KIE" /> Ya, kelompok</label>
            <label><input type="radio" value="Tidak" v-model="form.penyuluhan_KIE" /> Tidak</label>
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
          <button type="button" @click="step--">Back</button>
          <button type="submit">Simpan Data</button>
        </div>
      </form>

      <!-- Modal Input Penduduk Baru -->
     <Modal v-model:show="showModal">
        <h3>Tambah Data Ibu</h3>
        <form @submit.prevent="submitPendudukBaru">

        <div class="mb-3">
          <label for="nik" class="form-label">nik</label>
          <input v-model="formIbu.nik" type="text" class="form-control" id="nik" required />
        </div>

        <div class="mb-3">
          <label for="nama" class="form-label">Nama</label>
          <input v-model="formIbu.nama" type="text" class="form-control" id="nama" required />
        </div>

        <div class="mb-3">
          <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
          <input v-model="formIbu.tanggal_lahir" type="date" class="form-control" id="tanggal_lahir" required />
        </div>

        <div class="mb-3">
          <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
          <select v-model="formIbu.jenis_kelamin" class="form-select" id="jenis_kelamin" required>
            <option value="">-- Pilih --</option>
            <option value="Laki-laki">Laki-laki</option>
            <option value="Perempuan">Perempuan</option>
          </select>
        </div>

        <div class="mb-3">
          <label for="kecamatan" class="form-label">Kecamatan</label>
          <select v-model="formIbu.kecamatan" @change="onKecamatanChange" class="form-select" id="kecamatan" required>
            <option value="">-- Pilih --</option>
            <option value="Ujung">Ujung</option>
            <option value="Bacukiki">Bacukiki</option>
            <option value="Bacukiki Barat">Bacukiki Barat</option>
            <option value="Soreang">Soreang</option>
          </select>
        </div>

        <div class="mb-3">
          <label for="kelurahan" class="form-label">Kelurahan</label>
          <select v-model="formIbu.kelurahan" class="form-select" id="kelurahan" required>
            <option value="">-- Pilih Kelurahan --</option>
            <option v-for="kelurahan in kelurahanOptions" :key="kelurahan" :value="kelurahan">
              {{ kelurahan }}
            </option>
          </select>
        </div>

        <div class="mb-3">
          <label for="rt" class="form-label">RT</label>
          <input v-model="formIbu.RT" type="text" class="form-control" id="rt" required />
        </div>

        <div class="mb-3">
          <label for="rw" class="form-label">RW</label>
          <input v-model="formIbu.RW" type="text" class="form-control" id="rw" required />
        </div>

        <div class="mb-3">
          <label for="alamat" class="form-label">Alamat</label>
          <input v-model="formIbu.alamat" type="text" class="form-control" id="alamat" required />
        </div>

        <div class="mb-3">
          <label for="no_hp" class="form-label">No. HP</label>
          <input v-model="formIbu.no_hp" type="text" class="form-control" id="no_hp" required />
        </div>

        <!-- <button type="button" @click="handleNext">Next</button> -->
        <div class="d-flex justify-content-end">
        <button @click="$emit('update:show', false)">Simpan</button>
        <button type="button" class="btn btn-secondary me-2" @click="showModal = false">Batal</button>
        </div>
        </form>
      </Modal>
    </div>
  </AppLayout>
</template>

<style scoped>
input, select {
  display: block;
  margin-bottom: 10px;
  width: 100%;
}
label {
  font-weight: 500;
}
button {
  margin-right: 10px;
  margin-top: 15px;
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
</style>