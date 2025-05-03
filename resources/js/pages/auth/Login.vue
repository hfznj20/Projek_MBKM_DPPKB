<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Head, useForm } from '@inertiajs/vue3';
import { LoaderCircle } from 'lucide-vue-next';

defineProps<{
    status?: string;
    canResetPassword: boolean;
}>();

const form = useForm({
    NIK: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <div class="min-h-screen flex items-center justify-center bg-[#071556] font-Gintari p-4">
        <!-- Form login container -->
        <div class="w-full max-w-md bg-white rounded-lg shadow-lg p-6 sm:p-8 flex flex-col justify-center items-center transition-all">
            <Head title="Masuk" />
                        <!-- Judul -->
            <div class="flex aspect-square size-20 items-center justify-center rounded-md bg-transparent text-sidebar-primary-foreground">
                <!-- Mengakses logo dengan latar belakang transparan -->
                <img src="/logo.png" alt="DPPKB Logo" class="size-20 object-contain" />
                </div>
            <h2 class="text-1xl font-semibold text-center mb-2 text-[#37347E]">DPPKB PAREPARE</h2>
            <p class="text-sm sm:text-base text-center text-gray-500 mb-6">
            </p>

            <!-- Status message -->
            <div v-if="status" class="mb-4 text-center text-sm font-medium text-green-600">
                {{ status }}
            </div>

            <!-- Form -->
            <form @submit.prevent="submit" class="flex flex-col gap-4 w-full ">
                <!-- Email -->
                <div class="grid gap-2">
                    <Label for="NIK">ID Pengguna (NIK)</Label>
                    <Input
                        id="NIK"
                        type="text"
                        required
                        autofocus
                        :tabindex="1"
                        v-model="form.NIK"
                        placeholder="Masukkan NIK (16 digit)"
                        class="w-full h-10 rounded-full border border-[#E7942A] focus:outline-none focus:border-[#E7942A] focus:ring-4 focus:ring-[#E7942A]/60 transition-all duration-300"
                    />
                    <InputError :message="form.errors.NIK" />
                </div>

                <!-- Password -->
                <div class="grid gap-1">
                    <div class="flex items-center justify-between">
                        <Label for="password">Kata Sandi</Label>
                        <TextLink v-if="canResetPassword" :href="route('password.request')" class="text-sm" :tabindex="5">
                            Lupa kata sandi?
                        </TextLink>
                    </div>
                    <Input
                        id="password"
                        type="password"
                        required
                        :tabindex="2"
                        autocomplete="current-password"
                        v-model="form.password"
                        placeholder="Kata sandi"
                        class="w-full h-10 rounded-full border border-[#E7942A] focus:outline-none focus:ring-2 focus:ring-orange-500 transition-colors duration-300"
                    />
                    <InputError :message="form.errors.password" />
                </div>

                <!-- Checkbox -->
                <div class="flex items-center space-x-2">
                    <Checkbox id="remember" v-model="form.remember" :tabindex="3"
                        class="border-[#1E1E1E] hover:border-orange-500 focus:ring-2 focus:ring-orange-500 transition-colors duration-300"
                    />
                    <Label for="remember">Ingat saya</Label>
                </div>

                <!-- Submit -->
                <Button
                    type="submit"
                    class="w-full mt-2 bg-orange-500 hover:bg-orange-600 text-white transition-colors duration-300 h-12 rounded-full flex items-center justify-center"
                    :tabindex="4"
                    :disabled="form.processing"
                >
                    <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin mr-2" />
                    Masuk
                </Button>

                <!-- Daftar -->
                <div class="text-center text-sm text-muted-foreground mt-2">
                    Belum punya akun?
                    <TextLink :href="route('register')" :tabindex="5">Daftar sekarang</TextLink>
                </div>
            </form>
        </div>
    </div>
</template>
