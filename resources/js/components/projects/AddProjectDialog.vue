<template>
  <TransitionRoot appear :show="isOpen" as="template">
    <Dialog as="div" @close="closeModal" class="relative z-10">
      <TransitionChild
        as="template"
        enter="duration-300 ease-out"
        enter-from="opacity-0"
        enter-to="opacity-100"
        leave="duration-200 ease-in"
        leave-from="opacity-100"
        leave-to="opacity-0"
      >
        <div class="fixed inset-0 bg-black bg-opacity-25" />
      </TransitionChild>

      <div class="fixed inset-0 overflow-y-auto">
        <div class="flex min-h-full items-center justify-center p-4 text-center">
          <TransitionChild
            as="template"
            enter="duration-300 ease-out"
            enter-from="opacity-0 scale-95"
            enter-to="opacity-100 scale-100"
            leave="duration-200 ease-in"
            leave-from="opacity-100 scale-100"
            leave-to="opacity-0 scale-95"
          >
            <DialogPanel class="w-full max-w-2xl transform overflow-hidden rounded-2xl bg-white p-6 text-left align-middle shadow-xl transition-all">
              <DialogTitle as="h3" class="text-lg font-medium leading-6 text-gray-900">
                {{ isEditing ? 'Edit Project' : 'Add New Project' }}
              </DialogTitle>
              
              <div class="mt-6 space-y-6">
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                  <!-- Project Name -->
                  <div class="sm:col-span-2">
                    <label for="name" class="block text-sm font-medium text-gray-700">Project Name *</label>
                    <input
                      type="text"
                      id="name"
                      v-model="formData.name"
                      class="mt-1 block w-full rounded-lg border-2 border-gray-200 bg-white px-4 py-2.5 text-gray-700 placeholder-gray-400 transition-all duration-200 focus:border-purple-600 focus:outline-none focus:ring-2 focus:ring-purple-200 focus:ring-opacity-50 sm:text-sm"
                      placeholder="Enter project name"
                    />
                  </div>

                  <!-- Housing Type -->
                  <div>
                    <label for="housing_type" class="block text-sm font-medium text-gray-700">Housing Type *</label>
                    <select
                      id="housing_type"
                      v-model="formData.housing_type"
                      class="mt-1 block w-full appearance-none rounded-lg border-2 border-gray-200 bg-white px-4 py-2.5 text-gray-700 placeholder-gray-400 transition-all duration-200 focus:border-purple-600 focus:outline-none focus:ring-2 focus:ring-purple-200 focus:ring-opacity-50 sm:text-sm"
                    >
                      <option value="">Select a type</option>
                      <option value="Apartment">Apartment</option>
                      <option value="Villa">Villa</option>
                      <option value="Townhouse">Townhouse</option>
                      <option value="Duplex">Duplex</option>
                      <option value="Penthouse">Penthouse</option>
                    </select>
                  </div>


                  <!-- Number of Units -->
                  <div>
                    <label for="num_units" class="block text-sm font-medium text-gray-700">Number of Units *</label>
                    <input
                      type="number"
                      id="num_units"
                      v-model.number="formData.num_units"
                      min="1"
                      class="mt-1 block w-full rounded-lg border-2 border-gray-200 bg-white px-4 py-2.5 text-gray-700 placeholder-gray-400 transition-all duration-200 focus:border-purple-600 focus:outline-none focus:ring-2 focus:ring-purple-200 focus:ring-opacity-50 sm:text-sm"
                      placeholder="e.g. 50"
                    />
                  </div>

                  <!-- Wilaya -->
                  <div>
                    <label for="wilaya" class="block text-sm font-medium text-gray-700">Wilaya *</label>
                    <div class="relative mt-1">
                      <select
                        id="wilaya"
                        v-model="formData.wilaya"
                        class="block w-full appearance-none rounded-lg border-2 border-gray-200 bg-white px-4 py-2.5 text-gray-700 placeholder-gray-400 transition-all duration-200 focus:border-purple-600 focus:outline-none focus:ring-2 focus:ring-purple-200 focus:ring-opacity-50 sm:text-sm"
                        :disabled="isLoadingLocations"
                        @change="onWilayaChange"
                      >
                        <option value="">Sélectionner une wilaya</option>
                        <option v-for="wilaya in wilayas" :key="'w-'+wilaya" :value="wilaya">
                          {{ wilaya }}
                        </option>
                      </select>
                      <div v-if="isLoadingLocations" class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                        <svg class="animate-spin h-4 w-4 text-purple-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                          <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                          <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                      </div>
                    </div>
                  </div>
                  
                  <!-- Baladia -->
                  <div>
                    <label for="baladia" class="block text-sm font-medium text-gray-700">Commune *</label>
                    <div class="relative mt-1">
                      <select
                        id="baladia"
                        v-model="formData.baladia"
                        :disabled="!formData.wilaya || isLoadingBaladias"
                        class="block w-full appearance-none rounded-lg border-2 border-gray-200 bg-white px-4 py-2.5 text-gray-700 placeholder-gray-400 transition-all duration-200 focus:border-purple-600 focus:outline-none focus:ring-2 focus:ring-purple-200 focus:ring-opacity-50 sm:text-sm"
                        @change="onBaladiaChange"
                      >
                        <option value="">Sélectionner une commune</option>
                        <option v-for="baladia in baladias" :key="'b-'+baladia" :value="baladia">
                          {{ baladia }}
                        </option>
                      </select>
                      <div v-if="isLoadingBaladias" class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                        <svg class="animate-spin h-4 w-4 text-purple-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                          <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                          <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                      </div>
                    </div>
                  </div>
                  
                  <!-- Daira -->
                  <div>
                    <label for="daira" class="block text-sm font-medium text-gray-700">Daira</label>
                    <div class="relative mt-1">
                      <select
                        id="daira"
                        v-model="formData.daira"
                        :disabled="!formData.baladia || isLoadingDairas"
                        class="block w-full appearance-none rounded-lg border-2 border-gray-200 bg-white px-4 py-2.5 text-gray-700 placeholder-gray-400 transition-all duration-200 focus:border-purple-600 focus:outline-none focus:ring-2 focus:ring-purple-200 focus:ring-opacity-50 sm:text-sm"
                      >
                        <option value="">Sélectionner une daira</option>
                        <option v-for="daira in dairas" :key="'d-'+daira" :value="daira">
                          {{ daira }}
                        </option>
                      </select>
                      <div v-if="isLoadingDairas" class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                        <svg class="animate-spin h-4 w-4 text-purple-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                          <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                          <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                      </div>
                    </div>
                  </div>

                  <!-- Delivery Date -->
                  <div>
                    <label for="delivery_date" class="block text-sm font-medium text-gray-700">Delivery Date</label>
                    <input
                      type="date"
                      id="delivery_date"
                      v-model="formData.delivery_date"
                      class="mt-1 block w-full appearance-none rounded-lg border-2 border-gray-200 bg-white px-4 py-2.5 text-gray-700 placeholder-gray-400 transition-all duration-200 focus:border-purple-600 focus:outline-none focus:ring-2 focus:ring-purple-200 focus:ring-opacity-50 sm:text-sm"
                    />
                  </div>


                  <!-- Price -->
                  <div>
                    <label for="price" class="block text-sm font-medium text-gray-700">Price (MAD)</label>
                    <div class="relative mt-1 rounded-md shadow-sm">
                      <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                        <span class="text-gray-500 sm:text-sm">DZD</span>
                      </div>
                      <input
                        type="number"
                        id="price"
                        v-model.number="formData.price"
                        min="0"
                        step="1000"
                        class="block w-full rounded-lg border-2 border-gray-200 bg-white py-2.5 pl-14 pr-4 text-gray-700 placeholder-gray-400 transition-all duration-200 focus:border-purple-600 focus:outline-none focus:ring-2 focus:ring-purple-200 focus:ring-opacity-50 sm:text-sm"
                        placeholder="0.00"
                      />
                    </div>
                  </div>


                  <!-- Surface Area -->
                  <div>
                    <label for="surface_area" class="block text-sm font-medium text-gray-700">Surface Area (m²)</label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                      <input
                        type="number"
                        id="surface_area"
                        v-model.number="formData.surface_area"
                        min="0"
                        step="0.01"
                        class="block w-full rounded-lg border-2 border-gray-200 bg-white px-4 py-2.5 pr-12 text-gray-700 placeholder-gray-400 transition-all duration-200 focus:border-purple-600 focus:outline-none focus:ring-2 focus:ring-purple-200 focus:ring-opacity-50 sm:text-sm"
                        placeholder="0.00"
                      />
                      <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                        <span class="text-gray-500 sm:text-sm">m²</span>
                      </div>
                    </div>
                  </div>


                  <!-- Description -->
                  <div class="sm:col-span-2">
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <div class="mt-1">
                      <textarea
                        id="description"
                        v-model="formData.description"
                        rows="3"
                        class="block w-full rounded-lg border-2 border-gray-200 bg-white px-4 py-2.5 text-gray-700 placeholder-gray-400 transition-all duration-200 focus:border-purple-600 focus:outline-none focus:ring-2 focus:ring-purple-200 focus:ring-opacity-50 sm:text-sm"
                        placeholder="Enter project description"
                      ></textarea>
                    </div>
                  </div>

                  <!-- Image Upload -->
                  <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-700">Project Images</label>
                    <div class="mt-1 flex items-center">
                      <label
                        for="file-upload"
                        class="relative flex cursor-pointer items-center rounded-lg border-2 border-dashed border-gray-300 bg-white px-4 py-6 text-center transition-all duration-200 hover:border-purple-400 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-purple-200 focus:ring-opacity-50"
                      >
                        <div class="flex flex-col items-center space-y-2">
                          <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                          </svg>
                          <span class="text-sm font-medium text-purple-600">Upload images</span>
                          <span class="text-xs text-gray-500">or drag and drop</span>
                        </div>
                        <input
                          id="file-upload"
                          name="file-upload"
                          type="file"
                          class="sr-only"
                          multiple
                          @change="handleFileUpload"
                          accept="image/*"
                        />
                      </label>
                      
                    </div>
                    <p class="mt-1 text-xs text-gray-500">PNG, JPG, GIF up to 10MB</p>
                    
                    <!-- Image previews -->
                    <div v-if="previewImages.length > 0" class="mt-4">
                      <div class="text-sm font-medium text-gray-700 mb-2">Selected Images:</div>
                      <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 md:grid-cols-4">
                        <div v-for="(image, index) in previewImages" :key="index" class="relative group space-y-2">
                          <div class="relative">
                            <img :src="image.preview" class="h-24 w-full object-cover rounded-md border-2 border-gray-200" />
                            <button
                              type="button"
                              @click="removeImage(index)"
                              class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full p-1 hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2"
                            >
                              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                              </svg>
                            </button>
                          </div>
                          <input
                            type="text"
                            :value="image.caption"
                            @input="updateCaption(index, $event.target.value)"
                            class="block w-full rounded-md border-gray-200 text-xs p-1.5 focus:border-purple-500 focus:ring-purple-500"
                            placeholder="Add caption"
                          />
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Error and Success Messages -->
              <div v-if="errorMessage" class="mt-4 p-3 bg-red-50 text-red-700 rounded-md text-sm">
                {{ errorMessage }}
              </div>
              <div v-if="successMessage" class="mt-4 p-3 bg-green-50 text-green-700 rounded-md text-sm">
                {{ successMessage }}
              </div>

              <div class="mt-6 flex items-center justify-end space-x-3">
                <button
                  type="button"
                  @click="closeModal"
                  class="inline-flex justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2"
                >
                  Cancel
                </button>
                <button
                  type="button"
                  @click="submitForm"
                  :disabled="isSubmitting"
                  class="inline-flex justify-center rounded-md border border-transparent bg-purple-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed"
                >
                  <span v-if="isSubmitting">
                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                      <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                      <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Saving...
                  </span>
                  <span v-else>Save Project</span>
                </button>
              </div>
            </DialogPanel>
          </TransitionChild>
        </div>
      </div>
    </Dialog>
  </TransitionRoot>
