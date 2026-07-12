<script setup>
import { ref, computed, onMounted } from 'vue';
import axios from 'axios';

const profile = ref({
  name_bn: 'jkljd',
  name_en: 'hlksdkf',
  type_bn: 'প্রোপ্রাইটরশীপ',
  type_en: 'Propritorship',

  head_division: 'Dhaka',
  head_district: 'Kishoreganj',
  head_thana: 'Austagram',
  head_post_code: '',
  head_address: 'Jvprtjlkjdf',
  head_email: '',
  head_mobile: '+880',
  head_phone: '',

  same_as_head: false,
  factory_division: '',
  factory_district: '',
  factory_thana: '',
  factory_post_code: '',
  factory_address: '',
  factory_email: '',
  factory_mobile: '+880',

  ceo_name: '',
  ceo_father_name: '',
  ceo_nationality: '',
  ceo_dob: '',
  ceo_designation: '',
  ceo_email: '',
  ceo_mobile: '+880',
  ceo_signature_path: '',
  attachments: []
});

const directors = ref([]);
const usersList = ref([
  { email: 'skd.bsti@gmail.com (Employee)', last_login: '11-07-2026' }
]);

// Lists for dropdown options
const divisions = ['Barishal', 'Chattogram', 'Dhaka', 'Khulna', 'Rajshahi', 'Rangpur', 'Mymensingh', 'Sylhet'];
const districts = ['Kishoreganj', 'Dhaka', 'Gazipur', 'Narayanganj', 'Tangail', 'Manikganj', 'Munshiganj'];
const thanas = ['Austagram', 'Kishoreganj Sadar', 'Nikli', 'Itna', 'Mithamain', 'Karimgonj', 'Bajitpur'];
const nationalities = ['Bangladeshi', 'Indian', 'American', 'British', 'Canadian', 'Japanese'];

const loading = ref(false);
const saveSuccess = ref(false);
const showDirectorModal = ref(false);
const editingDirectorIndex = ref(null);
const tempDirector = ref({ name: '', designation: '', nid_tin_passport: '', nationality: 'Bangladeshi' });

// Pagination & Search for Attachments
const attachmentSearchQuery = ref('');
const attachmentCurrentPage = ref(1);
const attachmentPerPage = 25;

const filteredAttachments = computed(() => {
  if (!profile.value.attachments) return [];
  return profile.value.attachments.filter(doc =>
    doc.name.toLowerCase().includes(attachmentSearchQuery.value.toLowerCase())
  );
});

const paginatedAttachments = computed(() => {
  const start = (attachmentCurrentPage.value - 1) * attachmentPerPage;
  const end = start + attachmentPerPage;
  return filteredAttachments.value.slice(start, end);
});

const attachmentTotalPages = computed(() => {
  return Math.ceil(filteredAttachments.value.length / attachmentPerPage);
});

// Fetch Profile from backend API
const fetchProfile = async () => {
  try {
    loading.value = true;
    const response = await axios.get('/company-profile');
    if (response.data) {
      profile.value = { ...profile.value, ...response.data };
      if (response.data.directors) {
        directors.value = response.data.directors;
      }
    }
  } catch (error) {
    console.error('Error fetching company profile:', error);
  } finally {
    loading.value = false;
  }
};

// Handle checking Same As Head Office
const handleSameAsHeadToggle = () => {
  if (profile.value.same_as_head) {
    profile.value.factory_division = profile.value.head_division;
    profile.value.factory_district = profile.value.head_district;
    profile.value.factory_thana = profile.value.head_thana;
    profile.value.factory_post_code = profile.value.head_post_code;
    profile.value.factory_address = profile.value.head_address;
    profile.value.factory_email = profile.value.head_email;
    profile.value.factory_mobile = profile.value.head_mobile;
  }
};

