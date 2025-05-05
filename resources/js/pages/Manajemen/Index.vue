<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { type BreadcrumbItem } from '@/types';

defineProps<{
    manajemens: Array<{
        NIK: string;
        nama: string;
        kecamatan: string;
        kelurahan: string;
    }> ;
}>();

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Manajemen User', href: '/manajemen' },
];

const form = useForm({});

function confirmDelete(NIK: string) {
    if (confirm('Apakah kamu yakin ingin menghapus data ini?')) {
        form.delete(route('manajemen.destroy', NIK), {
            preserveScroll: true
        })
    }
}
</script>

<template>
    <Head title="Manajemen" />
    
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex flex-col gap-4 p-4">
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-bold">Manajemen</h1>
                <Link 
                    :href="route('manajemen.create')"
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
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kecamatan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kelurahan</th>                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr v-for="(item, index) in manajemens" :key="item.NIK">
                            <td class="px-6 py-4 whitespace-nowrap">{{ index + 1 }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ item.NIK }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ item.nama }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ item.kecamatan }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ item.kelurahan }}</td>
                            <td class="px-6 py-4 whitespace-nowrap flex gap-2">
                                <Link
                                    :href="route('manajemen.edit', { NIK: item.NIK })"
                                    class="px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600"
                                >
                                    Edit
                                </Link>

                                <button
                                    @click="confirmDelete(item.NIK)"
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