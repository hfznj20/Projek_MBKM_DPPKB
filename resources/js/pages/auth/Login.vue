<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Head, useForm } from '@inertiajs/vue3';
import { LoaderCircle } from 'lucide-vue-next';

defineProps<{
    status?: string;
    canResetPassword: boolean;
}>();

const form = useForm({
    NIK: '',
    password: '',
    // email:'',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <div class="min-h-screen flex items-center justify-center bg-[#37347E] font-Gintari p-4">
        <!-- Container form login -->
        <div class="relative w-full max-w-sm bg-white rounded-2xl shadow-lg pt-12 px-6 pb-6 flex flex-col justify-start items-center transition-all scale-95 overflow-visible">
            <Head title="Masuk" />

            <!-- Logo di atas card -->
            <div class="absolute -top-10 flex justify-center w-full">
                <div class="bg-white rounded-full w-20 h-20 flex items-center justify-center">
                    <img src="/logo.png" alt="DPPKB Logo" class="w-16 h-16 object-contain" />
                </div>
            </div>

            <!-- Judul -->
            <h2 class="text-base font-semibold text-center mb-2 text-[#37347E]">DPPKB PAREPARE</h2>

            <!-- Status message -->
            <div v-if="status" class="mb-2 text-center text-xs font-medium text-green-600">
                {{ status }}
            </div>

            <!-- Form -->
            <form @submit.prevent="submit" class="flex flex-col gap-3 w-full">
                <!-- Email -->
                <div class="grid gap-1">
                    <label for="email" style="font-size: 0.8rem; text-align: center;">NIK</label>
                    <Input
                        id="nik"
                        type="text"
                        required
                        autofocus
                        :tabindex="1"
                        autocomplete="email"
                        v-model="form.NIK"  
                        placeholder="Masukkan NIK"
                        class="w-full h-9 rounded-full border border-[#E7942A] focus:outline-none focus:ring-2 focus:ring-[#E7942A]/40 text-xs sm:text-sm md:text-base transition-all duration-300"
                    />
                    <InputError :message="form.errors.NIK" />
                </div>

                <!-- Password -->
                <div class="grid gap-1">
                    <label for="password" style="font-size: 0.8rem; text-align: center;">Kata Sandi</label>
                    <Input
                        id="password"
                        type="password"
                        required
                        :tabindex="2"
                        autocomplete="current-password"
                        v-model="form.password"
                        placeholder="Kata sandi"
                        class="w-full h-9 rounded-full border border-[#E7942A] focus:outline-none focus:ring-2 focus:ring-orange-400 text-xs sm:text-sm md:text-base transition-all duration-300"
                    />
                    <InputError :message="form.errors.password" />
                </div>

                <TextLink v-if="canResetPassword" :href="route('password.request')" class="text-[10px]" :tabindex="5">
                    Lupa kata sandi?
                </TextLink>

                <!-- Submit Button -->
                <Button
                    type="submit"
                    class="w-full mt-1 bg-orange-500 hover:bg-orange-600 text-white transition-colors duration-300 h-10 rounded-full flex items-center justify-center text-xs"
                    :tabindex="4"
                    :disabled="form.processing"
                >
                    <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin mr-2" />
                    Masuk
                </Button>
            </form>
        </div>
    </div>
</template>