</template>

<script setup>
import { ref, computed, watch, onMounted, nextTick } from 'vue';
import { useStore } from 'vuex';
import axios from 'axios';
import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue';
import { XMarkIcon } from '@heroicons/vue/24/outline';

const props = defineProps({
  isOpen: {
    type: Boolean,
    required: true,
  },
  project: {
    type: Object,
    default: null,
  },
});

const emit = defineEmits(['close', 'submit']);

const formData = ref({
  name: '',
  housing_type: '',
  num_units: null,
  wilaya: '',
  baladia: '',
  daira: '',
  delivery_date: '',
  price: null,
  surface_area: null,
  description: '',
  images: [],
  image_captions: []
});

const previewImages = ref([]);
const isSubmitting = ref(false);
const errorMessage = ref('');
const successMessage = ref('');

const closeModal = () => {
  emit('close');
};

const isEditing = computed(() => Boolean(props.project));

const store = useStore();

// Location data and loading states
const wilayas = ref([]);
const baladias = ref([]);
const dairas = ref([]);
const isLoadingLocations = ref(false);
const isLoadingBaladias = ref(false);
const isLoadingDairas = ref(false);
const locationError = ref(null);

const submitForm = async () => {
  // Reset messages
  errorMessage.value = '';
  successMessage.value = '';
  
  // Basic validation
  if (!formData.value.name || !formData.value.housing_type || !formData.value.num_units || !formData.value.wilaya || !formData.value.baladia || !formData.value.daira) {
    errorMessage.value = 'Veuillez remplir tous les champs obligatoires';
    return;
  }
  
  isSubmitting.value = true;
  
  try {
    const token = store.state.auth.token;
    if (!token) {
      throw new Error('Veuillez vous reconnecter');
    }
    
    const headers = {
      'Accept': 'application/json',
      'Authorization': `Bearer ${token}`,
    };
    
    let response;
    
    if (isEditing.value) {
      // For editing, use PUT with JSON data
      headers['Content-Type'] = 'application/json';
      
      // Create a clean payload without empty values
      const payload = {};
      Object.keys(formData.value).forEach(key => {
        if (formData.value[key] !== null && formData.value[key] !== undefined && formData.value[key] !== '') {
          payload[key] = formData.value[key];
        }
      });
      
      response = await axios.put(`/api/projects/${props.project.id}`, payload, { headers });
      successMessage.value = 'Projet mis à jour avec succès !';
    } else {
      // For new project, use FormData for file uploads
      const formPayload = new FormData();
      
      // Add the main project data
      Object.keys(formData.value).forEach(key => {
        if (key === 'wilaya' || key === 'baladia' || key === 'daira') {
          // Skip these as we'll add them separately
          return;
        }
        if (key !== 'images' && key !== 'image_captions') {
          formPayload.append(key, formData.value[key]);
        }
      });
      
      // Add location fields separately
      if (formData.value.wilaya) {
        formPayload.append('location[wilaya]', formData.value.wilaya);
      }
      if (formData.value.baladia) {
        formPayload.append('location[commune]', formData.value.baladia);
      }
      if (formData.value.daira) {
        formPayload.append('location[daira]', formData.value.daira);
      }
      
      // Append images and captions
      previewImages.value.forEach((file, index) => {
        if (file.file) { // Only append new files
          formPayload.append('images[]', file.file);
          const caption = file.caption || '';
          formPayload.append('captions[]', caption);
        }
      });
      
      // For POST requests, let the browser set the Content-Type with the correct boundary
      const postHeaders = { ...headers };
      delete postHeaders['Content-Type'];
      
      response = await axios.post('/api/projects', formPayload, { 
        headers: postHeaders,
      });
      
      successMessage.value = 'Projet créé avec succès !';
    }
    
    // Reset form and close dialog after a short delay
    setTimeout(() => {
      emit('submit', response.data);
      emit('close');
      resetForm();
    }, 1500);
    
  } catch (error) {
    console.error(`Error ${isEditing.value ? 'updating' : 'creating'} project:`, error);
    errorMessage.value = error.response?.data?.message || 
      `Échec de la ${isEditing.value ? 'mise à jour' : 'création'} du projet. Veuillez réessayer.`;
  } finally {
    isSubmitting.value = false;
  }
};

