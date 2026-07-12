<template>
  <div class="min-h-screen bg-gradient-to-br from-slate-100 to-slate-200 flex flex-col justify-center py-12 sm:px-6 lg:px-8 font-sans">
    <div class="sm:mx-auto sm:w-full sm:max-w-md text-center">
      <!-- Logo and Heading -->
      <div class="flex justify-center items-center gap-3 mb-6">
        <div class="w-12 h-12 bg-blue-600 rounded-2xl flex items-center justify-center shadow-lg shadow-blue-200">
          <i class="fas fa-flask text-white text-xl"></i>
        </div>
        <div class="text-left">
          <span class="text-2xl font-black text-slate-800 tracking-tighter block">BSTI <span class="text-blue-600">PORTAL</span></span>
          <span class="text-[10px] font-bold text-slate-400 tracking-wider uppercase">Bangladesh Standards and Testing Institution</span>
        </div>
      </div>
      <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">
        Sign in to your account
      </h2>
      <p class="mt-2 text-sm text-slate-500">
        Access the integrated digital management portal
      </p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
      <div class="bg-white py-10 px-8 shadow-xl rounded-[2.5rem] border border-slate-100">
        <!-- Error Alert -->
        <div v-if="authStore.error" class="mb-6 p-4 bg-rose-50 border border-rose-100 rounded-2xl flex items-start gap-3 text-rose-700">
          <i class="fas fa-exclamation-circle text-lg mt-0.5 shrink-0"></i>
          <div>
            <p class="text-xs font-black uppercase tracking-wider">Authentication Error</p>
            <p class="text-sm font-semibold mt-0.5">{{ authStore.error }}</p>
          </div>
        </div>

        <form class="space-y-6" @submit.prevent="handleLogin">
          <!-- Identifier Input (Email or Employee ID) -->
          <div>
            <label for="identifier" class="block text-xs font-black uppercase tracking-wider text-slate-400 mb-2">
              Email or Employee ID
            </label>
            <div class="relative">
              <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                <i class="fas fa-user-circle"></i>
              </div>
              <input
                id="identifier"
                v-model="email"
                type="text"
                required
                autocomplete="username"
                placeholder="e.g. shashidas95@gmail.com or 19611010001"
                class="block w-full pl-11 pr-4 py-3.5 border border-slate-200 rounded-2xl text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 font-medium text-sm transition-all shadow-sm"
              />
            </div>
          </div>

          <!-- Password Input -->
          <div>
            <label for="password" class="block text-xs font-black uppercase tracking-wider text-slate-400 mb-2">
              Password
            </label>
            <div class="relative">
              <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                <i class="fas fa-lock"></i>
              </div>
              <input
                id="password"
                v-model="password"
                type="password"
                required
                autocomplete="current-password"
                placeholder="••••••••"
                class="block w-full pl-11 pr-4 py-3.5 border border-slate-200 rounded-2xl text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 font-medium text-sm transition-all shadow-sm"
              />
            </div>
          </div>

          <!-- Extra options -->
          <div class="flex items-center justify-between text-xs">
            <div class="flex items-center">
              <input
                id="remember-me"
                type="checkbox"
                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-slate-300 rounded"
              />
              <label for="remember-me" class="ml-2 font-bold text-slate-500 uppercase tracking-wide">
                Remember me
              </label>
            </div>
            <a href="#" class="font-bold text-blue-600 hover:text-blue-700 uppercase tracking-wide">
              Forgot password?
            </a>
          </div>

          <!-- Submit Button -->
          <div>
            <button
              type="submit"
              :disabled="authStore.loading"
              class="w-full flex justify-center py-4 px-4 border border-transparent rounded-2xl shadow-lg text-base font-black text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 shadow-blue-200 disabled:opacity-50 disabled:cursor-not-allowed transition-all"
            >
              <span v-if="authStore.loading" class="flex items-center gap-2">
                <i class="fas fa-spinner animate-spin"></i> Authenticating...
              </span>
              <span v-else>
                Sign In
              </span>
            </button>
          </div>
        </form>

        <!-- Help Notice -->
        <div class="mt-8 pt-6 border-t border-slate-100 text-center">
          <p class="text-xs text-slate-400 font-semibold leading-relaxed">
            Standard User: <span class="text-slate-600 font-bold">shashidas95@gmail.com</span> / password<br />
            BSTI Employees can log in using their 11-digit Employee ID and default password (password).
          </p>
        </div>
      </div>

      <!-- Public actions footer link -->
      <div class="text-center mt-6">
        <router-link to="/" class="text-sm font-black text-slate-500 hover:text-blue-600 transition-colors uppercase tracking-wider flex items-center justify-center gap-2">
          <i class="fas fa-arrow-left"></i> Back to Landing Page
        </router-link>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import { useAuthStore } from '@/stores/authStore';

const authStore = useAuthStore();
const router = useRouter();

const email = ref('');
const password = ref('');

const handleLogin = async () => {
  try {
    const success = await authStore.login(email.value, password.value);
    if (success) {
      router.push('/dashboard');
    }
  } catch (err) {
    // Error is handled inside the Pinia store and displayed in the UI
  }
};
</script>
