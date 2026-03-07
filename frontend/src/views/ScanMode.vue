<template>
  <div class="min-h-screen bg-[#F0F2F5] p-6 flex flex-col items-center">
    <div class="w-full max-w-md flex justify-between items-center mb-8">
      <button @click="$router.back()" class="p-3 bg-white rounded-2xl shadow-vesper text-gray-500">
        <i class="fas fa-chevron-left"></i>
      </button>
      <h1 class="text-xl font-black text-slate-800 tracking-tight italic">Scan <span class="text-blue-600">Sample</span></h1>
      <div class="w-10"></div> </div>

    <div class="w-full max-w-md bg-white p-4 rounded-[2.5rem] shadow-vesper border border-white/50 relative overflow-hidden">
      <div id="reader" class="rounded-[2rem] overflow-hidden"></div>

      <div v-if="!isScanning" class="absolute inset-0 flex flex-col items-center justify-center bg-white/90 z-10 p-8 text-center">
        <div class="w-20 h-20 bg-blue-50 text-blue-600 rounded-3xl flex items-center justify-center mb-6 animate-bounce">
          <i class="fas fa-qrcode text-4xl"></i>
        </div>
        <h2 class="text-lg font-bold text-slate-800 mb-2">Ready to scan</h2>
        <p class="text-sm text-gray-400 mb-6">Align the QR code on the sample vial within the frame.</p>
        <button @click="startScanner" class="bg-blue-600 text-white px-8 py-3 rounded-2xl font-bold shadow-lg shadow-blue-100 transition-transform active:scale-95">
          Activate Camera
        </button>
      </div>
    </div>

    <div class="mt-8 text-center">
      <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Scanner Status</p>
      <div class="flex items-center gap-2 justify-center">
        <div :class="isScanning ? 'bg-green-500 animate-pulse' : 'bg-gray-300'" class="w-2 h-2 rounded-full"></div>
        <span class="text-sm font-bold text-slate-600">{{ isScanning ? 'Searching for code...' : 'Standby' }}</span>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onBeforeUnmount } from 'vue';
import { useRouter } from 'vue-router';
import { Html5Qrcode } from "html5-qrcode";

const router = useRouter();
const isScanning = ref(false);
let html5QrCode = null;

const startScanner = async () => {
  isScanning.value = true;
  html5QrCode = new Html5Qrcode("reader");

  const qrCodeSuccessCallback = (decodedText) => {
    // DecodedText is the UUID we generated
    stopScanner();
    // Redirect to the detail page (assuming your route is /samples/:id)
    router.push({ name: 'sample-detail', params: { id: decodedText }});
  };

  const config = { fps: 10, qrbox: { width: 250, height: 250 } };

  try {
    await html5QrCode.start({ facingMode: "environment" }, config, qrCodeSuccessCallback);
  } catch (err) {
    console.error("Camera access failed", err);
    isScanning.value = false;
  }
};

const stopScanner = () => {
  if (html5QrCode) {
    html5QrCode.stop().then(() => {
      html5QrCode.clear();
      isScanning.value = false;
    });
  }
};

onBeforeUnmount(() => {
  stopScanner();
});
</script>