// Reset form to initial state
const resetForm = () => {
  formData.value = {
    name: '',
    housing_type: '',
    num_units: null,
    wilaya: '',
    baladia: '',
    daira: '',
    delivery_date: '',
    price: null,
    surface_area: null,
    description: '',
    images: [],
    image_captions: []
  };
  previewImages.value = [];
  errorMessage.value = '';
  successMessage.value = '';
};

const handleFileUpload = (event) => {
  const files = Array.from(event.target.files);
  
  files.forEach(file => {
    if (!file.type.startsWith('image/')) {
      errorMessage.value = `File ${file.name} is not an image.`;
      return;
    }
    
    if (file.size > 10 * 1024 * 1024) { // 10MB limit
      errorMessage.value = `File ${file.name} is too large. Maximum size is 10MB.`;
      return;
    }
    
    const reader = new FileReader();
    reader.onload = (e) => {
      previewImages.value.push({
        file,
        preview: e.target.result,
        caption: ''
      });
    };
    reader.readAsDataURL(file);
  });
  
  // Reset the file input to allow selecting the same file again if needed
  event.target.value = '';
};

// Update caption for an image
const updateCaption = (index, caption) => {
  if (previewImages.value[index]) {
    previewImages.value[index].caption = caption;
  }
};

const removeImage = (index) => {
  previewImages.value.splice(index, 1);
};

