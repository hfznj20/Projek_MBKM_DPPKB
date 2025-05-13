<script setup lang="ts">
import { onMounted } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import ImageSlider from '../components/ImageSlider.vue'; // Atur path sesuai lokasi file saat ini
import L from 'leaflet';
import 'leaflet/dist/leaflet.css';

onMounted(() => {
  const mapContainer = document.getElementById('map');

  if (mapContainer) {
    const map = L.map(mapContainer, {
      center: [-4.0296878, 119.6320417],
      zoom: 17,
      zoomControl: false,
    });

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    L.marker([-4.0296878, 119.6320417]).addTo(map)
      .bindPopup('Jl. Jenderal Sudirman No.107, Cappa Galung, Kec. Bacukiki Barat, Kota Parepare, Sulawesi Selatan 91125')
      .openPopup();

    setTimeout(() => {
      map.invalidateSize();
    }, 500);
  }
});
</script>

<template>
  <Head title="DPPKB Kota Parepare" />

  <div class="flex min-h-screen flex-col bg-white p-6 text-[#1b1b18]">
    <!-- Header -->
    <header class="bg-[#37347E] w-full p-2 flex items-center justify-between fixed top-0 left-0 right-0 z-10">
      <div class="pr-20">
        <a href="register">
          <img src="/logo.png" alt="Logo" class="w-10 h-auto" />
        </a>
      </div>

      <div class="flex-1 flex justify-center pr-20">
        <marquee behavior="scroll" direction="left" class="text-white text-lg">
          Dinas Pengendalian Penduduk dan Keluarga Berencana (DPPKB) Pemerintah Kota Parepare
        </marquee>
      </div>

      <nav class="flex items-center gap-3">
        <Link
          :href="route('login')"
          class="inline-block rounded-[18px] border border-transparent px-8 py-1 text-xs leading-normal text-white bg-[#FF750F] hover:bg-[#FF8C3A]"
        >
          Masuk
        </Link>
      </nav>
    </header>

    <div class="flex w-full flex-1 flex-col items-center justify-center mt-[70px]">
      <main class="flex w-full flex-col items-center gap-6">
        <ImageSlider />

        <!-- Teks -->
        <div class="w-full flex justify-center items-center mt-6">
          <div class="max-w-2xl text-center">
            <h2 class="text-[#37347E] text-2xl font-bold mb-4">DPPKB KOTA PAREPARE</h2>
            <p class="text-[#37347E] text-base">
              DPPKB Kota Parepare merupakan instansi yang memiliki visi dan misi untuk meningkatkan kualitas hidup masyarakat melalui program keluarga berencana dan pengendalian penduduk. Program ini bertujuan untuk menciptakan keluarga yang sehat, sejahtera, dan berkualitas. Berbagai inisiatif dilakukan untuk memastikan pertumbuhan penduduk yang terkontrol, serta mendukung pendidikan dan pelayanan kesehatan untuk masyarakat Kota Parepare.
            </p>
          </div>
        </div>

        <!-- Video YouTube -->
<!-- Video YouTube dengan Nuansa Oranye-Putih -->
<div class="w-full flex justify-center mt-6 px-4">
  <div class="w-full max-w-3xl rounded-2xl overflow-hidden shadow-lg border-1 border-[#37347E] bg-white p-2">
    <div class="rounded-xl overflow-hidden">
      <iframe
        class="w-full aspect-video"
        src="https://www.youtube.com/embed/esqK08D5pAk?si=qcVq18sDF1QuibPI"
        title="YouTube video"
        frameborder="0"
        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
        allowfullscreen
      ></iframe>
    </div>
    <div class="text-center text-[#37347E] font-semibold mt-3">
      Video Profil DPPKB Kota Parepare
    </div>
  </div>
</div>



        <!-- Border Orange Full dengan Border Tipis dan Radius -->
        <div class="w-full border-1 border-[#37347E] rounded-lg overflow-hidden bg-white shadow-lg flex flex-col">
          <!-- Profil -->
          <div class="w-full p-4 border-b-1 border-[#37347E]">
            <h3 class="text-[#37347E] text-lg font-semibold text-center">PROFIL</h3>
          </div>

          <!-- Ikon-ikon -->
          <div class="flex justify-around items-center p-4 bg-white border-b-1 border-[#37347E]">
            <div class="flex flex-col items-center">
              <svg class="w-14 h-14 text-[#37347E] mb-2" fill="currentColor" viewBox="0 0 24 24">
                <path d="M6.62 10.79a15.05 15.05 0 006.59 6.59l2.2-2.2a1 1 0 011.11-.27 11.36 11.36 0 003.55.57 1 1 0 011 1V20a1 1 0 01-1 1A16 16 0 014 5a1 1 0 011-1h3.5a1 1 0 011 1 11.36 11.36 0 00.57 3.55 1 1 0 01-.27 1.11l-2.18 2.13z"/>
              </svg>
              <span class="text-[#37347E] text-base font-semibold">00000</span>
            </div>

            <div class="flex flex-col items-center">
              <svg class="w-14 h-14 text-[#37347E] mb-2" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 2C8.13 2 5 5.13 5 9c0 4.15 2.69 7.73 6.47 10.54L12 21l.53-.46C16.31 16.73 19 13.15 19 9c0-3.87-3.13-7-7-7zM12 14.5c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2z"/>
              </svg>
              <span class="text-[#37347E] text-base font-semibold">Jl. Jendral Sudirman No.107</span>
            </div>

            <a href="https://www.instagram.com/dppkbkotaparepare?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==" target="_blank" rel="noopener noreferrer">
              <div class="flex flex-col items-center">
                <svg class="w-14 h-14 text-[#37347E] mb-2" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M7.5 2h9A5.5 5.5 0 0122 7.5v9a5.5 5.5 0 01-5.5 5.5h-9A5.5 5.5 0 012 16.5v-9A5.5 5.5 0 017.5 2zm5.25 6.75a1.75 1.75 0 10-3.5 0 1.75 1.75 0 003.5 0zm-5.5 9.75h11.5v-1.5a4.5 4.5 0 00-9 0v1.5z"/>
                </svg>
                <span class="text-[#37347E] text-base font-semibold">@dppkbkotaparepare</span>
              </div>
            </a>

            <div class="flex flex-col items-center">
              <svg class="w-14 h-14 text-[#37347E] mb-2" fill="currentColor" viewBox="0 0 24 24">
                <path d="M22 12a10 10 0 10-17.32 7.41c.1.11.2.2.31.29V15.6h-2v-3h2v-2.3c0-2.05 1.22-3.2 3.09-3.2.9 0 1.84.16 1.84.16v2h-1.04c-1.03 0-1.35.64-1.35 1.29v1.55h2.29l-.37 3h-1.92v4.1a10 10 0 0012-9.9z"/>
              </svg>
              <span class="text-[#37347E] text-base font-semibold">@dppkb</span>
            </div>
          </div>

          <!-- Map -->
          <div class="h-[300px] w-full border-t-1 border-[#37347E] rounded-b-lg overflow-hidden">
            <div id="map" style="height: 100%;"></div>
          </div>
        </div>
      </main>
    </div>
  </div>
</template>