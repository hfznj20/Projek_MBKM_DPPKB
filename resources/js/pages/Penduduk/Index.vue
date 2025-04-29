<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { BreadcrumbItem } from '@/types';
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import { Head, Link, usePage} from '@inertiajs/vue3';

// Interface untuk tipe data penduduk
interface Penduduk {
  id: number
  nik: string
  nama: string
  tanggal_lahir: string
  jenis_kelamin: string
  kecamatan: string
  kelurahan: string
  RT: string
  RW: string
  alamat: string
  no_hp: string
  kategori: string
}
// Breadcrumbs
const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Baduta TPK',
    href: '/datapenduduk',
  },
];
const { props } = usePage();
const penduduks = ref<Penduduk[]>(props.penduduks as Penduduk[]);

// Router instance
const router = useRouter()

// Pesan sukses setelah aksi berhasil
const successMessage = ref('')

// Hapus data penduduk
const deletePenduduk = async (id: number) => {
  if (!confirm('Yakin mau hapus?')) return
  try {
    successMessage.value = 'Data berhasil dihapus'
    // fetchPenduduks()
  } catch (error) {
    console.error('Gagal menghapus data:', error)
  }
}

// Edit data penduduk
const editPenduduk = (id: number) => {
  router.push({ name: 'penduduk-edit', params: { id } })
}

// Navigasi ke halaman tambah penduduk
const goToCreatePage = () => {
  router.push({ name: 'penduduk-create' })
}

</script>

<template>
    <Head title="Baduta TPK" />

<AppLayout :breadcrumbs="breadcrumbs">
  <div class="container mt-5">
    <h2 class="mb-4">Data Penduduk</h2>

    <div v-if="successMessage" class="alert alert-success">{{ successMessage }}</div>

    <Link
          href="/datapenduduk/create"
          class="px-4 py-2 text-sm font-medium text-white bg-green-500 rounded hover:bg-green-600"
        >
          Tambah Data
        </Link>

    <table class="table table-bordered table-striped">
      <thead class="table-dark">
        <tr>
          <th>No</th>
          <th>NIK</th>
          <th>Nama</th>
          <th>Tanggal Lahir</th>
          <th>Jenis Kelamin</th>
          <th>Kecamatan</th>
          <th>Kelurahan</th>
          <th>RT</th>
          <th>RW</th>
          <th>Alamat</th>
          <th>No HP</th>
          <th>Status</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(penduduk, index) in penduduks" :key="penduduk.id">
          <td>{{ index + 1 }}</td>
          <td>{{ penduduk.nik }}</td>
          <td>{{ penduduk.nama }}</td>
          <td>{{ penduduk.tanggal_lahir }}</td>
          <td>{{ penduduk.jenis_kelamin }}</td>
          <td>{{ penduduk.kecamatan }}</td>
          <td>{{ penduduk.kelurahan }}</td>
          <td>{{ penduduk.RT }}</td>
          <td>{{ penduduk.RW }}</td>
          <td>{{ penduduk.alamat }}</td>
          <td>{{ penduduk.no_hp }}</td>
          <td>{{ penduduk.kategori }}</td>
          <td>
            <button class="btn btn-primary btn-sm" @click="editPenduduk(penduduk.id)">Edit</button>
            <button class="btn btn-danger btn-sm" @click="deletePenduduk(penduduk.id)">Hapus</button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</AppLayout>
</template>