// Load wilayas on component mount
onMounted(() => {
  loadWilayas();
});

// Load wilayas
const loadWilayas = async () => {
  try {
    isLoadingLocations.value = true;
    locationError.value = null;
    
    const response = await axios.get('/api/locations/wilayas');
    
    if (Array.isArray(response.data)) {
      wilayas.value = response.data;
    } else {
      console.error('Unexpected response format:', response.data);
      locationError.value = 'Failed to load wilayas: Invalid data format';
    }
  } catch (error) {
    console.error('Error loading wilayas:', error);
    const errorMsg = error.response?.data?.error || error.message || 'Failed to load wilayas';
    locationError.value = errorMsg;
  } finally {
    isLoadingLocations.value = false;
  }
};

// Load baladias when wilaya is selected
const loadBaladias = async (wilaya) => {
  if (!wilaya) {
    baladias.value = [];
    dairas.value = [];
    formData.value.baladia = '';
    formData.value.daira = '';
    return;
  }
  
  try {
    isLoadingBaladias.value = true;
    locationError.value = null;
    
    const response = await axios.get(`/api/locations/baladias/${encodeURIComponent(wilaya)}`);
    
    if (Array.isArray(response.data)) {
      baladias.value = response.data;
      dairas.value = [];
      formData.value.baladia = '';
      formData.value.daira = '';
    } else {
      console.error('Unexpected response format for baladias:', response.data);
      locationError.value = 'Failed to load communes: Invalid data format';
    }
  } catch (error) {
    console.error('Error loading baladias:', error);
    const errorMsg = error.response?.data?.error || error.message || 'Failed to load communes';
    locationError.value = errorMsg;
    baladias.value = [];
    dairas.value = [];
    formData.value.baladia = '';
    formData.value.daira = '';
  } finally {
    isLoadingBaladias.value = false;
  }
};

