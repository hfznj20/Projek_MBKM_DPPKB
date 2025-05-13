<!-- INDEX -->
<script setup lang="ts">
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { Pencil, Eye, Trash2, UserPlusIcon} from 'lucide-vue-next';
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { BreadcrumbItem } from '@/types';

defineProps<{
    manajemens: Array<{
        NIK: string;
        nama: string;
        kecamatan: string;
        kelurahan: string;
    }>;
}>();

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Manajemen User', href: '/manajemen' },
];

const form = useForm({});
const showModal = ref(false);
const selectedNIK = ref<string | null>(null);

function confirmDelete(NIK: string) {
    selectedNIK.value = NIK;
    showModal.value = true;
}

function deleteConfirmed() {
    if (selectedNIK.value) {
        form.delete(route('manajemen.destroy', selectedNIK.value), {
            preserveScroll: true,
        });
        showModal.value = false;
    }
}
</script>

<template>
    <Head title="Manajemen" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex flex-col gap-4 p-4">

  <!-- Tombol Tambah Data -->
  <div class="flex justify-end">
    <Link 
      :href="route('manajemen.create')" 
      class="flex items-center gap-1 bg-[#2F2E81] text-white text-sm px-3 py-1 rounded-md shadow hover:bg-[#1f1e5e]"
    >
      <UserPlusIcon class="w-5 h-5" /> Tambah Data
    </Link>
  </div>


            <!-- Table -->
            <div class="overflow-x-auto bg-white rounded-md shadow border border-orange-300">
                <table class="min-w-full table-auto border-collapse text-sm text-gray-800">
                    <thead class="bg-orange-500 text-white">
                        <tr>
                            <th class="px-4 py-3 border border-orange-400 text-center">No</th>
                            <th class="px-4 py-3 border border-orange-400 text-left">NIK</th>
                            <th class="px-4 py-3 border border-orange-400 text-left">Nama</th>
                            <th class="px-4 py-3 border border-orange-400 text-left">Kecamatan</th>
                            <th class="px-4 py-3 border border-orange-400 text-left">Kelurahan</th>
                            <th class="px-4 py-3 border border-orange-400 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="(item, index) in manajemens"
                            :key="item.NIK"
                            class="hover:bg-orange-50"
                        >
                            <td class="px-4 py-2 border border-orange-200 text-center">{{ index + 1 }}</td>
                            <td class="px-4 py-2 border border-orange-200">{{ item.NIK }}</td>
                            <td class="px-4 py-2 border border-orange-200">{{ item.nama }}</td>
                            <td class="px-4 py-2 border border-orange-200">{{ item.kecamatan }}</td>
                            <td class="px-4 py-2 border border-orange-200">{{ item.kelurahan }}</td>
                            <td class="px-4 py-2 border border-orange-200 text-center">
                                <div class="flex justify-center gap-2">
                                    <Link
                                        :href="route('manajemen.edit', { NIK: item.NIK })"
                                        class="p-1 bg-yellow-500 text-white rounded hover:bg-yellow-600"
                                        title="Edit"
                                    >
                                        <Pencil class="w-4 h-4" />
                                    </Link>
                                    <Link
                                        :href="route('manajemen.show', { NIK: item.NIK })"
                                        class="p-1 bg-blue-500 text-white rounded hover:bg-blue-600"
                                        title="Detail"
                                    >
                                        <Eye class="w-4 h-4" />
                                    </Link>
                                    <button
                                        @click="confirmDelete(item.NIK)"
                                        class="p-1 bg-red-500 text-white rounded hover:bg-red-600"
                                        title="Hapus"
                                    >
                                        <Trash2 class="w-4 h-4" />
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Delete Confirmation Modal -->
            <transition name="fade">
                <div v-if="showModal" class="fixed inset-0 z-50 flex items-center justify-center bg-gray-200/50 backdrop-blur-sm">
                    <div class="bg-white rounded-xl shadow-lg p-6 w-full max-w-md text-center">
                        <div class="flex justify-center mb-4">
                            <div class="bg-white rounded-full p-4 border-4 border-orange-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M12 2a10 10 0 1 1 0 20 10 10 0 0 1 0-20z" />
                                </svg>
                            </div>
                        </div>
                        <h2 class="text-2xl font-bold text-orange-600 mb-2">Konfirmasi Hapus</h2>
                        <p class="text-black text-sm mb-6">Apakah Anda yakin ingin menghapus data ini?</p>
                        <div class="flex justify-center gap-4">
                            <button @click="showModal = false" class="bg-gray-500 text-white px-6 py-2 rounded-xl hover:bg-gray-600">Batal</button>
                            <button @click="deleteConfirmed" class="bg-red-600 text-white px-6 py-2 rounded-xl hover:bg-red-700">Hapus</button>
                        </div>
                    </div>
                </div>
            </transition>
        </div>
    </AppLayout>
</template>

<style scoped>
.fade-enter-active, .fade-leave-active {
    transition: opacity 0.3s ease;
}
.fade-enter-from, .fade-leave-to {
    opacity: 0;
}
</style>