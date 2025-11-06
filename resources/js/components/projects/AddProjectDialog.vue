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
                {{ isEditing ? 'Modifier le projet' : 'Ajouter un nouveau projet' }}
              </DialogTitle>
              
              <div class="mt-6 space-y-6">
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                  <!-- Project Name -->
                  <div class="sm:col-span-2">
                    <label for="name" class="block text-sm font-medium text-gray-700">Nom du projet *</label>
                    <input
                      type="text"
                      id="name"
                      v-model="formData.name"
                      class="mt-1 block w-full rounded-lg border-2 border-gray-200 bg-white px-4 py-2.5 text-gray-700 placeholder-gray-400 transition-all duration-200 focus:border-purple-600 focus:outline-none focus:ring-2 focus:ring-purple-200 focus:ring-opacity-50 sm:text-sm"
                      placeholder="Entrez le nom du projet"
                    />
                  </div>

                  <!-- Apartment sub-types counters (F1 - F4) -->
                  <div v-if="formData.housing_type === 'Apartment'" class="sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-3">Types d'appartements</label>
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                      <div class="flex items-center justify-between rounded-lg border-2 border-gray-200 bg-white px-4 py-2.5">
                        <span class="text-sm font-medium text-gray-700">F1</span>
                        <div class="flex items-center space-x-2">
                          <button type="button" @click="adjustApartmentCount('f1_count', -1)" class="h-8 w-8 rounded-md border border-gray-300 text-gray-700 hover:bg-gray-50">-</button>
                          <span class="w-8 text-center text-sm font-semibold">{{ formData.f1_count }}</span>
                          <button type="button" @click="adjustApartmentCount('f1_count', 1)" class="h-8 w-8 rounded-md border border-gray-300 text-gray-700 hover:bg-gray-50">+</button>
                        </div>
                      </div>
                      <div class="flex items-center justify-between rounded-lg border-2 border-gray-200 bg-white px-4 py-2.5">
                        <span class="text-sm font-medium text-gray-700">F2</span>
                        <div class="flex items-center space-x-2">
                          <button type="button" @click="adjustApartmentCount('f2_count', -1)" class="h-8 w-8 rounded-md border border-gray-300 text-gray-700 hover:bg-gray-50">-</button>
                          <span class="w-8 text-center text-sm font-semibold">{{ formData.f2_count }}</span>
                          <button type="button" @click="adjustApartmentCount('f2_count', 1)" class="h-8 w-8 rounded-md border border-gray-300 text-gray-700 hover:bg-gray-50">+</button>
                        </div>
                      </div>
                      <div class="flex items-center justify-between rounded-lg border-2 border-gray-200 bg-white px-4 py-2.5">
                        <span class="text-sm font-medium text-gray-700">F3</span>
                        <div class="flex items-center space-x-2">
                          <button type="button" @click="adjustApartmentCount('f3_count', -1)" class="h-8 w-8 rounded-md border border-gray-300 text-gray-700 hover:bg-gray-50">-</button>
                          <span class="w-8 text-center text-sm font-semibold">{{ formData.f3_count }}</span>
                          <button type="button" @click="adjustApartmentCount('f3_count', 1)" class="h-8 w-8 rounded-md border border-gray-300 text-gray-700 hover:bg-gray-50">+</button>
                        </div>
                      </div>
                      <div class="flex items-center justify-between rounded-lg border-2 border-gray-200 bg-white px-4 py-2.5">
                        <span class="text-sm font-medium text-gray-700">F4</span>
                        <div class="flex items-center space-x-2">
                          <button type="button" @click="adjustApartmentCount('f4_count', -1)" class="h-8 w-8 rounded-md border border-gray-300 text-gray-700 hover:bg-gray-50">-</button>
                          <span class="w-8 text-center text-sm font-semibold">{{ formData.f4_count }}</span>
                          <button type="button" @click="adjustApartmentCount('f4_count', 1)" class="h-8 w-8 rounded-md border border-gray-300 text-gray-700 hover:bg-gray-50">+</button>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Count field for non-Apartment housing types -->
                  <div v-if="formData.housing_type && formData.housing_type !== 'Apartment'" class="sm:col-span-2">
                    <label for="num_units" class="block text-sm font-medium text-gray-700">Nombre d'unités</label>
                    <div class="mt-1 flex items-center space-x-2">
                      <button 
                        type="button" 
                        @click="adjustCount('num_units', -1)" 
                        class="h-10 w-10 rounded-lg border-2 border-gray-300 text-gray-700 hover:bg-gray-50 flex items-center justify-center"
                      >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                        </svg>
                      </button>
                      <input
                        type="number"
                        id="num_units"
                        v-model.number="formData.num_units"
                        min="0"
                        class="flex-1 rounded-lg border-2 border-gray-200 bg-white px-4 py-2.5 text-center text-gray-700 transition-all duration-200 focus:border-purple-600 focus:outline-none focus:ring-2 focus:ring-purple-200 focus:ring-opacity-50 sm:text-sm"
                        placeholder="0"
                      />
                      <button 
                        type="button" 
                        @click="adjustCount('num_units', 1)" 
                        class="h-10 w-10 rounded-lg border-2 border-gray-300 text-gray-700 hover:bg-gray-50 flex items-center justify-center"
                      >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                      </button>
                    </div>
                  </div>

                  <!-- Housing Type -->
                  <div>
                    <div class="flex items-center justify-between">
                      <label for="housing_type" class="block text-sm font-medium text-gray-700">Type de bien *</label>
                      <button type="button" @click="addAdditionalHousingType" class="inline-flex items-center rounded-md border border-gray-300 bg-white px-2 py-1 text-xs font-medium text-gray-700 shadow-sm hover:bg-gray-50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v12m6-6H6" />
                        </svg>
                        Ajouter un type
                      </button>
                    </div>
                    <select
                      id="housing_type"
                      v-model="formData.housing_type"
                      class="mt-1 block w-full appearance-none rounded-lg border-2 border-gray-200 bg-white px-4 py-2.5 text-gray-700 placeholder-gray-400 transition-all duration-200 focus:border-purple-600 focus:outline-none focus:ring-2 focus:ring-purple-200 focus:ring-opacity-50 sm:text-sm"
                    >
                      <option value="">Sélectionner un type</option>
                      <option value="Apartment">Appartement</option>
                      <option value="Villa">Villa</option>
                      <option value="Townhouse">Maison de ville</option>
                      <option value="Duplex">Duplex</option>
                      <option value="Penthouse">Penthouse</option>
                    </select>
                    <div v-if="formData.additional_housing_types && formData.additional_housing_types.length" class="mt-3 space-y-3">
                      <div v-for="(item, idx) in formData.additional_housing_types" :key="`add-type-${idx}`" class="space-y-2">
                        <div class="flex items-center space-x-2">
                          <select
                            v-model="formData.additional_housing_types[idx].type"
                            class="block flex-1 appearance-none rounded-lg border-2 border-gray-200 bg-white px-4 py-2.5 text-gray-700 placeholder-gray-400 transition-all duration-200 focus:border-purple-600 focus:outline-none focus:ring-2 focus:ring-purple-200 focus:ring-opacity-50 sm:text-sm"
                          >
                            <option value="">Sélectionner un type</option>
                            <option value="Apartment">Appartement</option>
                            <option value="Villa">Villa</option>
                            <option value="Townhouse">Maison de ville</option>
                            <option value="Duplex">Duplex</option>
                            <option value="Penthouse">Penthouse</option>
                          </select>
                          <button type="button" @click="removeAdditionalHousingType(idx)" class="inline-flex items-center rounded-md border border-gray-300 bg-white px-2 py-2 text-xs font-medium text-gray-700 shadow-sm hover:bg-gray-50" title="Supprimer">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                          </button>
                        </div>
                        <!-- Count field for non-Apartment additional housing types -->
                        <div v-if="formData.additional_housing_types[idx].type && formData.additional_housing_types[idx].type !== 'Apartment'" class="flex items-center space-x-2 ml-0">
                          <label class="text-sm font-medium text-gray-700 w-32 flex-shrink-0">Nombre d'unités:</label>
                          <button 
                            type="button" 
                            @click.stop="adjustAdditionalCount(idx, -1)" 
                            class="h-10 w-10 rounded-lg border-2 border-gray-300 text-gray-700 hover:bg-gray-50 flex items-center justify-center flex-shrink-0 relative z-10"
                          >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                            </svg>
                          </button>
                          <input
                            type="number"
                            v-model.number="formData.additional_housing_types[idx].count"
                            min="0"
                            class="flex-1 rounded-lg border-2 border-gray-200 bg-white px-4 py-2.5 text-center text-gray-700 transition-all duration-200 focus:border-purple-600 focus:outline-none focus:ring-2 focus:ring-purple-200 focus:ring-opacity-50 sm:text-sm"
                            placeholder="0"
                          />
                          <button 
                            type="button" 
                            @click.stop="adjustAdditionalCount(idx, 1)" 
                            class="h-10 w-10 rounded-lg border-2 border-gray-300 text-gray-700 hover:bg-gray-50 flex items-center justify-center flex-shrink-0 relative z-10"
                          >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                          </button>
                        </div>
                      </div>
                    </div>
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
                    <label for="delivery_date" class="block text-sm font-medium text-gray-700">Date de livraison</label>
                    <input
                      type="date"
                      id="delivery_date"
                      v-model="formData.delivery_date"
                      class="mt-1 block w-full appearance-none rounded-lg border-2 border-gray-200 bg-white px-4 py-2.5 text-gray-700 placeholder-gray-400 transition-all duration-200 focus:border-purple-600 focus:outline-none focus:ring-2 focus:ring-purple-200 focus:ring-opacity-50 sm:text-sm"
                    />
                  </div>

                  <!-- Surface Area -->
                  <div>
                    <label for="surface_area" class="block text-sm font-medium text-gray-700">Superficie (m²)</label>
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

                  <!-- Bedrooms -->
                  <div>
                    <label for="bedrooms" class="block text-sm font-medium text-gray-700">Chambres</label>
                    <input
                      type="text"
                      id="bedrooms"
                      v-model="formData.bedrooms"
                      class="mt-1 block w-full rounded-lg border-2 border-gray-200 bg-white px-4 py-2.5 text-gray-700 placeholder-gray-400 transition-all duration-200 focus:border-purple-600 focus:outline-none focus:ring-2 focus:ring-purple-200 focus:ring-opacity-50 sm:text-sm"
                      placeholder="ex. 2, 3, studio"
                    />
                  </div>

                  <!-- Bathrooms -->
                  <div>
                    <label for="bathrooms" class="block text-sm font-medium text-gray-700">Salles de bain</label>
                    <input
                      type="number"
                      id="bathrooms"
                      v-model.number="formData.bathrooms"
                      min="0"
                      step="0.5"
                      class="mt-1 block w-full rounded-lg border-2 border-gray-200 bg-white px-4 py-2.5 text-gray-700 placeholder-gray-400 transition-all duration-200 focus:border-purple-600 focus:outline-none focus:ring-2 focus:ring-purple-200 focus:ring-opacity-50 sm:text-sm"
                      placeholder="ex. 1, 1.5, 2"
                    />
                  </div>

                  <!-- Rent or Buy -->
                  <div>
                    <label for="rent_or_buy" class="block text-sm font-medium text-gray-700">Type de transaction</label>
                    <select
                      id="rent_or_buy"
                      v-model="formData.rent_or_buy"
                      class="mt-1 block w-full appearance-none rounded-lg border-2 border-gray-200 bg-white px-4 py-2.5 text-gray-700 placeholder-gray-400 transition-all duration-200 focus:border-purple-600 focus:outline-none focus:ring-2 focus:ring-purple-200 focus:ring-opacity-50 sm:text-sm"
                    >
                      <option value="">Sélectionner un type</option>
                      <option value="rent">À louer</option>
                      <option value="buy">À vendre</option>
                    </select>
                  </div>

                  <!-- Project Timeline -->
                  <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-3">Calendrier du projet</label>
                    
                    <!-- Project Announcement -->
                    <div class="mb-4">
                      <div class="flex items-center space-x-4">
                        <div class="flex-1">
                          <label class="block text-sm font-medium text-gray-600 mb-2">Annonce du projet</label>
                          <select
                            v-model="projectTimeline.announcement"
                            @change="onAnnouncementChange"
                            class="block w-full rounded-lg border-2 border-gray-200 bg-white px-4 py-2.5 text-gray-700 transition-all duration-200 focus:border-purple-600 focus:outline-none focus:ring-2 focus:ring-purple-200 focus:ring-opacity-50 sm:text-sm"
                          >
                            <option value="">Sélectionner un statut</option>
                            <option value="announced">Annoncé</option>
                            <option value="coming_soon">Bientôt disponible</option>
                          </select>
                        </div>
                        <div class="flex-1">
                          <label class="block text-sm font-medium text-gray-600 mb-2">Date d'annonce</label>
                          <input
                            type="date"
                            v-model="projectTimeline.announcementDate"
                            :disabled="projectTimeline.announcement === 'coming_soon'"
                            :class="[
                              'block w-full rounded-lg border-2 px-4 py-2.5 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-opacity-50 sm:text-sm',
                              projectTimeline.announcement === 'coming_soon' 
                                ? 'border-gray-200 bg-gray-100 text-gray-400 cursor-not-allowed' 
                                : 'border-gray-200 bg-white text-gray-700 focus:border-purple-600 focus:ring-purple-200'
                            ]"
                          />
                        </div>
                      </div>
                    </div>

                    <!-- Construction Started -->
                    <div class="mb-4">
                      <div class="flex items-center space-x-4">
                        <div class="flex-1">
                          <label class="block text-sm font-medium text-gray-600 mb-2">Statut de construction</label>
                          <select
                            v-model="projectTimeline.construction"
                            @change="onConstructionChange"
                            class="block w-full rounded-lg border-2 border-gray-200 bg-white px-4 py-2.5 text-gray-700 transition-all duration-200 focus:border-purple-600 focus:outline-none focus:ring-2 focus:ring-purple-200 focus:ring-opacity-50 sm:text-sm"
                          >
                            <option value="">Sélectionner un statut</option>
                            <option value="started">Commencé</option>
                            <option value="not_started">Pas commencé</option>
                          </select>
                        </div>
                        <div class="flex-1">
                          <label class="block text-sm font-medium text-gray-600 mb-2">Date de début de construction</label>
                          <input
                            type="date"
                            v-model="projectTimeline.constructionStartDate"
                            :disabled="projectTimeline.construction === 'not_started'"
                            :class="[
                              'block w-full rounded-lg border-2 px-4 py-2.5 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-opacity-50 sm:text-sm',
                              projectTimeline.construction === 'not_started' 
                                ? 'border-gray-200 bg-gray-100 text-gray-400 cursor-not-allowed' 
                                : 'border-gray-200 bg-white text-gray-700 focus:border-purple-600 focus:ring-purple-200'
                            ]"
                          />
                        </div>
                      </div>
                    </div>

                    <!-- Expected Completion -->
                    <div class="mb-4">
                      <div class="flex items-center space-x-4">
                        <div class="flex-1">
                          <label class="block text-sm font-medium text-gray-600 mb-2">Achèvement prévu</label>
                          <div class="flex items-center h-10 px-4 py-2.5 bg-gray-100 rounded-lg border-2 border-gray-200 text-gray-500">
                            <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Date d'achèvement du projet
                          </div>
                        </div>
                        <div class="flex-1">
                          <label class="block text-sm font-medium text-gray-600 mb-2">Date d'achèvement</label>
                          <input
                            type="date"
                            v-model="projectTimeline.completionDate"
                            class="block w-full rounded-lg border-2 border-gray-200 bg-white px-4 py-2.5 text-gray-700 transition-all duration-200 focus:border-purple-600 focus:outline-none focus:ring-2 focus:ring-purple-200 focus:ring-opacity-50 sm:text-sm"
                          />
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Payment Plan -->
                  <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-3">Plan de paiement</label>
                    
                    <!-- Payment Method -->
                    <div class="mb-4">
                      <label class="block text-sm font-medium text-gray-600 mb-2">Méthode de paiement</label>
                      <select
                        v-model="paymentPlan.paymentMethod"
                        class="block w-full rounded-lg border-2 border-gray-200 bg-white px-4 py-2.5 text-gray-700 transition-all duration-200 focus:border-purple-600 focus:outline-none focus:ring-2 focus:ring-purple-200 focus:ring-opacity-50 sm:text-sm"
                      >
                        <option value="">Sélectionner une méthode de paiement</option>
                        <option value="cash">Espèces</option>
                        <option value="bank">Bancaire</option>
                      </select>
                    </div>

                    <!-- Cash Amount Field -->
                    <div v-if="paymentPlan.paymentMethod === 'cash'" class="mb-4">
                      <label class="block text-sm font-medium text-gray-600 mb-2">Montant (DZD)</label>
                      <div class="relative rounded-md shadow-sm">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                          <span class="text-gray-500 sm:text-sm">DZD</span>
                        </div>
                        <input
                          type="number"
                          v-model.number="paymentPlan.cashAmount"
                          min="0"
                          step="1000"
                          class="block w-full rounded-lg border-2 border-gray-200 bg-white py-2.5 pl-14 pr-4 text-gray-700 placeholder-gray-400 transition-all duration-200 focus:border-purple-600 focus:outline-none focus:ring-2 focus:ring-purple-200 focus:ring-opacity-50 sm:text-sm"
                          placeholder="0.00"
                        />
                      </div>
                    </div>

                    <!-- Bank Fields -->
                    <div v-if="paymentPlan.paymentMethod === 'bank'" class="space-y-4">
                      <div>
                        <label class="block text-sm font-medium text-gray-600 mb-2">Montant total (DZD)</label>
                        <div class="relative rounded-md shadow-sm">
                          <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                            <span class="text-gray-500 sm:text-sm">DZD</span>
                          </div>
                          <input
                            type="number"
                            v-model.number="paymentPlan.bankFullAmount"
                            min="0"
                            step="1000"
                            class="block w-full rounded-lg border-2 border-gray-200 bg-white py-2.5 pl-14 pr-4 text-gray-700 placeholder-gray-400 transition-all duration-200 focus:border-purple-600 focus:outline-none focus:ring-2 focus:ring-purple-200 focus:ring-opacity-50 sm:text-sm"
                            placeholder="0.00"
                          />
                        </div>
                      </div>
                      <div>
                        <label class="block text-sm font-medium text-gray-600 mb-2">Acompte (DZD)</label>
                        <div class="relative rounded-md shadow-sm">
                          <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                            <span class="text-gray-500 sm:text-sm">DZD</span>
                          </div>
                          <input
                            type="number"
                            v-model.number="paymentPlan.bankDownPayment"
                            min="0"
                            step="1000"
                            class="block w-full rounded-lg border-2 border-gray-200 bg-white py-2.5 pl-14 pr-4 text-gray-700 placeholder-gray-400 transition-all duration-200 focus:border-purple-600 focus:outline-none focus:ring-2 focus:ring-purple-200 focus:ring-opacity-50 sm:text-sm"
                            placeholder="0.00"
                          />
                        </div>
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
                        placeholder="Entrez la description du projet"
                      ></textarea>
                    </div>
                  </div>

                  <!-- Image Upload -->
                  <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-700">
                      Images du projet 
                      <span class="text-gray-500 font-normal">({{ previewImages.length }}/10)</span>
                    </label>
                    <div class="mt-1 flex items-center">
                      <label
                        for="file-upload"
                        :class="[
                          'relative flex cursor-pointer items-center rounded-lg border-2 border-dashed px-4 py-6 text-center transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-purple-200 focus:ring-opacity-50',
                          previewImages.length >= 10 
                            ? 'border-gray-200 bg-gray-100 cursor-not-allowed opacity-50' 
                            : 'border-gray-300 bg-white hover:border-purple-400 hover:bg-gray-50'
                        ]"
                      >
                        <div class="flex flex-col items-center space-y-2">
                          <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                          </svg>
                          <span :class="previewImages.length >= 10 ? 'text-sm font-medium text-gray-400' : 'text-sm font-medium text-purple-600'">
                            {{ previewImages.length >= 10 ? 'Maximum de 10 images atteint' : 'Télécharger des images' }}
                          </span>
                          <span class="text-xs text-gray-500">ou glisser-déposer</span>
                        </div>
                        <input
                          id="file-upload"
                          name="file-upload"
                          type="file"
                          class="sr-only"
                          multiple
                          :disabled="previewImages.length >= 10"
                          @change="handleFileUpload"
                          accept="image/*"
                        />
                      </label>
                      
                    </div>
                    <p class="mt-1 text-xs text-gray-500">
                      PNG, JPG, GIF jusqu'à 10 Mo chacun. Maximum 10 images autorisées.
                      <span v-if="previewImages.length >= 10" class="text-red-600 font-medium"> (Limite atteinte)</span>
                    </p>
                    
                    <!-- Image previews -->
                    <div v-if="previewImages.length > 0" class="mt-4">
                      <div class="text-sm font-medium text-gray-700 mb-2">Images sélectionnées :</div>
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
                            placeholder="Ajouter une légende"
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
                  Annuler
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
                    Enregistrement...
                  </span>
                  <span v-else>{{ isEditing ? 'Enregistrer les modifications' : 'Enregistrer le projet' }}</span>
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
  wilaya: '',
  baladia: '',
  daira: '',
  delivery_date: '',
  price: null,
  surface_area: null,
  bedrooms: '',
  bathrooms: null,
  rent_or_buy: '',
  payment_plan_text: '',
  project_timeline_text: '',
  description: '',
  images: [],
  image_captions: [],
  additional_housing_types: [],
  f1_count: 0,
  f2_count: 0,
  f3_count: 0,
  f4_count: 0,
  num_units: null
});

