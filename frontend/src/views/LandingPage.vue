<template>
  <div class="min-h-screen bg-slate-50 font-sans text-slate-800 flex flex-col">
    <!-- Navbar -->
    <header class="bg-white border-b border-slate-200 sticky top-0 z-50 shadow-sm">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
        <div class="flex items-center gap-3">
          <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center shadow-lg shadow-blue-200">
            <i class="fas fa-flask text-white"></i>
          </div>
          <div>
            <span class="text-xl font-black text-slate-800 tracking-tighter block">BSTI <span class="text-blue-600">PORTAL</span></span>
            <span class="text-[9px] font-bold text-slate-400 tracking-wider uppercase">BSTI Management System</span>
          </div>
        </div>

        <nav class="hidden md:flex items-center gap-8">
          <a href="#services" class="text-sm font-bold text-slate-600 hover:text-blue-600 transition-colors">Our Services</a>
          <a href="#how-it-works" class="text-sm font-bold text-slate-600 hover:text-blue-600 transition-colors">How It Works</a>
          <router-link to="/food-verify" class="text-sm font-bold text-slate-600 hover:text-blue-600 transition-colors">Verify Certificate</router-link>
        </nav>

        <div class="flex items-center gap-3">
          <router-link to="/dashboard" class="px-5 py-2.5 rounded-xl text-sm font-black text-slate-700 bg-slate-100 hover:bg-slate-200 transition-all">
            Log in
          </router-link>
          <router-link to="/dashboard" class="px-5 py-2.5 rounded-xl text-sm font-black text-white bg-blue-600 hover:bg-blue-700 hover:shadow-lg hover:shadow-blue-200 transition-all">
            Register
          </router-link>
        </div>
      </div>
    </header>

    <!-- Hero Section -->
    <section class="relative bg-gradient-to-b from-white to-slate-50 pt-16 pb-20 md:pt-24 md:pb-28 overflow-hidden">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
          <!-- Hero Text -->
          <div class="lg:col-span-7 space-y-6 text-center lg:text-left">
            <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-blue-50 text-blue-700 rounded-full text-xs font-bold uppercase tracking-wider">
              <span class="w-2 h-2 bg-blue-600 rounded-full animate-pulse"></span> Bangladesh Standards and Testing Institution
            </div>

            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black text-slate-900 tracking-tight leading-none">
              Digital Certification <br class="hidden sm:inline" />
              <span class="text-blue-600">& Licensing Platform</span>
            </h1>

            <p class="text-base sm:text-lg text-slate-500 font-medium max-w-2xl mx-auto lg:mx-0">
              Complete digitization of BSTI's certification, testing, inspection, and licensing services across all wings — CM, Chemical, Physical, Metrology, and Standard.
            </p>

            <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4">
              <router-link to="/dashboard" class="w-full sm:w-auto px-8 py-4 rounded-2xl text-base font-black text-white bg-blue-600 hover:bg-blue-700 shadow-xl shadow-blue-200 hover:scale-[1.02] transition-all text-center">
                Get Started
              </router-link>
              <a href="#how-it-works" class="w-full sm:w-auto px-8 py-4 rounded-2xl text-base font-black text-slate-700 bg-white border border-slate-200 hover:bg-slate-50 hover:border-slate-300 transition-all text-center">
                CM License Guide
              </a>
            </div>
          </div>

          <!-- Hero Graphic / Key Stats -->
          <div class="lg:col-span-5 relative">
            <div class="absolute inset-0 bg-gradient-to-tr from-blue-100 to-transparent rounded-full blur-3xl opacity-50 -z-10"></div>
            <div class="bg-white p-8 rounded-[2.5rem] shadow-xl border border-slate-100/80 space-y-6">
              <h3 class="text-lg font-black text-slate-950 tracking-tight flex items-center gap-2">
                <i class="fas fa-chart-line text-blue-600"></i> Platform Statistics
              </h3>

              <div class="grid grid-cols-2 gap-4">
                <div class="p-5 bg-slate-50 rounded-2xl border border-slate-100">
                  <span class="block text-3xl font-black text-slate-900">43</span>
                  <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block mt-1">Business Processes</span>
                </div>
                <div class="p-5 bg-slate-50 rounded-2xl border border-slate-100">
                  <span class="block text-3xl font-black text-slate-900">9</span>
                  <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block mt-1">Wings Covered</span>
                </div>
                <div class="p-5 bg-slate-50 rounded-2xl border border-slate-100">
                  <span class="block text-3xl font-black text-slate-900">64</span>
                  <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block mt-1">District Offices</span>
                </div>
                <div class="p-5 bg-blue-50/50 rounded-2xl border border-blue-100/50">
                  <span class="block text-3xl font-black text-blue-600">100%</span>
                  <span class="text-xs font-bold text-blue-500 uppercase tracking-wider block mt-1">Digital Workflow</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="py-20 bg-slate-100">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-16 space-y-4">
          <h2 class="text-3xl sm:text-4xl font-black text-slate-900 tracking-tight">Services Across All Wings</h2>
          <p class="text-slate-500 font-medium">End-to-end digital management for every BSTI service.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
          <!-- CM Certification -->
          <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-slate-100 hover:shadow-md transition-all flex flex-col justify-between">
            <div class="space-y-4">
              <div class="w-12 h-12 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-600">
                <i class="fas fa-certificate text-xl"></i>
              </div>
              <h3 class="text-xl font-black text-slate-900 tracking-tight">CM Certification</h3>
              <p class="text-sm text-slate-500 leading-relaxed">
                Scope & mandatory product licensing, brand inclusion, renewal, clearance certificates, and halal certification with 2-stage audit.
              </p>
              <div class="flex flex-wrap gap-2 pt-2">
                <span class="px-3 py-1 bg-slate-100 rounded-full text-xs font-bold text-slate-600">License Issue</span>
                <span class="px-3 py-1 bg-slate-100 rounded-full text-xs font-bold text-slate-600">Renewal</span>
                <span class="px-3 py-1 bg-slate-100 rounded-full text-xs font-bold text-slate-600">Halal</span>
              </div>
            </div>
            <router-link to="/dashboard" class="mt-6 flex items-center gap-2 text-sm font-black text-blue-600 hover:text-blue-700 transition-colors group">
              Login to apply <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
            </router-link>
          </div>

          <!-- Chemical Testing -->
          <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-slate-100 hover:shadow-md transition-all flex flex-col justify-between">
            <div class="space-y-4">
              <div class="w-12 h-12 bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-600">
                <i class="fas fa-flask text-xl"></i>
              </div>
              <h3 class="text-xl font-black text-slate-900 tracking-tight">Chemical Testing</h3>
              <p class="text-sm text-slate-500 leading-relaxed">
                Sample registration, per-parameter test entry with raw data, multi-level verification chain, and automated report generation.
              </p>
              <div class="flex flex-wrap gap-2 pt-2">
                <span class="px-3 py-1 bg-slate-100 rounded-full text-xs font-bold text-slate-600">Lab Testing</span>
                <span class="px-3 py-1 bg-slate-100 rounded-full text-xs font-bold text-slate-600">Reports</span>
              </div>
            </div>
            <router-link to="/dashboard" class="mt-6 flex items-center gap-2 text-sm font-black text-blue-600 hover:text-blue-700 transition-colors group">
              Login to apply <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
            </router-link>
          </div>

          <!-- Physical Testing -->
          <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-slate-100 hover:shadow-md transition-all flex flex-col justify-between">
            <div class="space-y-4">
              <div class="w-12 h-12 bg-purple-50 rounded-2xl flex items-center justify-center text-purple-600">
                <i class="fas fa-microscope text-xl"></i>
              </div>
              <h3 class="text-xl font-black text-slate-900 tracking-tight">Physical Testing</h3>
              <p class="text-sm text-slate-500 leading-relaxed">
                Physical property testing, energy meter calibration, sample collection scheduling, and per-parameter result verification.
              </p>
              <div class="flex flex-wrap gap-2 pt-2">
                <span class="px-3 py-1 bg-slate-100 rounded-full text-xs font-bold text-slate-600">Calibration</span>
                <span class="px-3 py-1 bg-slate-100 rounded-full text-xs font-bold text-slate-600">Energy Meters</span>
              </div>
            </div>
            <router-link to="/dashboard" class="mt-6 flex items-center gap-2 text-sm font-black text-blue-600 hover:text-blue-700 transition-colors group">
              Login to apply <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
            </router-link>
          </div>

          <!-- Metrology -->
          <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-slate-100 hover:shadow-md transition-all flex flex-col justify-between">
            <div class="space-y-4">
              <div class="w-12 h-12 bg-amber-50 rounded-2xl flex items-center justify-center text-amber-600">
                <i class="fas fa-balance-scale text-xl"></i>
              </div>
              <h3 class="text-xl font-black text-slate-900 tracking-tight">Metrology</h3>
              <p class="text-sm text-slate-500 leading-relaxed">
                Instrument licensing, calibration certificates, tank lorry verification, storage tank calibration, and PCR registration.
              </p>
              <div class="flex flex-wrap gap-2 pt-2">
                <span class="px-3 py-1 bg-slate-100 rounded-full text-xs font-bold text-slate-600">Licensing</span>
                <span class="px-3 py-1 bg-slate-100 rounded-full text-xs font-bold text-slate-600">7 Sub-types</span>
              </div>
            </div>
            <router-link to="/dashboard" class="mt-6 flex items-center gap-2 text-sm font-black text-blue-600 hover:text-blue-700 transition-colors group">
              Login to apply <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
            </router-link>
          </div>

          <!-- MSC Certification -->
          <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-slate-100 hover:shadow-md transition-all flex flex-col justify-between">
            <div class="space-y-4">
              <div class="w-12 h-12 bg-cyan-50 rounded-2xl flex items-center justify-center text-cyan-600">
                <i class="fas fa-award text-xl"></i>
              </div>
              <h3 class="text-xl font-black text-slate-900 tracking-tight">MSC Certification</h3>
              <p class="text-sm text-slate-500 leading-relaxed">
                Management system certification with 5-level approval chain, 2-stage audits, findings tracking, and committee decisions.
              </p>
              <div class="flex flex-wrap gap-2 pt-2">
                <span class="px-3 py-1 bg-slate-100 rounded-full text-xs font-bold text-slate-600">ISO Certification</span>
                <span class="px-3 py-1 bg-slate-100 rounded-full text-xs font-bold text-slate-600">5-level Approval</span>
              </div>
            </div>
            <router-link to="/dashboard" class="mt-6 flex items-center gap-2 text-sm font-black text-blue-600 hover:text-blue-700 transition-colors group">
              Login to apply <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
            </router-link>
          </div>

          <!-- Public Verification -->
          <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-slate-100 hover:shadow-md transition-all flex flex-col justify-between">
            <div class="space-y-4">
              <div class="w-12 h-12 bg-rose-50 rounded-2xl flex items-center justify-center text-rose-600">
                <i class="fas fa-shield-alt text-xl"></i>
              </div>
              <h3 class="text-xl font-black text-slate-900 tracking-tight">Public Verification</h3>
              <p class="text-sm text-slate-500 leading-relaxed">
                Verify any BSTI certificate, license, or clearance online. No login required — just enter the certificate number.
              </p>
              <div class="flex flex-wrap gap-2 pt-2">
                <span class="px-3 py-1 bg-slate-100 rounded-full text-xs font-bold text-slate-600">No Login Required</span>
                <span class="px-3 py-1 bg-slate-100 rounded-full text-xs font-bold text-slate-600">Instant Result</span>
              </div>
            </div>
            <router-link to="/food-verify" class="mt-6 flex items-center gap-2 text-sm font-black text-blue-600 hover:text-blue-700 transition-colors group">
              Verify now <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
            </router-link>
          </div>

          <!-- BDS Standards -->
          <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-slate-100 hover:shadow-md transition-all flex flex-col justify-between md:col-span-2 lg:col-span-1">
            <div class="space-y-4">
              <div class="w-12 h-12 bg-indigo-50 rounded-2xl flex items-center justify-center text-indigo-600">
                <i class="fas fa-book text-xl"></i>
              </div>
              <h3 class="text-xl font-black text-slate-900 tracking-tight">BDS Standards</h3>
              <p class="text-sm text-slate-500 leading-relaxed">
                Search, browse, and purchase official Bangladesh Standards. 339 standards available with ICS classification codes.
              </p>
              <div class="flex flex-wrap gap-2 pt-2">
                <span class="px-3 py-1 bg-slate-100 rounded-full text-xs font-bold text-slate-600">339 Standards</span>
                <span class="px-3 py-1 bg-slate-100 rounded-full text-xs font-bold text-slate-600">Search & Purchase</span>
              </div>
            </div>
            <router-link to="/products" class="mt-6 flex items-center gap-2 text-sm font-black text-blue-600 hover:text-blue-700 transition-colors group">
              Browse standards <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
            </router-link>
          </div>
        </div>
      </div>
    </section>

    <!-- Built for Modern Governance -->
    <section class="py-20 bg-white">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-16 space-y-4">
          <h2 class="text-3xl sm:text-4xl font-black text-slate-900 tracking-tight">Built for Modern Governance</h2>
          <p class="text-slate-500 font-medium">Enterprise-grade features for Bangladesh's standards authority.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
          <div class="space-y-3">
            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-lg">
              <i class="fas fa-history"></i>
            </div>
            <h4 class="text-lg font-black text-slate-900 tracking-tight">Real-time Workflow</h4>
            <p class="text-sm text-slate-500 leading-relaxed">
              Instant forwarding, approvals, and notifications across the entire officer chain.
            </p>
          </div>

          <div class="space-y-3">
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-lg">
              <i class="fas fa-shield-alt"></i>
            </div>
            <h4 class="text-lg font-black text-slate-900 tracking-tight">Secure & Auditable</h4>
            <p class="text-sm text-slate-500 leading-relaxed">
              Complete audit trail, role-based access, and Spatie permission integration.
            </p>
          </div>

          <div class="space-y-3">
            <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center text-lg">
              <i class="fas fa-credit-card"></i>
            </div>
            <h4 class="text-lg font-black text-slate-900 tracking-tight">Online Payment</h4>
            <p class="text-sm text-slate-500 leading-relaxed">
              SSL Commerz, Sonali Bank, bKash, Rocket — integrated payment processing.
            </p>
          </div>

          <div class="space-y-3">
            <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-lg">
              <i class="fas fa-globe"></i>
            </div>
            <h4 class="text-lg font-black text-slate-900 tracking-tight">Nationwide Access</h4>
            <p class="text-sm text-slate-500 leading-relaxed">
              64 district offices, 8 divisions, 519 upazilas — fully connected digital network.
            </p>
          </div>
        </div>
      </div>
    </section>

    <!-- How It Works Section -->
    <section id="how-it-works" class="py-20 bg-slate-50 border-t border-slate-100">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-16 space-y-4">
          <h2 class="text-3xl sm:text-4xl font-black text-slate-900 tracking-tight">How It Works</h2>
          <p class="text-slate-500 font-medium">Simple steps to get your BSTI certification.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 relative">
          <!-- Step 1 -->
          <div class="bg-white p-6 rounded-2xl border border-slate-200/60 relative shadow-sm">
            <div class="w-10 h-10 bg-blue-600 text-white rounded-full flex items-center justify-center font-black absolute -top-5 left-6 shadow-md">
              1
            </div>
            <h4 class="text-lg font-black text-slate-900 tracking-tight mt-4 mb-2">Learn</h4>
            <p class="text-xs text-slate-500 leading-relaxed mb-4">
              Read the CM License Guide to understand requirements and prepare your documents.
            </p>
            <a href="#how-it-works" class="text-xs font-black text-blue-600 hover:underline">View Guide →</a>
          </div>

          <!-- Step 2 -->
          <div class="bg-white p-6 rounded-2xl border border-slate-200/60 relative shadow-sm">
            <div class="w-10 h-10 bg-blue-600 text-white rounded-full flex items-center justify-center font-black absolute -top-5 left-6 shadow-md">
              2
            </div>
            <h4 class="text-lg font-black text-slate-900 tracking-tight mt-4 mb-2">Apply</h4>
            <p class="text-xs text-slate-500 leading-relaxed">
              Select service, fill application form, upload documents, pay fees.
            </p>
          </div>

          <!-- Step 3 -->
          <div class="bg-white p-6 rounded-2xl border border-slate-200/60 relative shadow-sm">
            <div class="w-10 h-10 bg-blue-600 text-white rounded-full flex items-center justify-center font-black absolute -top-5 left-6 shadow-md">
              3
            </div>
            <h4 class="text-lg font-black text-slate-900 tracking-tight mt-4 mb-2">Review</h4>
            <p class="text-xs text-slate-500 leading-relaxed">
              BSTI officers review, inspect, test, and approve your application.
            </p>
          </div>

          <!-- Step 4 -->
          <div class="bg-white p-6 rounded-2xl border border-slate-200/60 relative shadow-sm">
            <div class="w-10 h-10 bg-blue-600 text-white rounded-full flex items-center justify-center font-black absolute -top-5 left-6 shadow-md">
              4
            </div>
            <h4 class="text-lg font-black text-slate-900 tracking-tight mt-4 mb-2">Certificate</h4>
            <p class="text-xs text-slate-500 leading-relaxed">
              Download your certificate, verify it online, manage renewals.
            </p>
          </div>
        </div>
      </div>
    </section>

    <!-- CTAs & Footer -->
    <section class="bg-blue-600 py-16 text-white text-center">
      <div class="max-w-4xl mx-auto px-4 space-y-6">
        <h3 class="text-3xl font-black tracking-tight">New to BSTI Certification?</h3>
        <p class="text-blue-100 max-w-xl mx-auto">
          Explore our complete CM License Guide — learn which products require mandatory certification, understand the 6-step process, prepare your documents, and review the fee structure.
        </p>
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4 pt-4">
          <router-link to="/dashboard" class="w-full sm:w-auto px-8 py-3.5 bg-white text-blue-600 font-black rounded-xl hover:bg-blue-50 transition-all shadow-md">
            Register Now
          </router-link>
          <router-link to="/food-verify" class="w-full sm:w-auto px-8 py-3.5 bg-blue-700 text-white font-black rounded-xl hover:bg-blue-800 border border-blue-500/30 transition-all">
            Verify Certificate
          </router-link>
        </div>
      </div>
    </section>

    <!-- Footer -->
    <footer class="bg-slate-900 text-slate-400 py-16 border-t border-slate-800">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-4 gap-12">
        <!-- Brand Info -->
        <div class="space-y-4">
          <span class="text-white text-lg font-black tracking-tighter">BSTI Management System</span>
          <p class="text-xs leading-relaxed text-slate-500">
            Bangladesh Standards and Testing Institution<br />
            Building #2, E/8-A Rokeya Sarani, Sher-e-Bangla Nagar, Dhaka-1207
          </p>
        </div>

        <!-- Quick Links -->
        <div>
          <h5 class="text-white text-sm font-black uppercase tracking-wider mb-4">Quick Links</h5>
          <ul class="space-y-2 text-xs">
            <li><a href="#how-it-works" class="hover:text-white transition-colors">CM License Guide</a></li>
            <li><router-link to="/products" class="hover:text-white transition-colors">BDS Standards Search & Sale</router-link></li>
            <li><router-link to="/dashboard" class="hover:text-white transition-colors">Login</router-link></li>
            <li><router-link to="/dashboard" class="hover:text-white transition-colors">Register</router-link></li>
            <li><router-link to="/food-verify" class="hover:text-white transition-colors">Verify Certificate</router-link></li>
          </ul>
        </div>

        <!-- Contact Info -->
        <div>
          <h5 class="text-white text-sm font-black uppercase tracking-wider mb-4">Contact</h5>
          <ul class="space-y-2 text-xs text-slate-500">
            <li>Phone: +880-2-9116251</li>
            <li>Email: info@bsti.gov.bd</li>
            <li>Web: www.bsti.gov.bd</li>
          </ul>
        </div>
      </div>

      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-12 mt-12 border-t border-slate-800/60 text-center text-xs text-slate-600">
        © 2026 Bangladesh Standards and Testing Institution. All rights reserved.
      </div>
    </footer>
  </div>
</template>

<script setup>
// No reactive state needed for static landing presentation
</script>