// Load dairas when baladia is selected
const loadDairas = async (wilaya, baladia) => {
  if (!wilaya || !baladia) {
    dairas.value = [];
    formData.value.daira = '';
    return;
  }
  
  try {
    isLoadingDairas.value = true;
    locationError.value = null;
    
    const response = await axios.get(
      `/api/locations/dairas/${encodeURIComponent(wilaya)}/${encodeURIComponent(baladia)}`
    );
    
    if (Array.isArray(response.data)) {
      dairas.value = response.data;
      formData.value.daira = '';
    } else {
      console.error('Unexpected response format for dairas:', response.data);
      locationError.value = 'Failed to load dairas: Invalid data format';
    }
  } catch (error) {
    console.error('Error loading dairas:', error);
    const errorMsg = error.response?.data?.error || error.message || 'Failed to load dairas';
    locationError.value = errorMsg;
    dairas.value = [];
    formData.value.daira = '';
  } finally {
    isLoadingDairas.value = false;
  }
};

// Handle wilaya change
const onWilayaChange = () => {
  loadBaladias(formData.value.wilaya);};

// Handle baladia change
const onBaladiaChange = () => {
  loadDairas(formData.value.wilaya, formData.value.baladia);};

// Initialize form when dialog is opened or project changes
watch([() => props.isOpen, () => props.project], async ([isOpen, project]) => {
  if (isOpen) {
    if (project) {
      // Try to parse the location if it exists
      let location = {};
      if (project.location) {
        try {
          location = JSON.parse(project.location);
        } catch (e) {
          console.warn('Could not parse location:', e);
        }
      }
      
      // Populate form with project data for editing
      const { id, user_id, created_at, updated_at, images, user, location: locationStr, ...projectData } = project;
      
      formData.value = { 
        ...formData.value, 
        ...projectData,
        wilaya: location.wilaya || '',
        baladia: location.commune || '',
        daira: location.daira || ''
      };
      
      // Set preview images from existing project
      previewImages.value = (images || []).map(img => ({
        preview: img.image_path,
        caption: img.caption,
        id: img.id
      }));
      
      // Load baladias and dairas if wilaya is set
      if (formData.value.wilaya) {
        // Store the selected values before loading
        const selectedBaladia = formData.value.baladia;
        const selectedDaira = formData.value.daira;
        
        // Load baladias first
        await loadBaladias(formData.value.wilaya);
        
        // If we have a selected baladia, load its dairas and then set the daira
        if (selectedBaladia) {
          await loadDairas(formData.value.wilaya, selectedBaladia);
          
          // Set the baladia and daira after the options are loaded
          // Use $nextTick to ensure the DOM is updated with the new options
          await nextTick();
          formData.value.baladia = selectedBaladia;
          
          if (selectedDaira) {
            // Use another $nextTick to ensure baladia is set before setting daira
            await nextTick();
            formData.value.daira = selectedDaira;
          }
        }
      }
    } else {
      resetForm();
    }
  }
}, { immediate: true });
</script>