const paymentPlan = ref({
  paymentMethod: '',
  cashAmount: null,
  bankFullAmount: null,
  bankDownPayment: null
});

const projectTimeline = ref({
  announcement: '',
  announcementDate: '',
  construction: '',
  constructionStartDate: '',
  completionDate: ''
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
  if (!formData.value.name || !formData.value.housing_type || !formData.value.wilaya || !formData.value.baladia || !formData.value.daira) {
    errorMessage.value = 'Veuillez remplir tous les champs obligatoires';
    return;
  }
  
  // Payment plan validation
  if (paymentPlan.value.paymentMethod === 'cash' && !paymentPlan.value.cashAmount) {
    errorMessage.value = 'Veuillez entrer le montant pour le paiement en espèces';
    return;
  }
  if (paymentPlan.value.paymentMethod === 'bank' && (!paymentPlan.value.bankFullAmount || !paymentPlan.value.bankDownPayment)) {
    errorMessage.value = 'Veuillez remplir le montant total et l\'acompte pour le paiement bancaire';
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
      // Check if there are new images to upload
      const hasNewImages = previewImages.value.some(img => img.file);
      
      if (hasNewImages) {
        // For updates with images, use FormData
        const formPayload = new FormData();
        
        // Add the main project data
        Object.keys(formData.value).forEach(key => {
          if (key === 'wilaya' || key === 'baladia' || key === 'daira') {
            // Skip these as we'll add them separately
            return;
          }
          if (key === 'payment_plan_text') {
            // Only send payment plan if payment method is selected
            if (paymentPlan.value.paymentMethod) {
              const paymentPlanData = {
                paymentMethod: paymentPlan.value.paymentMethod,
                cashAmount: paymentPlan.value.cashAmount || null,
                bankFullAmount: paymentPlan.value.bankFullAmount || null,
                bankDownPayment: paymentPlan.value.bankDownPayment || null,
                created_at: new Date().toISOString()
              };
              formPayload.append('payment_plan', JSON.stringify(paymentPlanData));
            }
            return;
          }
          if (key === 'project_timeline_text') {
            // Convert project timeline structure to JSON
            const timelineData = {
              announcement: projectTimeline.value.announcement,
              announcementDate: projectTimeline.value.announcementDate,
              construction: projectTimeline.value.construction,
              constructionStartDate: projectTimeline.value.constructionStartDate,
              completionDate: projectTimeline.value.completionDate,
              created_at: new Date().toISOString()
            };
            formPayload.append('project_timeline', JSON.stringify(timelineData));
            return;
          }
          if (key === 'additional_housing_types') {
            if (Array.isArray(formData.value.additional_housing_types) && formData.value.additional_housing_types.length > 0) {
              // Filter out items with empty type and format as objects with type and count
              const filtered = formData.value.additional_housing_types
                .filter(item => item && (typeof item === 'string' ? item : item.type))
                .map(item => {
                  // Handle backward compatibility: if it's a string, convert to object
                  if (typeof item === 'string') {
                    return { type: item, count: null };
                  }
                  return { type: item.type, count: item.count || null };
                });
              if (filtered.length > 0) {
                formPayload.append('additional_housing_types', JSON.stringify(filtered));
              }
            }
            return;
          }
          // Skip price since it's removed from the form
          if (key === 'price') {
            return;
          }
          // Skip images as we'll add them separately
          if (key === 'images' || key === 'image_captions') {
            return;
          }
          // Only append non-null, non-undefined, and non-empty values
          const value = formData.value[key];
          if (value !== null && value !== undefined && value !== '') {
            formPayload.append(key, value);
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
        
        // Append only new images (those with file property)
        previewImages.value.forEach((file, index) => {
          if (file.file) { // Only append new files
            formPayload.append('images[]', file.file);
            const caption = file.caption || '';
            formPayload.append('captions[]', caption);
          }
        });
        
        // For PUT requests with FormData, use POST with _method=PUT
        const putHeaders = {
          'Accept': 'application/json',
          'Authorization': `Bearer ${token}`,
        };
        // Don't set Content-Type, let browser set it with boundary
        
        response = await axios.post(`/api/projects/${props.project.id}?_method=PUT`, formPayload, { 
          headers: putHeaders,
        });
        successMessage.value = 'Projet mis à jour avec succès !';
      } else {
        // For updates without images, use JSON payload
        headers['Content-Type'] = 'application/json';
        
        // Create a clean payload without empty values
        const payload = {};
        Object.keys(formData.value).forEach(key => {
          if (key === 'payment_plan_text') {
            // Only send payment plan if payment method is selected
            if (paymentPlan.value.paymentMethod) {
              const paymentPlanData = {
                paymentMethod: paymentPlan.value.paymentMethod,
                cashAmount: paymentPlan.value.cashAmount || null,
                bankFullAmount: paymentPlan.value.bankFullAmount || null,
                bankDownPayment: paymentPlan.value.bankDownPayment || null,
                created_at: new Date().toISOString()
              };
              payload.payment_plan = JSON.stringify(paymentPlanData);
            }
            return;
          }
          if (key === 'project_timeline_text') {
            // Convert project timeline structure to JSON
            const timelineData = {
              announcement: projectTimeline.value.announcement,
              announcementDate: projectTimeline.value.announcementDate,
              construction: projectTimeline.value.construction,
              constructionStartDate: projectTimeline.value.constructionStartDate,
              completionDate: projectTimeline.value.completionDate,
              created_at: new Date().toISOString()
            };
            payload.project_timeline = JSON.stringify(timelineData);
            return;
          }
          if (key === 'additional_housing_types') {
            if (Array.isArray(formData.value.additional_housing_types) && formData.value.additional_housing_types.length > 0) {
              // Filter out items with empty type and format as objects with type and count
              const filtered = formData.value.additional_housing_types
                .filter(item => item && (typeof item === 'string' ? item : item.type))
                .map(item => {
                  // Handle backward compatibility: if it's a string, convert to object
                  if (typeof item === 'string') {
                    return { type: item, count: null };
                  }
                  return { type: item.type, count: item.count || null };
                });
              if (filtered.length > 0) {
                payload.additional_housing_types = JSON.stringify(filtered);
              }
            }
            return;
          }
          // Skip price since it's removed from the form
          if (key === 'price') {
            return;
          }
          // Only include non-null, non-undefined, and non-empty values
          if (formData.value[key] !== null && formData.value[key] !== undefined && formData.value[key] !== '') {
            payload[key] = formData.value[key];
          }
        });
        
        response = await axios.put(`/api/projects/${props.project.id}`, payload, { headers });
        successMessage.value = 'Projet mis à jour avec succès !';
      }
    } else {
      // For new project, use FormData for file uploads
      const formPayload = new FormData();
      
      // Add the main project data
      Object.keys(formData.value).forEach(key => {
        if (key === 'wilaya' || key === 'baladia' || key === 'daira') {
          // Skip these as we'll add them separately
          return;
        }
        if (key === 'payment_plan_text') {
          // Only send payment plan if payment method is selected
          if (paymentPlan.value.paymentMethod) {
            const paymentPlanData = {
              paymentMethod: paymentPlan.value.paymentMethod,
              cashAmount: paymentPlan.value.cashAmount || null,
              bankFullAmount: paymentPlan.value.bankFullAmount || null,
              bankDownPayment: paymentPlan.value.bankDownPayment || null,
              created_at: new Date().toISOString()
            };
            formPayload.append('payment_plan', JSON.stringify(paymentPlanData));
          }
          return;
        }
        if (key === 'project_timeline_text') {
          // Convert project timeline structure to JSON
          const timelineData = {
            announcement: projectTimeline.value.announcement,
            announcementDate: projectTimeline.value.announcementDate,
            construction: projectTimeline.value.construction,
            constructionStartDate: projectTimeline.value.constructionStartDate,
            completionDate: projectTimeline.value.completionDate,
            created_at: new Date().toISOString()
          };
          formPayload.append('project_timeline', JSON.stringify(timelineData));
          return;
        }
        if (key === 'additional_housing_types') {
          if (Array.isArray(formData.value.additional_housing_types) && formData.value.additional_housing_types.length > 0) {
            // Filter out items with empty type and format as objects with type and count
            const filtered = formData.value.additional_housing_types
              .filter(item => item && (typeof item === 'string' ? item : item.type))
              .map(item => {
                // Handle backward compatibility: if it's a string, convert to object
                if (typeof item === 'string') {
                  return { type: item, count: null };
                }
                return { type: item.type, count: item.count || null };
              });
            if (filtered.length > 0) {
              formPayload.append('additional_housing_types', JSON.stringify(filtered));
            }
          }
          return;
        }
        // Skip price since it's removed from the form
        if (key === 'price') {
          return;
        }
        // Only append non-null, non-undefined, and non-empty values
        if (key !== 'images' && key !== 'image_captions') {
          const value = formData.value[key];
          if (value !== null && value !== undefined && value !== '') {
            formPayload.append(key, value);
          }
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
    wilaya: '',
    baladia: '',
    daira: '',
    delivery_date: '',
    price: null,
    surface_area: null,
    bedrooms: '',
    bathrooms: null,
    rent_or_buy: '',
    payment_plan_text: '',
    project_timeline_text: '',
    description: '',
    images: [],
    image_captions: [],
    additional_housing_types: [],
    f1_count: 0,
    f2_count: 0,
    f3_count: 0,
    f4_count: 0,
    num_units: null
  };
  
  // Reset payment plan
  paymentPlan.value = {
    paymentMethod: '',
    cashAmount: null,
    bankFullAmount: null,
    bankDownPayment: null
  };
  
  // Reset project timeline
  projectTimeline.value = {
    announcement: '',
    announcementDate: '',
    construction: '',
    constructionStartDate: '',
    completionDate: ''
  };
  
  previewImages.value = [];
  errorMessage.value = '';
  successMessage.value = '';
};

const handleFileUpload = (event) => {
  const files = Array.from(event.target.files);
  const MAX_IMAGES = 10;
  const currentCount = previewImages.value.length;
  
  // Check if adding these files would exceed the limit
  if (currentCount + files.length > MAX_IMAGES) {
    const remaining = MAX_IMAGES - currentCount;
    errorMessage.value = `Vous ne pouvez télécharger que ${remaining} image${remaining > 1 ? 's' : ''} supplémentaire${remaining > 1 ? 's' : ''}. Maximum ${MAX_IMAGES} images autorisées.`;
    // Only process the files that fit within the limit
    files.splice(remaining);
  }
  
  files.forEach(file => {
    // Skip if we've reached the limit
    if (previewImages.value.length >= MAX_IMAGES) {
      return;
    }
    
    if (!file.type.startsWith('image/')) {
      errorMessage.value = `Le fichier ${file.name} n'est pas une image.`;
      return;
    }
    
    if (file.size > 10 * 1024 * 1024) { // 10MB limit
      errorMessage.value = `Le fichier ${file.name} est trop volumineux. La taille maximale est de 10 Mo.`;
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
  // Clear error message if it was about the image limit
  if (errorMessage.value && errorMessage.value.includes('Maximum') && errorMessage.value.includes('images allowed')) {
    errorMessage.value = '';
  }
};

// Increment/decrement apartment sub-type counters
const adjustApartmentCount = (field, delta) => {
  const current = parseInt(formData.value[field] || 0, 10);
  const next = current + delta;
  formData.value[field] = next < 0 ? 0 : next;
};

// Increment/decrement count for non-apartment housing types
const adjustCount = (field, delta) => {
  const current = parseInt(formData.value[field] || 0, 10);
  const next = current + delta;
  formData.value[field] = next < 0 ? 0 : next;
};

// Additional housing type handlers
const addAdditionalHousingType = () => {
  if (!Array.isArray(formData.value.additional_housing_types)) {
    formData.value.additional_housing_types = [];
  }
  formData.value.additional_housing_types.push({ type: '', count: null });
};

const removeAdditionalHousingType = (index) => {
  formData.value.additional_housing_types.splice(index, 1);
};

// Increment/decrement count for additional housing types
const adjustAdditionalCount = (index, delta) => {
  if (!formData.value.additional_housing_types || !formData.value.additional_housing_types[index]) {
    console.warn('Invalid index or additional_housing_types not found:', index);
    return;
  }
  const item = formData.value.additional_housing_types[index];
  if (!item) return;
  
  // Ensure count is initialized
  if (item.count === null || item.count === undefined) {
    item.count = 0;
  }
  
  const current = parseInt(item.count || 0, 10);
  const next = current + delta;
  item.count = next < 0 ? 0 : next;
  
  // Force reactivity update
  formData.value.additional_housing_types[index] = { ...item };
};


// Handle announcement change
const onAnnouncementChange = () => {
  if (projectTimeline.value.announcement === 'coming_soon') {
    // Clear the announcement date when coming soon is selected
    projectTimeline.value.announcementDate = '';
  }
};

// Handle construction change
const onConstructionChange = () => {
  if (projectTimeline.value.construction === 'not_started') {
    // Clear the construction start date when not started is selected
    projectTimeline.value.constructionStartDate = '';
  }
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
      const { id, user_id, created_at, updated_at, images, user, location: locationStr, payment_plan, project_timeline, ...projectData } = project;
      
      // Handle payment plan JSON data
      let paymentPlanText = '';
      if (payment_plan) {
        try {
          const paymentPlanData = typeof payment_plan === 'string' ? JSON.parse(payment_plan) : payment_plan;
          paymentPlanText = paymentPlanData.description || '';
          
          // Populate payment plan fields
          paymentPlan.value = {
            paymentMethod: paymentPlanData.paymentMethod || '',
            cashAmount: paymentPlanData.cashAmount || null,
            bankFullAmount: paymentPlanData.bankFullAmount || null,
            bankDownPayment: paymentPlanData.bankDownPayment || null
          };
        } catch (e) {
          console.warn('Could not parse payment_plan:', e);
        }
      }

      // Handle project timeline JSON data
      let projectTimelineText = '';
      console.log('🔧 Project Timeline Raw Data:', project_timeline);
      if (project_timeline) {
        try {
          const timelineData = typeof project_timeline === 'string' ? JSON.parse(project_timeline) : project_timeline;
          projectTimelineText = timelineData.description || '';
          
          console.log('🔧 Parsed Timeline Data:', timelineData);
          
          // Populate project timeline fields
          projectTimeline.value = {
            announcement: timelineData.announcement || '',
            announcementDate: timelineData.announcementDate || '',
            construction: timelineData.construction || '',
            constructionStartDate: timelineData.constructionStartDate || '',
            completionDate: timelineData.completionDate || ''
          };
          
          console.log('🔧 Populated Timeline Fields:', projectTimeline.value);
        } catch (e) {
          console.warn('Could not parse project_timeline:', e);
        }
      }
      
      // Populate form data
      console.log('🔧 Project Data for Form:', projectData);
      formData.value = { 
        name: projectData.name || '',
        housing_type: projectData.housing_type || '',
        wilaya: location.wilaya || '',
        baladia: location.commune || '',
        daira: location.daira || '',
        delivery_date: projectData.delivery_date || '',
        price: projectData.price || null,
        surface_area: projectData.surface_area || null,
        bedrooms: projectData.bedrooms || '',
        bathrooms: projectData.bathrooms || null,
        rent_or_buy: projectData.rent_or_buy || '',
        payment_plan_text: paymentPlanText,
        project_timeline_text: projectTimelineText,
        description: projectData.description || '',
        images: [],
        image_captions: [],
        additional_housing_types: (function () {
          try {
            let parsed = [];
            if (Array.isArray(projectData.additional_housing_types)) {
              parsed = projectData.additional_housing_types;
            } else if (typeof projectData.additional_housing_types === 'string') {
              parsed = JSON.parse(projectData.additional_housing_types);
            }
            // Convert to new format: array of objects with type and count
            return parsed.map(item => {
              if (typeof item === 'string') {
                return { type: item, count: null };
              }
              return { type: item.type || item, count: item.count || null };
            });
          } catch (e) {}
          return [];
        })(),
        f1_count: projectData.f1_count ?? 0,
        f2_count: projectData.f2_count ?? 0,
        f3_count: projectData.f3_count ?? 0,
        f4_count: projectData.f4_count ?? 0,
        num_units: projectData.num_units ?? null
      };
      
      console.log('🔧 Final Form Data:', formData.value);
      
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
