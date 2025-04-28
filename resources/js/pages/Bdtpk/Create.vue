<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, useForm} from '@inertiajs/vue3';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
 // Import Link karena sekarang dipakai

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Baduta Create TPK',
    href: '/bdtpk/create',
  },
];
const form = useForm({
    nik:"",
    nama:""
})
function submit() {
    form.post(route('bdtpk.store'), {
        preserveScroll: true,
        onSuccess: ()=> form.reset()
    })
}

// Sample data

</script>

<template>
  <Head title="Baduta TPK" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
      <!-- Tambah Data Button (sekarang pakai Link) -->
      <div class="flex justify-start mb-2">
        <Link
          href="/bdtpk"
          class="   px-4 py-2 text-sm font-medium text-white bg-green-500 rounded hover:bg-green-600"
        >
          Kembali
        </Link>
      </div>

         <form @submit.prevent="submit">
            <div class="grid gap-2">
                            <Label for="nik">Nik:</Label>
                            <Input
                                id="nik"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.nik"

                                placeholder="nik"
                            />
                            <InputError class="mt-2" :message="form.errors.nik" />
                        </div>
                        <div class="grid gap-2">
                            <Label for="nama">Nama:</Label>
                            <Input
                                id="nama"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.nama"

                                placeholder="nama"
                            />
                            <InputError class="mt-2" :message="form.errors.nama" />
                        </div>
                        <div class="flex items-center gap-4">
                            <Button>Save</Button>
                            </div>
    </form>

    </div>
  </AppLayout>
</template>