// Save Profile & Directors back to backend
const saveProfile = async () => {
  try {
    loading.value = true;
    saveSuccess.value = false;

    // Assemble payload
    const payload = {
      ...profile.value,
      directors: directors.value
    };

    const response = await axios.put('/company-profile', payload);
    if (response.data) {
      profile.value = { ...profile.value, ...response.data };
      if (response.data.directors) {
        directors.value = response.data.directors;
      }
      saveSuccess.value = true;
      setTimeout(() => {
        saveSuccess.value = false;
      }, 5000);
    }
  } catch (error) {
    console.error('Error saving company profile:', error);
    alert('Failed to save company profile.');
  } finally {
    loading.value = false;
  }
};

// Add / Edit Directors modal controls
const openAddDirector = () => {
  editingDirectorIndex.value = null;
  tempDirector.value = { name: '', designation: '', nid_tin_passport: '', nationality: 'Bangladeshi' };
  showDirectorModal.value = true;
};

const openEditDirector = (index) => {
  editingDirectorIndex.value = index;
  tempDirector.value = { ...directors.value[index] };
  showDirectorModal.value = true;
};

const saveDirector = () => {
  if (!tempDirector.value.name || !tempDirector.value.designation) {
    alert('Name and designation are required.');
    return;
  }

  if (editingDirectorIndex.value !== null) {
    directors.value[editingDirectorIndex.value] = { ...tempDirector.value };
  } else {
    directors.value.push({ ...tempDirector.value });
  }
  showDirectorModal.value = false;
};

const removeDirector = (index) => {
  if (confirm('Are you sure you want to remove this director?')) {
    directors.value.splice(index, 1);
  }
};

// Live Image Upload Preview
const signatureFile = ref(null);
const handleSignatureUpload = async (event) => {
  const file = event.target.files[0];
  if (!file) return;

  const formData = new FormData();
  formData.append('signature', file);

  try {
    loading.value = true;
    const response = await axios.post('/company-profile/signature', formData, {
      headers: { 'Content-Type': 'multipart/form-data' }
    });
    if (response.data && response.data.signature_path) {
      profile.value.ceo_signature_path = response.data.signature_path;
      alert('Signature uploaded successfully!');
    }
  } catch (error) {
    console.error('Signature upload error:', error);
    alert('Failed to upload signature. Ensure it is an image and under 5 MB.');
  } finally {
    loading.value = false;
  }
};

// Handle mock attachment upload & download actions
const triggerAttachmentUpload = (docId) => {
  const mockFileName = `Document_${docId}_uploaded.pdf`;
  const updatedAttachments = profile.value.attachments.map(doc => {
    if (doc.id === docId) {
      return { ...doc, uploaded: true, file_name: mockFileName };
    }
    return doc;
  });
  profile.value.attachments = updatedAttachments;
  alert('Document uploaded successfully (Mock)!');
};

const triggerAttachmentDelete = (docId) => {
  if (confirm('Delete this attachment?')) {
    const updatedAttachments = profile.value.attachments.map(doc => {
      if (doc.id === docId) {
        return { ...doc, uploaded: false, file_name: null };
      }
      return doc;
    });
    profile.value.attachments = updatedAttachments;
  }
};

onMounted(() => {
  fetchProfile();
});
</script>

