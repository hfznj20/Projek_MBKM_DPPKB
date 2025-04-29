<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { type BreadcrumbItem } from '@/types';
import InputError from '@/components/InputError.vue';

const form = useForm({
    nik: '',
    nama_lengkap: '',
    kecamatan: '',
    kelurahan: '',
    RT: '',
    RW: '',
    TTL: '',
    jenis_kelamin: 'Laki-laki',
    no_telepon: '',
    jalan: '',
    nik_tpk: ''
});

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Data Penduduk', href: route('datapenduduk.index') },
    { title: 'Tambah Data', href: route('datapenduduk.create') },
];

const submit = () => {
    form.post(route('datapenduduk.store'), {
        preserveScroll: true,
        onSuccess: () => form.reset(),
        onError: (errors) => console.error(errors)
    });
};
</script>

<template>
    <Head title="Tambah Data Penduduk" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-4 space-y-6">
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-bold">Tambah Data Penduduk</h1>
                <Link :href="route('datapenduduk.index')" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Kembali</Link>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <form @submit.prevent="submit" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block mb-1">NIK</label>
                        <input v-model="form.nik" type="text" maxlength="16" placeholder="Masukkan NIK" class="input" />
                        <InputError :message="form.errors.nik" />
                    </div>

                    <div>
                        <label class="block mb-1">Nama Lengkap</label>
                        <input v-model="form.nama_lengkap" type="text" placeholder="Masukkan nama lengkap" class="input" />
                        <InputError :message="form.errors.nama_lengkap" />
                    </div>

                    <div>
                        <label class="block mb-1">Kecamatan</label>
                        <input v-model="form.kecamatan" type="text" placeholder="Masukkan kecamatan" class="input" />
                        <InputError :message="form.errors.kecamatan" />
                    </div>

                    <div>
                        <label class="block mb-1">Kelurahan</label>
                        <input v-model="form.kelurahan" type="text" placeholder="Masukkan kelurahan" class="input" />
                        <InputError :message="form.errors.kelurahan" />
                    </div>

                    <div>
                        <label class="block mb-1">RT</label>
                        <input v-model="form.RT" type="text" placeholder="Masukkan RT" class="input" />
                        <InputError :message="form.errors.RT" />
                    </div>

                    <div>
                        <label class="block mb-1">RW</label>
                        <input v-model="form.RW" type="text" placeholder="Masukkan RW" class="input" />
                        <InputError :message="form.errors.RW" />
                    </div>

                    <div>
                        <label class="block mb-1">Tanggal Lahir</label>
                        <input v-model="form.TTL" type="date" class="input" />
                        <InputError :message="form.errors.TTL" />
                    </div>

                    <div>
                        <label class="block mb-1">Jenis Kelamin</label>
                        <select v-model="form.jenis_kelamin" class="input">
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                        <InputError :message="form.errors.jenis_kelamin" />
                    </div>

                    <div>
                        <label class="block mb-1">No. Telepon</label>
                        <input v-model="form.no_telepon" type="text" placeholder="Masukkan nomor telepon" class="input" />
                        <InputError :message="form.errors.no_telepon" />
                    </div>

                    <div class="md:col-span-2">
                        <label class="block mb-1">Jalan</label>
                        <textarea v-model="form.jalan" rows="2" placeholder="Masukkan nama jalan" class="input"></textarea>
                        <InputError :message="form.errors.jalan" />
                    </div>

                    <div class="md:col-span-2">
                        <label class="block mb-1">NIK TPK</label>
                        <input v-model="form.nik_tpk" type="text" placeholder="Masukkan NIK TPK (opsional)" class="input" />
                        <InputError :message="form.errors.nik_tpk" />
                    </div>

                    <div class="md:col-span-2 flex justify-end gap-3">
                        <Link :href="route('datapenduduk.index')" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Batal</Link>
                        <button type="submit" :disabled="form.processing" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 disabled:opacity-50">
                            <span v-if="form.processing">Menyimpan...</span>
                            <span v-else>Simpan Data</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </AppLayout>
</template>

