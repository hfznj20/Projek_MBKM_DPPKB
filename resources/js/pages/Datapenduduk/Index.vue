<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, Link,  useForm } from '@inertiajs/vue3';
import { type BreadcrumbItem } from '@/types';



// Definisikan tipe data untuk 1 item Bdtpk
interface Datapenduduk {
  id: number;
  nik: string;
  nama_lengkap: string;
  kecamatan: string;
  kelurahan: string;
  RT: string;
  RW: string;
  TTL: string;  // Tanggal Lahir
  jenis_kelamin: string;
  no_telepon: string;
  jalan: string;
  nik_tpk: string;
}

defineProps<{
  datapenduduks: Datapenduduk[];
}>();

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Data Penduduk', href: route('datapenduduk.index') },
    { title: 'Tambah Data', href: route('datapenduduk.create') },

];

const form = useForm({});

function confirmDelete(nik: string) {
    if (confirm('Apakah kamu yakin ingin menghapus data ini?')) {
        form.delete(route('datapenduduk.destroy', nik), {
            preserveScroll: true
        })
    }
}
</script>

<template>
    <Head title="Data Penduduk" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex flex-col gap-4 p-4">
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-bold">Data Penduduk</h1>
                <Link
                    href="/datapenduduk/create"
                    class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700"
                >
                    + Tambah Data
                </Link>
            </div>

            <div class="overflow-x-auto bg-white rounded-lg shadow">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NIK</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Lengkap</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kecamatan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kelurahan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">RT</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">RW</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Lahir</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis Kelamin</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No Telepon</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jalan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nik TPK</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr v-for="(datapenduduk, index) in datapenduduks" :key="datapenduduk.nik" class="border-t border-gray-200">
                            <td class="px-6 py-4 whitespace-nowrap">{{ index + 1 }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ datapenduduk.nik }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ datapenduduk.nama_lengkap }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ datapenduduk.kecamatan }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ datapenduduk.kelurahan }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ datapenduduk.RT }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ datapenduduk.RW }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ datapenduduk.TTL }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ datapenduduk.jenis_kelamin }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ datapenduduk.no_telepon }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ datapenduduk.jalan }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ datapenduduk.nik_tpk }}</td>
                            <td class="px-6 py-4 whitespace-nowrap flex gap-2">
                                <Link
                                    :href="`datapenduduk/${datapenduduk.id}/edit`"
                                    class="px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600"
                                >
                                    Edit
                                </Link>

                                <button
                                    @click="confirmDelete(datapenduduk.nik)"
                                    class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600"
                                >
                                    Hapus
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AppLayout>
</template>