<template>
  <div class="p-8 bg-slate-50 min-h-screen">
    <!-- Breadcrumb & Top Bar -->
    <div class="flex justify-between items-center mb-8">
      <div>
        <h1 class="text-3xl font-black text-slate-950 tracking-tight flex items-center gap-3">
          <i class="fas fa-id-card text-blue-600"></i>
          প্রতিষ্ঠানের প্রোফাইল
        </h1>
        <p class="text-xs text-slate-500 font-bold uppercase tracking-widest mt-1">
          Bangladesh Standards and Testing Institution (BSTI) / Company Profile
        </p>
      </div>
      <div class="text-right">
        <p class="text-xs font-black text-slate-400 uppercase tracking-widest">সর্বশেষ আপডেটের তারিখ</p>
        <p class="text-sm font-bold text-blue-600">05-06-2026</p>
      </div>
    </div>

    <!-- Alert Box for successful saves -->
    <div v-if="saveSuccess" class="mb-6 p-4 bg-emerald-100 border border-emerald-300 text-emerald-800 rounded-2xl flex items-center gap-3 shadow-sm animate-fade-in">
      <i class="fas fa-check-circle text-lg"></i>
      <span class="font-bold">কোম্পানির প্রোফাইল সফলভাবে সংরক্ষণ করা হয়েছে!</span>
    </div>

    <form @submit.prevent="saveProfile" class="space-y-8">
      <!-- Section 1: সাধারণ তথ্য (General Information) -->
      <div class="bg-white p-8 rounded-[2rem] border border-slate-100 shadow-sm">
        <h2 class="text-lg font-black text-slate-900 border-b border-slate-100 pb-4 mb-6 flex items-center gap-2">
          <span class="w-3 h-3 bg-blue-600 rounded-full"></span>
          সাধারণ তথ্য (General Info)
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">প্রতিষ্ঠানের নাম বাংলা</label>
            <input v-model="profile.name_bn" type="text" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all text-sm font-semibold" />
          </div>
          <div>
            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">প্রতিষ্ঠানের নাম ইংরেজি</label>
            <input v-model="profile.name_en" type="text" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all text-sm font-semibold" />
          </div>
          <div>
            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">প্রতিষ্ঠানের ধরণ বাংলা</label>
            <input v-model="profile.type_bn" type="text" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all text-sm font-semibold" />
          </div>
          <div>
            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">প্রতিষ্ঠানের ধরণ ইংরেজি</label>
            <input v-model="profile.type_en" type="text" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all text-sm font-semibold" />
          </div>
        </div>
      </div>

      <!-- Addresses Container -->
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Section 2: কোম্পানি/প্রতিষ্ঠানের প্রধান কার্যালয়ের ঠিকানা (Head Office) -->
        <div class="bg-white p-8 rounded-[2rem] border border-slate-100 shadow-sm flex flex-col justify-between">
          <div>
            <h2 class="text-lg font-black text-slate-900 border-b border-slate-100 pb-4 mb-6 flex items-center gap-2">
              <span class="w-3 h-3 bg-indigo-600 rounded-full"></span>
              কোম্পানি/প্রতিষ্ঠানের প্রধান কার্যালয়ের ঠিকানা (Head Office)
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">বিভাগ (Division)</label>
                <select v-model="profile.head_division" @change="handleSameAsHeadToggle" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 outline-none text-sm font-semibold">
                  <option v-for="div in divisions" :key="div" :value="div">{{ div }}</option>
                </select>
              </div>
              <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">জেলা (District)</label>
                <select v-model="profile.head_district" @change="handleSameAsHeadToggle" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 outline-none text-sm font-semibold">
                  <option v-for="dist in districts" :key="dist" :value="dist">{{ dist }}</option>
                </select>
              </div>
              <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">থানা (Thana)</label>
                <select v-model="profile.head_thana" @change="handleSameAsHeadToggle" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 outline-none text-sm font-semibold">
                  <option v-for="th in thanas" :key="th" :value="th">{{ th }}</option>
                </select>
              </div>
              <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">পোস্ট কোড</label>
                <input v-model="profile.head_post_code" @input="handleSameAsHeadToggle" type="text" placeholder="পোস্ট কোড লিখুন" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 outline-none text-sm font-semibold" />
              </div>
              <div class="md:col-span-2">
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">ঠিকানা (Address)</label>
                <textarea v-model="profile.head_address" @input="handleSameAsHeadToggle" rows="2" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 outline-none text-sm font-semibold"></textarea>
              </div>
              <div class="md:col-span-2">
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">ইমেইল</label>
                <input v-model="profile.head_email" @input="handleSameAsHeadToggle" type="text" placeholder="ইমেইল লিখুন" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 outline-none text-sm font-semibold" />
              </div>
              <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">মোবাইল নং</label>
                <input v-model="profile.head_mobile" @input="handleSameAsHeadToggle" type="text" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 outline-none text-sm font-semibold" />
              </div>
              <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">ফোন নম্বর</label>
                <input v-model="profile.head_phone" type="text" placeholder="ফোন নং লিখুন" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 outline-none text-sm font-semibold" />
              </div>
            </div>
          </div>
        </div>

        <!-- Section 3: প্রতিষ্ঠানের কারখানার ঠিকানা (Factory Address) -->
        <div class="bg-white p-8 rounded-[2rem] border border-slate-100 shadow-sm flex flex-col justify-between">
          <div>
            <div class="flex justify-between items-center border-b border-slate-100 pb-4 mb-6">
              <h2 class="text-lg font-black text-slate-900 flex items-center gap-2">
                <span class="w-3 h-3 bg-emerald-600 rounded-full"></span>
                প্রতিষ্ঠানের কারখানার ঠিকানা (Factory Address)
              </h2>
            </div>

            <div class="mb-6 p-4 bg-blue-50/50 rounded-2xl border border-blue-100 flex items-center gap-3">
              <input v-model="profile.same_as_head" @change="handleSameAsHeadToggle" type="checkbox" id="same_as_head" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500" />
              <label for="same_as_head" class="text-xs font-bold text-blue-900 select-none cursor-pointer">
                কোম্পানি/প্রতিষ্ঠানের প্রধান কার্যালয়ের ঠিকানা যদি প্রতিষ্ঠানের কারখানার ঠিকানা একই হয় তাহলে টিক দিন
              </label>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">বিভাগ (Division)</label>
                <select v-model="profile.factory_division" :disabled="profile.same_as_head" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 outline-none text-sm font-semibold disabled:bg-slate-50 disabled:text-slate-400">
                  <option value="">বিভাগ নির্বাচন করুন</option>
                  <option v-for="div in divisions" :key="div" :value="div">{{ div }}</option>
                </select>
              </div>
              <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">জেলা (District)</label>
                <select v-model="profile.factory_district" :disabled="profile.same_as_head" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 outline-none text-sm font-semibold disabled:bg-slate-50 disabled:text-slate-400">
                  <option value="">জেলা নির্বাচন করুন</option>
                  <option v-for="dist in districts" :key="dist" :value="dist">{{ dist }}</option>
                </select>
              </div>
              <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">থানা (Thana)</label>
                <select v-model="profile.factory_thana" :disabled="profile.same_as_head" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 outline-none text-sm font-semibold disabled:bg-slate-50 disabled:text-slate-400">
                  <option value="">থানা নির্বাচন করুন</option>
                  <option v-for="th in thanas" :key="th" :value="th">{{ th }}</option>
                </select>
              </div>
              <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">পোস্ট কোড</label>
                <input v-model="profile.factory_post_code" :disabled="profile.same_as_head" type="text" placeholder="পোস্ট কোড লিখুন" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 outline-none text-sm font-semibold disabled:bg-slate-50 disabled:text-slate-400" />
              </div>
              <div class="md:col-span-2">
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">ঠিকানা (Address)</label>
                <textarea v-model="profile.factory_address" :disabled="profile.same_as_head" rows="2" placeholder="ঠিকানা লিখুন" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 outline-none text-sm font-semibold disabled:bg-slate-50 disabled:text-slate-400"></textarea>
              </div>
              <div class="md:col-span-2">
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">ইমেইল</label>
                <input v-model="profile.factory_email" :disabled="profile.same_as_head" type="text" placeholder="ইমেইল লিখুন" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 outline-none text-sm font-semibold disabled:bg-slate-50 disabled:text-slate-400" />
              </div>
              <div class="md:col-span-2">
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">মোবাইল নং</label>
                <input v-model="profile.factory_mobile" :disabled="profile.same_as_head" type="text" placeholder="মোবাইল নং লিখুন" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 outline-none text-sm font-semibold disabled:bg-slate-50 disabled:text-slate-400" />
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Section 4: প্রতিষ্ঠানের উদ্যোক্তা/পরিচালকগনের তথ্য (Directors Details) -->
      <div class="bg-white p-8 rounded-[2rem] border border-slate-100 shadow-sm">
        <div class="flex justify-between items-center border-b border-slate-100 pb-4 mb-6">
          <h2 class="text-lg font-black text-slate-900 flex items-center gap-2">
            <span class="w-3 h-3 bg-purple-600 rounded-full"></span>
            প্রতিষ্ঠানের উদ্যোক্তা/পরিচালকগনের তথ্য
          </h2>
          <button type="button" @click="openAddDirector" class="px-4 py-2 bg-purple-600 text-white rounded-xl text-xs font-bold flex items-center gap-2 hover:bg-purple-700 transition">
            <i class="fas fa-plus"></i> যোগ করুন (Add)
          </button>
        </div>

        <div class="overflow-x-auto">
          <table class="w-full text-left border-collapse">
            <thead>
              <tr class="border-b border-slate-100 text-slate-400 uppercase text-[10px] font-black tracking-wider">
                <th class="py-3 px-4">নং (No)</th>
                <th class="py-3 px-4">নাম (Name)</th>
                <th class="py-3 px-4">পদবি (Designation)</th>
                <th class="py-3 px-4">NID/TIN/Passport</th>
                <th class="py-3 px-4">জাতীয়তা (Nationality)</th>
                <th class="py-3 px-4 text-right">একশন (Action)</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-slate-50 text-sm font-semibold text-slate-700">
              <tr v-for="(dir, index) in directors" :key="index" class="hover:bg-slate-50/50 transition">
                <td class="py-3 px-4">{{ index + 1 }}</td>
                <td class="py-3 px-4 text-slate-900 font-bold">{{ dir.name }}</td>
                <td class="py-3 px-4">{{ dir.designation }}</td>
                <td class="py-3 px-4"><span class="font-mono text-xs">{{ dir.nid_tin_passport || 'N/A' }}</span></td>
                <td class="py-3 px-4"><span class="px-2 py-0.5 bg-slate-100 rounded text-xs">{{ dir.nationality }}</span></td>
                <td class="py-3 px-4 text-right space-x-2">
                  <button type="button" @click="openEditDirector(index)" class="text-blue-600 hover:text-blue-800 transition">
                    <i class="fas fa-edit"></i>
                  </button>
                  <button type="button" @click="removeDirector(index)" class="text-red-500 hover:text-red-700 transition">
                    <i class="fas fa-trash"></i>
                  </button>
                </td>
              </tr>
              <tr v-if="directors.length === 0">
                <td colspan="6" class="py-6 text-center text-slate-400 text-xs font-bold">কোন তথ্য পাওয়া যায়নি (No records found)</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <!-- Section 5: কোম্পানির চেয়ারম্যান/ এমডি/ স্বত্ত্বাধিকারী/ সিইও-এর বিবরণ -->
      <div class="bg-white p-8 rounded-[2rem] border border-slate-100 shadow-sm">
        <h2 class="text-lg font-black text-slate-900 border-b border-slate-100 pb-4 mb-6 flex items-center gap-2">
          <span class="w-3 h-3 bg-amber-500 rounded-full"></span>
          কোম্পানির চেয়ারম্যান/ এমডি/ স্বত্ত্বাধিকারী/ সিইও-এর বিবরণ
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          <div>
            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">নাম (Name)</label>
            <input v-model="profile.ceo_name" type="text" placeholder="নাম লিখুন" class="w-full px-4 py-3 rounded-xl border border-slate-200 outline-none text-sm font-semibold" />
          </div>
          <div>
            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">পিতার নাম (Father's Name)</label>
            <input v-model="profile.ceo_father_name" type="text" placeholder="পিতার নাম লিখুন" class="w-full px-4 py-3 rounded-xl border border-slate-200 outline-none text-sm font-semibold" />
          </div>
          <div>
            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">জাতীয়তা (Nationality)</label>
            <select v-model="profile.ceo_nationality" class="w-full px-4 py-3 rounded-xl border border-slate-200 outline-none text-sm font-semibold">
              <option value="">নির্বাচন করুন</option>
              <option v-for="nat in nationalities" :key="nat" :value="nat">{{ nat }}</option>
            </select>
          </div>
          <div>
            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">জন্মতারিখ (Birth Date)</label>
            <input v-model="profile.ceo_dob" type="date" class="w-full px-4 py-3 rounded-xl border border-slate-200 outline-none text-sm font-semibold" />
          </div>
          <div>
            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">পদবি (Designation)</label>
            <input v-model="profile.ceo_designation" type="text" placeholder="পদবি লিখুন" class="w-full px-4 py-3 rounded-xl border border-slate-200 outline-none text-sm font-semibold" />
          </div>
          <div>
            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">ইমেইল (Email)</label>
            <input v-model="profile.ceo_email" type="text" placeholder="ইমেইল লিখুন" class="w-full px-4 py-3 rounded-xl border border-slate-200 outline-none text-sm font-semibold" />
          </div>
          <div class="md:col-span-2 lg:col-span-1">
            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">মোবাইল নং (Mobile No)</label>
            <input v-model="profile.ceo_mobile" type="text" class="w-full px-4 py-3 rounded-xl border border-slate-200 outline-none text-sm font-semibold" />
          </div>

          <!-- Live Scan/Signature Area -->
          <div class="md:col-span-2 lg:col-span-2 bg-slate-50 p-6 rounded-2xl border border-slate-100 flex flex-col md:flex-row gap-6 items-center">
            <div class="flex-grow">
              <h3 class="text-sm font-black text-slate-800 mb-1">আপনার স্ক্যান স্বাক্ষরটি এখানে আপলোড করুন বা ব্রাউজ করুন</h3>
              <p class="text-[11px] text-slate-400 font-bold mb-3">[File Format: *.jpg/ .jpeg .png | Maximum 5 MB]</p>

              <div class="flex items-center gap-3">
                <label class="px-4 py-2.5 bg-blue-600 text-white rounded-xl text-xs font-bold cursor-pointer hover:bg-blue-700 transition">
                  Browse File
                  <input type="file" @change="handleSignatureUpload" class="hidden" accept=".jpg,.jpeg,.png" />
                </label>
                <span class="text-xs font-bold text-slate-500">{{ profile.ceo_signature_path ? 'Signature_Loaded.png' : 'No file chosen' }}</span>
              </div>
              <p class="text-[11px] text-slate-400 font-bold mt-4 flex items-center gap-2">
                <i class="fas fa-info-circle text-blue-500"></i>
                প্রয়োজনীয় সকল কাগজপত্র এই স্বাক্ষরের মাধ্যমে স্বাক্ষরিত হতে হবে
              </p>
            </div>

            <div class="shrink-0 w-36 h-36 bg-white rounded-2xl border border-slate-200 flex items-center justify-center p-2 relative overflow-hidden group shadow-inner">
              <img v-if="profile.ceo_signature_path" :src="profile.ceo_signature_path" class="max-w-full max-h-full object-contain" alt="CEO Signature" />
              <div v-else class="text-slate-300 flex flex-col items-center gap-2 text-center p-2">
                <i class="fas fa-signature text-2xl"></i>
                <span class="text-[9px] font-bold uppercase tracking-wider">No Signature</span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Section 6: প্রতিষ্ঠানের প্রয়োজনীয় সংযুক্তি সমুহ (Required Attachments) -->
      <div class="bg-white p-8 rounded-[2rem] border border-slate-100 shadow-sm">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-slate-100 pb-6 mb-6">
          <h2 class="text-lg font-black text-slate-900 flex items-center gap-2">
            <span class="w-3 h-3 bg-blue-500 rounded-full"></span>
            প্রতিষ্ঠানের প্রয়োজনীয় সংযুক্তি সমুহ (Required Attachments)
          </h2>
          <div class="flex flex-col md:flex-row gap-3 items-stretch md:items-center">
            <!-- Search -->
            <div class="relative">
              <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
              <input v-model="attachmentSearchQuery" type="text" placeholder="Search attachment..." class="pl-10 pr-4 py-2 rounded-xl border border-slate-200 text-xs font-bold outline-none focus:border-blue-500 w-64" />
            </div>
          </div>
        </div>

        <div class="overflow-x-auto">
          <table class="w-full text-left border-collapse">
            <thead>
              <tr class="border-b border-slate-100 text-slate-400 uppercase text-[10px] font-black tracking-wider">
                <th class="py-3 px-4 w-16">#</th>
                <th class="py-3 px-4">Doc Name</th>
                <th class="py-3 px-4 text-right">Action</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-slate-50 text-sm font-semibold text-slate-700">
              <tr v-for="doc in paginatedAttachments" :key="doc.id" class="hover:bg-slate-50/50 transition">
                <td class="py-3.5 px-4 font-mono text-xs">{{ doc.id }}</td>
                <td class="py-3.5 px-4 text-slate-900 font-bold flex items-center gap-3">
                  <i class="fas text-xs" :class="doc.uploaded ? 'fa-file-pdf text-red-500' : 'fa-file text-slate-300'"></i>
                  {{ doc.name }}
                  <span v-if="doc.uploaded" class="text-[9px] font-bold bg-green-50 text-green-600 px-2 py-0.5 rounded border border-green-100 uppercase tracking-widest">Uploaded</span>
                </td>
                <td class="py-3.5 px-4 text-right space-x-2">
                  <button v-if="!doc.uploaded" type="button" @click="triggerAttachmentUpload(doc.id)" class="px-3 py-1 bg-blue-50 text-blue-600 rounded-lg text-xs font-bold hover:bg-blue-100 transition">
                    Upload
                  </button>
                  <div v-else class="inline-flex gap-2 justify-end">
                    <button type="button" class="px-3 py-1 bg-slate-50 text-slate-600 rounded-lg text-xs font-bold hover:bg-slate-100 transition">
                      Download
                    </button>
                    <button type="button" @click="triggerAttachmentDelete(doc.id)" class="px-3 py-1 bg-red-50 text-red-600 rounded-lg text-xs font-bold hover:bg-red-100 transition">
                      Delete
                    </button>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Pagination Footer for Attachments -->
        <div class="flex justify-between items-center mt-6 border-t border-slate-50 pt-6">
          <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">
            Showing {{ (attachmentCurrentPage - 1) * attachmentPerPage + 1 }} to {{ Math.min(attachmentCurrentPage * attachmentPerPage, filteredAttachments.length) }} of {{ filteredAttachments.length }} entries
          </p>
          <div class="flex items-center gap-2">
            <button
              type="button"
              :disabled="attachmentCurrentPage === 1"
              @click="attachmentCurrentPage--"
              class="px-3 py-1.5 rounded-lg border border-slate-100 bg-white text-xs font-bold text-slate-600 hover:bg-slate-50 disabled:opacity-50 transition"
            >
              Previous
            </button>
            <button
              v-for="page in attachmentTotalPages"
              :key="page"
              type="button"
              @click="attachmentCurrentPage = page"
              :class="attachmentCurrentPage === page ? 'bg-blue-600 text-white border-blue-600' : 'bg-white text-slate-600 border-slate-100 hover:bg-slate-50'"
              class="px-3 py-1.5 rounded-lg border text-xs font-bold transition"
            >
              {{ page }}
            </button>
            <button
              type="button"
              :disabled="attachmentCurrentPage === attachmentTotalPages"
              @click="attachmentCurrentPage++"
              class="px-3 py-1.5 rounded-lg border border-slate-100 bg-white text-xs font-bold text-slate-600 hover:bg-slate-50 disabled:opacity-50 transition"
            >
              Next
            </button>
          </div>
        </div>
      </div>

      <!-- Section 7: ব্যবহারকারী (Users) -->
      <div class="bg-white p-8 rounded-[2rem] border border-slate-100 shadow-sm">
        <h2 class="text-lg font-black text-slate-900 border-b border-slate-100 pb-4 mb-6 flex items-center gap-2">
          <span class="w-3 h-3 bg-teal-500 rounded-full"></span>
          ব্যবহারকারী (Users List)
        </h2>
        <div class="overflow-x-auto">
          <table class="w-full text-left border-collapse">
            <thead>
              <tr class="border-b border-slate-100 text-slate-400 uppercase text-[10px] font-black tracking-wider">
                <th class="py-3 px-4">ইউজার ইমেইল (User Email)</th>
                <th class="py-3 px-4">সর্বশেষ লগ ইন (Last Log In)</th>
                <th class="py-3 px-4 text-right">একশন (Action)</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-slate-50 text-sm font-semibold text-slate-700">
              <tr v-for="user in usersList" :key="user.email" class="hover:bg-slate-50/50 transition">
                <td class="py-3.5 px-4 text-slate-900 font-bold flex items-center gap-2">
                  <i class="fas fa-user-circle text-slate-400 text-base"></i>
                  {{ user.email }}
                </td>
                <td class="py-3.5 px-4 text-slate-500">{{ user.last_login }}</td>
                <td class="py-3.5 px-4 text-right">
                  <button type="button" class="px-3 py-1 bg-slate-50 text-slate-600 rounded-lg text-xs font-bold hover:bg-slate-100 transition">
                    View Logs
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <!-- Action Footer -->
      <div class="flex justify-end gap-4 bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
        <button type="button" @click="fetchProfile" class="px-6 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-bold transition">
          Reset Changes
        </button>
        <button type="submit" :disabled="loading" class="px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold transition flex items-center gap-2 disabled:opacity-50">
          <i v-if="loading" class="fas fa-spinner animate-spin"></i>
          {{ loading ? 'Saving...' : 'সংরক্ষণ করুন (Save Profile)' }}
        </button>
      </div>
    </form>

    <!-- Add/Edit Director Modal -->
    <div v-if="showDirectorModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4 z-50">
      <div class="bg-white rounded-[2.5rem] w-full max-w-lg p-8 border border-slate-100 shadow-2xl relative animate-scale-in">
        <button @click="showDirectorModal = false" class="absolute top-6 right-6 text-slate-400 hover:text-slate-600 transition">
          <i class="fas fa-times text-lg"></i>
        </button>
        <h3 class="text-xl font-black text-slate-900 tracking-tight mb-6">
          {{ editingDirectorIndex !== null ? 'সম্পাদনা করুন (Edit Director)' : 'নতুন পরিচালক যোগ করুন (Add Director)' }}
        </h3>

        <div class="space-y-4">
          <div>
            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">নাম (Name)</label>
            <input v-model="tempDirector.name" type="text" class="w-full px-4 py-3 rounded-xl border border-slate-200 outline-none text-sm font-semibold" />
          </div>
          <div>
            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">পদবি (Designation)</label>
            <input v-model="tempDirector.designation" type="text" class="w-full px-4 py-3 rounded-xl border border-slate-200 outline-none text-sm font-semibold" />
          </div>
          <div>
            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">NID / TIN / Passport</label>
            <input v-model="tempDirector.nid_tin_passport" type="text" class="w-full px-4 py-3 rounded-xl border border-slate-200 outline-none text-sm font-semibold" />
          </div>
          <div>
            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">জাতীয়তা (Nationality)</label>
            <select v-model="tempDirector.nationality" class="w-full px-4 py-3 rounded-xl border border-slate-200 outline-none text-sm font-semibold">
              <option v-for="nat in nationalities" :key="nat" :value="nat">{{ nat }}</option>
            </select>
          </div>
        </div>

        <div class="flex justify-end gap-3 mt-8">
          <button @click="showDirectorModal = false" class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-bold transition">
            বাতিল (Cancel)
          </button>
          <button @click="saveDirector" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold transition">
            সংরক্ষণ (Save)
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
.animate-fade-in {
  animation: fadeIn 0.3s cubic-bezier(0.16, 1, 0.3, 1) forwards;
}
.animate-scale-in {
  animation: scaleIn 0.35s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
}
@keyframes fadeIn {
  from { opacity: 0; transform: translateY(-10px); }
  to { opacity: 1; transform: translateY(0); }
}
@keyframes scaleIn {
  from { opacity: 0; transform: scale(0.95); }
  to { opacity: 1; transform: scale(1); }
}
</style>
