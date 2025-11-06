<template>
  <div class="min-h-screen bg-gray-50">
    <!-- Hero Section -->
    <div class="relative bg-gradient-to-r from-purple-700 to-indigo-800 text-white py-20">
      <div class="absolute inset-0 bg-black/30"></div>
      <div class="container mx-auto px-4 relative z-10">
        <div class="max-w-4xl mx-auto text-center">
          <h1 class="text-4xl md:text-5xl font-bold mb-4">Trouvez le bien de vos rêves</h1>
          <p class="text-xl text-purple-100">
            Parcouvez notre sélection de biens premium et trouvez la perle rare
          </p>
        </div>
      </div>
    </div>

    <!-- Main Content -->
    <div class="container mx-auto px-4 py-12">
      <div class="flex flex-col md:flex-row gap-8">
        <!-- Filters Sidebar -->
        <div class="w-full md:w-80 flex-shrink-0">
          <div class="bg-white rounded-xl shadow-md p-6 sticky top-4">
            <div class="flex justify-between items-center mb-6">
              <h2 class="text-lg font-semibold text-gray-900">Filtres</h2>
              <button 
                @click="resetFilters"
                class="text-sm text-purple-600 hover:text-purple-700"
              >
                Réinitialiser
              </button>
            </div>

            <!-- Search -->
            <div class="mb-6">
              <label class="block text-sm font-medium text-gray-700 mb-2">Recherche</label>
              <div class="relative">
                <input
                  type="text"
                  v-model="filters.search"
                  placeholder="Rechercher un bien..."
                  class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                >
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                  <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                  </svg>
                </div>
              </div>
            </div>

            <!-- Property Type -->
            <div class="mb-6">
              <h3 class="text-sm font-medium text-gray-700 mb-3">Type de bien</h3>
              <div class="space-y-2">
                <div v-for="type in propertyTypes" :key="type.value" class="flex flex-col">
                  <div class="flex items-center">
                    <input
                      :id="`type-${type.value}`"
                      v-model="filters.types"
                      type="checkbox"
                      :value="type.value"
                      class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded"
                    >
                    <label :for="`type-${type.value}`" class="ml-3 text-sm text-gray-700">
                      {{ type.label }}
                    </label>
                  </div>
                  <!-- Show F1-F4 checkboxes when Apartment is selected -->
                  <div v-if="type.value === 'Apartment' && isApartmentSelected" class="ml-7 mt-2 space-y-2 pl-4 border-l-2 border-purple-200">
                    <div class="flex items-center">
                      <input
                        id="filter-f1"
                        v-model="filters.apartmentTypes"
                        type="checkbox"
                        value="f1"
                        class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded"
                      >
                      <label for="filter-f1" class="ml-3 text-sm text-gray-600">
                        F1
                      </label>
                    </div>
                    <div class="flex items-center">
                      <input
                        id="filter-f2"
                        v-model="filters.apartmentTypes"
                        type="checkbox"
                        value="f2"
                        class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded"
                      >
                      <label for="filter-f2" class="ml-3 text-sm text-gray-600">
                        F2
                      </label>
                    </div>
                    <div class="flex items-center">
                      <input
                        id="filter-f3"
                        v-model="filters.apartmentTypes"
                        type="checkbox"
                        value="f3"
                        class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded"
                      >
                      <label for="filter-f3" class="ml-3 text-sm text-gray-600">
                        F3
                      </label>
                    </div>
                    <div class="flex items-center">
                      <input
                        id="filter-f4"
                        v-model="filters.apartmentTypes"
                        type="checkbox"
                        value="f4"
                        class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded"
                      >
                      <label for="filter-f4" class="ml-3 text-sm text-gray-600">
                        F4
                      </label>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Price Range -->
            <div class="mb-6">
              <h3 class="text-sm font-medium text-gray-700 mb-3">Fourchette de prix (DZD)</h3>
              <div class="flex items-center gap-3">
                <div class="flex-1">
                  <label for="min-price" class="sr-only">Prix min</label>
                  <div class="relative rounded-md shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                      <span class="text-gray-500 text-sm">DZD</span>
                    </div>
                    <input
                      type="number"
                      id="min-price"
                      v-model.number="filters.minPrice"
                      placeholder="Min"
                      class="block w-full pl-16 pr-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 sm:text-sm"
                      min="0"
                    >
                  </div>
                </div>
                <div class="text-gray-500 mt-1">-</div>
                <div class="flex-1">
                  <label for="max-price" class="sr-only">Prix max</label>
                  <div class="relative rounded-md shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                      <span class="text-gray-500 text-sm">DZD</span>
                    </div>
                    <input
                      type="number"
                      id="max-price"
                      v-model.number="filters.maxPrice"
                      placeholder="Max"
                      class="block w-full pl-16 pr-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 sm:text-sm"
                      :min="filters.minPrice || 0"
                    >
                  </div>
                </div>
              </div>
            </div>

            <!-- Surface Area Range -->
            <div class="mb-6">
              <h3 class="text-sm font-medium text-gray-700 mb-3">Surface (m²)</h3>
              <div class="flex items-center gap-3">
                <div class="flex-1">
                  <label for="min-area" class="sr-only">Surface min</label>
                  <div class="relative rounded-md shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                      <span class="text-gray-500 text-sm">m²</span>
                    </div>
                    <input
                      type="number"
                      id="min-area"
                      v-model.number="filters.minArea"
                      placeholder="Min"
                      class="block w-full pl-16 pr-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 sm:text-sm"
                      min="0"
                    >
                  </div>
                </div>
                <div class="text-gray-500 mt-1">-</div>
                <div class="flex-1">
                  <label for="max-area" class="sr-only">Surface max</label>
                  <div class="relative rounded-md shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                      <span class="text-gray-500 text-sm">m²</span>
                    </div>
                    <input
                      type="number"
                      id="max-area"
                      v-model.number="filters.maxArea"
                      placeholder="Max"
                      class="block w-full pl-16 pr-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 sm:text-sm"
                      :min="filters.minArea || 0"
                    >
                  </div>
                </div>
              </div>
            </div>

            <!-- Number of Units Range -->
            <div class="mb-6">
              <h3 class="text-sm font-medium text-gray-700 mb-3">Nombre d'unités</h3>
              <div class="flex items-center gap-3">
                <div class="flex-1">
                  <label for="min-units" class="sr-only">Unités min</label>
                  <input
                    type="number"
                    id="min-units"
                    v-model.number="filters.minUnits"
                    placeholder="Min"
                    class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 sm:text-sm"
                    min="0"
                  >
                </div>
                <div class="text-gray-500">-</div>
                <div class="flex-1">
                  <label for="max-units" class="sr-only">Unités max</label>
                  <input
                    type="number"
                    id="max-units"
                    v-model.number="filters.maxUnits"
                    placeholder="Max"
                    class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 sm:text-sm"
                    :min="filters.minUnits || 0"
                  >
                </div>
              </div>
            </div>

            <!-- Bedrooms Filter -->
            <div class="mb-6">
              <h3 class="text-sm font-medium text-gray-700 mb-3">Chambres</h3>
              <div class="flex items-center gap-3">
                <div class="flex-1">
                  <label for="min-bedrooms" class="sr-only">Chambres min</label>
                  <input
                    type="number"
                    id="min-bedrooms"
                    v-model.number="filters.minBedrooms"
                    placeholder="Min"
                    class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 sm:text-sm"
                    min="0"
                  >
                </div>
                <div class="text-gray-500">-</div>
                <div class="flex-1">
                  <label for="max-bedrooms" class="sr-only">Chambres max</label>
                  <input
                    type="number"
                    id="max-bedrooms"
                    v-model.number="filters.maxBedrooms"
                    placeholder="Max"
                    class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 sm:text-sm"
                    :min="filters.minBedrooms || 0"
                  >
                </div>
              </div>
            </div>

            <!-- Bathrooms Filter -->
            <div class="mb-6">
              <h3 class="text-sm font-medium text-gray-700 mb-3">Salles de bain</h3>
              <div class="flex items-center gap-3">
                <div class="flex-1">
                  <label for="min-bathrooms" class="sr-only">Salles de bain min</label>
                  <input
                    type="number"
                    id="min-bathrooms"
                    v-model.number="filters.minBathrooms"
                    placeholder="Min"
                    class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 sm:text-sm"
                    min="0"
                    step="0.5"
                  >
                </div>
                <div class="text-gray-500">-</div>
                <div class="flex-1">
                  <label for="max-bathrooms" class="sr-only">Salles de bain max</label>
                  <input
                    type="number"
                    id="max-bathrooms"
                    v-model.number="filters.maxBathrooms"
                    placeholder="Max"
                    class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 sm:text-sm"
                    :min="filters.minBathrooms || 0"
                    step="0.5"
                  >
                </div>
              </div>
            </div>

            <!-- Delivery Date Range -->
            <div class="mb-6">
              <h3 class="text-sm font-medium text-gray-700 mb-3">Date de livraison</h3>
              <div class="space-y-3">
                <div>
                  <label for="delivery-start" class="block text-xs font-medium text-gray-500 mb-1">Date de début</label>
                  <input
                    type="date"
                    id="delivery-start"
                    v-model="filters.deliveryStartDate"
                    class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 sm:text-sm"
                    :max="filters.deliveryEndDate || ''"
                  >
                </div>
                <div>
                  <label for="delivery-end" class="block text-xs font-medium text-gray-500 mb-1">Date de fin</label>
                  <input
                    type="date"
                    id="delivery-end"
                    v-model="filters.deliveryEndDate"
                    class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 sm:text-sm"
                    :min="filters.deliveryStartDate || ''"
                  >
                </div>
              </div>
            </div>

            <!-- Location Filters -->
            <div class="mb-6">
              <h3 class="text-sm font-medium text-gray-700 mb-3">Localisation</h3>
              
              <!-- Wilaya -->
              <div class="mb-3">
                <label for="wilaya" class="block text-xs font-medium text-gray-500 mb-1">Wilaya</label>
                <div class="relative">
                  <select
                    id="wilaya"
                    v-model="filters.wilaya"
                    class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 sm:text-sm"
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
              <div class="mb-3">
                <label for="baladia" class="block text-xs font-medium text-gray-500 mb-1">Commune</label>
                <div class="relative">
                  <select
                    id="baladia"
                    v-model="filters.baladia"
                    :disabled="!filters.wilaya || isLoadingBaladias"
                    class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 sm:text-sm"
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
                <label for="daira" class="block text-xs font-medium text-gray-500 mb-1">Daira</label>
                <div class="relative">
                  <select
                    id="daira"
                    v-model="filters.daira"
                    :disabled="!filters.baladia || isLoadingDairas"
                    class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 sm:text-sm"
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
            </div>
          </div>
        </div>

        <!-- Property List -->
        <div class="flex-1">
          <!-- Sort and View Options -->
          <div class="flex flex-wrap items-center justify-between gap-2 mb-6 w-full">
            <p class="text-sm text-gray-600">
              <span class="hidden xs:inline">Affichage de</span> <span class="font-medium">{{ filteredProperties.length }}</span> <span class="hidden sm:inline">biens</span>
            </p>
            <div class="flex items-center gap-2">
              <label for="sort" class="text-sm text-gray-700 whitespace-nowrap">
                Trier par :
              </label>
              <select
                id="sort"
                v-model="sortOption"
                class="text-sm border-gray-300 rounded-md focus:ring-purple-500 focus:border-purple-500 py-1.5"
              >
                <option value="featured">À la une</option>
                <option value="price-asc">Prix croissant</option>
                <option value="price-desc">Prix décroissant</option>
                <option value="newest">Plus récent</option>
              </select>
            </div>
          </div>

          <!-- Loading State -->
          <div v-if="isLoading" class="flex justify-center items-center py-12">
            <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-purple-600"></div>
          </div>
          
          <!-- Error State -->
          <div v-else-if="error" class="bg-red-50 border-l-4 border-red-400 p-4 mb-6">
            <div class="flex">
              <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                  <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                </svg>
              </div>
              <div class="ml-3">
                <p class="text-sm text-red-700">
                  {{ error }}
                </p>
              </div>
            </div>
          </div>
          
          <!-- Property Grid -->
          <div v-else-if="properties.length > 0" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 gap-6">
            <div 
              v-for="property in properties" 
              :key="property.id"
              @click="navigateToProperty(property.id)"
              class="bg-white rounded-xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-lg cursor-pointer"
            >
              <!-- Property Image -->
              <div class="relative h-48 bg-gray-100">
                <img 
                  v-if="getFirstImage(property)" 
                  :src="getFirstImage(property)" 
                  :alt="property.name"
                  class="w-full h-full object-cover"
                  @error="$event.target.src = 'https://via.placeholder.com/400x300?text=No+Image'"
                >
                <div v-else class="w-full h-full flex items-center justify-center bg-gray-100 text-gray-400">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                  </svg>
                </div>
                <div class="absolute top-2 right-2 bg-white/90 backdrop-blur-sm rounded-full px-2 py-1 text-xs font-medium text-gray-800">
                  {{ property.housing_type || 'Bien' }}
                </div>
              </div>
              
              <!-- Property Details -->
              <div class="p-4">
                <div class="flex justify-between items-start">
                  <h3 class="text-lg font-semibold text-gray-900 line-clamp-1">{{ property.name }}</h3>
                  <span class="text-sm font-medium text-purple-700">{{ formatPrice(property.price) }}</span>
                </div>
                
                <p class="mt-1 text-sm text-gray-500 flex items-center">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                  </svg>
                  <span class="line-clamp-1">{{ formatLocation(property.location) || 'Localisation non spécifiée' }}</span>
                </p>
                
                <div class="mt-3 pt-3 border-t border-gray-100">
                  <div class="grid grid-cols-2 gap-3 text-sm text-gray-500">
                    <div class="flex items-center">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                      </svg>
                      <span>{{ property.surface_area ? `${property.surface_area} m²` : 'N/A' }}</span>
                    </div>
                    <div class="flex items-center">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                      </svg>
                      <span>{{ property.num_units !== null && property.num_units !== undefined ? `${property.num_units} unité${property.num_units > 1 ? 's' : ''}` : 'N/A' }}</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          
          <!-- Empty State -->
          <div v-else class="text-center py-12">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">Aucun bien trouvé</h3>
            <p class="mt-1 text-sm text-gray-500">Ajustez vos critères de recherche pour trouver ce que vous cherchez.</p>
            <div class="mt-6">
              <button
                @click="resetFilters"
                class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500"
              >
                Réinitialiser les filtres
              </button>
            </div>
          </div>

         
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, watch, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import api from '../services/api';
import axios from 'axios';

// Create axios instance for direct API calls
const axiosInstance = axios.create({
  baseURL: 'http://sekna.soexplast.com',
  headers: {
    'Accept': 'application/json',
    'Content-Type': 'application/json',
  }
});

const router = useRouter();

// State
const properties = ref([]);
const isLoading = ref(false);
const error = ref(null);
const filterTimeout = ref(null);
const currentPage = ref(1);
const perPage = 12;
const totalItems = ref(0);
const totalPages = ref(1);
const viewMode = ref('grid');
const sortOption = ref('featured');

// Filters
const filters = ref({
  search: '',
  types: [],
  minPrice: null,
  maxPrice: null,
  minArea: null,
  maxArea: null,
  minUnits: null,
  maxUnits: null,
  minBedrooms: null,
  maxBedrooms: null,
  minBathrooms: null,
  maxBathrooms: null,
  deliveryStartDate: '',
  deliveryEndDate: '',
  wilaya: '',
  baladia: '',
  daira: '',
  apartmentTypes: [] // Array of selected F types: ['f1', 'f2', 'f3', 'f4']
});

// Check if Apartment is selected
const isApartmentSelected = computed(() => {
  if (!filters.value.types || filters.value.types.length === 0) {
    return false;
  }
  return filters.value.types.includes('Apartment');
});

// Watch for apartment deselection to clear F filters
watch(() => filters.value.types, (newTypes) => {
  const hasApartment = newTypes.includes('Apartment');
  
  // Clear apartment types if apartment is deselected
  if (!hasApartment && filters.value.apartmentTypes.length > 0) {
    filters.value.apartmentTypes = [];
  }
});

// Location data
const wilayas = ref([]);
const baladias = ref([]);
const dairas = ref([]);
const isLoadingLocations = ref(true);
const isLoadingBaladias = ref(false);
const isLoadingDairas = ref(false);
const locationError = ref(null);

// Load wilayas
const loadWilayas = async () => {
  try {
    console.log('Loading wilayas...');
    isLoadingLocations.value = true;
    locationError.value = null;
    
    const response = await axios.get('/api/locations/wilayas');
    console.log('Wilayas loaded:', response.data);
    
    if (Array.isArray(response.data)) {
      wilayas.value = response.data;
      console.log('Wilayas set successfully');
    } else {
      console.error('Unexpected response format:', response.data);
      locationError.value = 'Failed to load wilayas: Invalid data format';
    }
  } catch (error) {
    console.error('Error loading wilayas:', error);
    const errorMsg = error.response?.data?.error || error.message || 'Failed to load wilayas';
    locationError.value = errorMsg;
    
    if (error.response) {
      console.error('Response data:', error.response.data);
      console.error('Status:', error.response.status);
      console.error('Headers:', error.response.headers);
    } else if (error.request) {
      console.error('No response received:', error.request);
    }
  } finally {
    isLoadingLocations.value = false;
  }
};

// Load baladias when wilaya is selected
const loadBaladias = async (wilaya) => {
  if (!wilaya) {
    baladias.value = [];
    dairas.value = [];
    filters.value.baladia = '';
    filters.value.daira = '';
    return;
  }
  
  try {
    isLoadingBaladias.value = true;
    locationError.value = null;
    
    const response = await axios.get(`/api/locations/baladias/${encodeURIComponent(wilaya)}`);
    console.log(`Baladias for ${wilaya}:`, response.data);
    
    if (Array.isArray(response.data)) {
      baladias.value = response.data;
      dairas.value = [];
      filters.value.baladia = '';
      filters.value.daira = '';
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
    filters.value.baladia = '';
    filters.value.daira = '';
  } finally {
    isLoadingBaladias.value = false;
  }
};

// Load dairas when baladia is selected
const loadDairas = async (wilaya, baladia) => {
  if (!wilaya || !baladia) {
    dairas.value = [];
    filters.value.daira = '';
    return;
  }
  
  try {
    isLoadingDairas.value = true;
    locationError.value = null;
    
    const response = await axios.get(
      `/api/locations/dairas/${encodeURIComponent(wilaya)}/${encodeURIComponent(baladia)}`
    );
    console.log(`Dairas for ${wilaya} / ${baladia}:`, response.data);
    
    if (Array.isArray(response.data)) {
      dairas.value = response.data;
      filters.value.daira = '';
    } else {
      console.error('Unexpected response format for dairas:', response.data);
      locationError.value = 'Failed to load dairas: Invalid data format';
    }
  } catch (error) {
    console.error('Error loading dairas:', error);
    const errorMsg = error.response?.data?.error || error.message || 'Failed to load dairas';
    locationError.value = errorMsg;
    dairas.value = [];
    filters.value.daira = '';
  } finally {
    isLoadingDairas.value = false;
  }
};

// Handle wilaya change
const onWilayaChange = () => {
  console.log('Wilaya changed to:', filters.value.wilaya);
  loadBaladias(filters.value.wilaya);
};

// Handle baladia change
const onBaladiaChange = () => {
  console.log('Baladia changed to:', filters.value.baladia);
  loadDairas(filters.value.wilaya, filters.value.baladia);
};

// Watch for wilaya changes from other components
watch(() => filters.value.wilaya, (newWilaya) => {
  if (newWilaya) {
    loadBaladias(newWilaya);
  }
});

// Watch for baladia changes from other components
watch(() => filters.value.baladia, (newBaladia, oldBaladia) => {
  if (newBaladia && newBaladia !== oldBaladia) {
    loadDairas(filters.value.wilaya, newBaladia);
  }
});

// Load wilayas on component mount
onMounted(() => {
  console.log('Component mounted, loading wilayas...');
  loadWilayas();
});

// Show error message if location loading fails
watch(locationError, (newError) => {
  if (newError) {
    console.error('Location error:', newError);
    // You could show a toast notification here if needed
  }
});

// Types de biens
const propertyTypes = [
  { value: 'House', label: 'Maison' },
  { value: 'Apartment', label: 'Appartement' },
  { value: 'Villa', label: 'Villa' },
  { value: 'Townhouse', label: 'Maison de ville' },
  { value: 'Penthouse', label: 'Penthouse' },
  { value: 'Duplex', label: 'Duplex' },
  { value: 'Cabin', label: 'Chalet' },
  { value: 'Mansion', label: 'Manoir' },
  { value: 'Loft', label: 'Loft' },
  { value: 'Farmhouse', label: 'Ferme' },
  { value: 'Brownstone', label: 'Immeuble en pierre' },
  { value: 'Cottage', label: 'Cottage' }
];

// Options de chambres
const bedroomOptions = [
  { value: null, label: 'Tous' },
  { value: 1, label: '1+' },
  { value: 2, label: '2+' },
  { value: 3, label: '3+' },
  { value: 4, label: '4+' },
  { value: 5, label: '5+' }
];

// Options de salles de bain
const bathroomOptions = [
  { value: null, label: 'Toutes' },
  { value: 1, label: '1+' },
  { value: 2, label: '2+' },
  { value: 3, label: '3+' },
  { value: 4, label: '4+' },
  { value: 5, label: '5+' }
];

// Équipements
const features = [
  { value: 'pool', label: 'Piscine' },
  { value: 'garage', label: 'Garage' },
  { value: 'garden', label: 'Jardin' },
  { value: 'fireplace', label: 'Cheminée' },
  { value: 'gym', label: 'Salle de sport' },
  { value: 'security', label: 'Sécurité 24/7' },
  { value: 'furnished', label: 'Meublé' },
  { value: 'view', label: 'Vue panoramique' },
  { value: 'elevator', label: 'Ascenseur' },
  { value: 'balcony', label: 'Balcon' }
];

// Helper function to get price from payment plan or regular price field
const getProjectPrice = (project) => {
  // First, check payment plan for cash or bank amount
  if (project.payment_plan) {
    try {
      const paymentPlanData = typeof project.payment_plan === 'string' 
        ? JSON.parse(project.payment_plan) 
        : project.payment_plan;
      
      if (paymentPlanData.paymentMethod === 'cash' && paymentPlanData.cashAmount) {
        return paymentPlanData.cashAmount;
      } else if (paymentPlanData.paymentMethod === 'bank' && paymentPlanData.bankFullAmount) {
        return paymentPlanData.bankFullAmount;
      }
    } catch (e) {
      console.warn('Could not parse payment plan:', e);
    }
  }
  
  // Fall back to regular price field
  return project.price || null;
};

// Fetch properties from API
const fetchProperties = async () => {
  try {
    isLoading.value = true;
    error.value = null;
    
    // Cancel any pending requests
    if (window.axiosCancel) {
      window.axiosCancel('Request canceled');
    }
    
    // Prepare query parameters
    const params = {
      page: currentPage.value,
      per_page: perPage,
      ...(filters.value.search && { search: filters.value.search }),
      ...(filters.value.wilaya && { wilaya: filters.value.wilaya }),
      ...(filters.value.baladia && { commune: filters.value.baladia }),
      ...(filters.value.daira && { daira: filters.value.daira }),
      ...(filters.value.minPrice && { price_min: filters.value.minPrice }),
      ...(filters.value.maxPrice && { price_max: filters.value.maxPrice }),
      ...(filters.value.minArea && { surface_area_min: filters.value.minArea }),
      ...(filters.value.maxArea && { surface_area_max: filters.value.maxArea }),
      ...(filters.value.minUnits && { num_units_min: filters.value.minUnits }),
      ...(filters.value.maxUnits && { num_units_max: filters.value.maxUnits }),
      ...(filters.value.minBedrooms && { bedrooms_min: filters.value.minBedrooms }),
      ...(filters.value.maxBedrooms && { bedrooms_max: filters.value.maxBedrooms }),
      ...(filters.value.minBathrooms && { bathrooms_min: filters.value.minBathrooms }),
      ...(filters.value.maxBathrooms && { bathrooms_max: filters.value.maxBathrooms }),
      ...(filters.value.deliveryStartDate && { delivery_date_min: filters.value.deliveryStartDate }),
      ...(filters.value.deliveryEndDate && { delivery_date_max: filters.value.deliveryEndDate }),
      ...(filters.value.types && filters.value.types.length > 0 && { housing_type: filters.value.types.join(',') }),
      // Add F1-F4 filters if apartment types are selected
      ...(filters.value.apartmentTypes && filters.value.apartmentTypes.includes('f1') && { f1_count_min: 1 }),
      ...(filters.value.apartmentTypes && filters.value.apartmentTypes.includes('f2') && { f2_count_min: 1 }),
      ...(filters.value.apartmentTypes && filters.value.apartmentTypes.includes('f3') && { f3_count_min: 1 }),
      ...(filters.value.apartmentTypes && filters.value.apartmentTypes.includes('f4') && { f4_count_min: 1 })
    };
    
    // Make API call to fetch projects with filters
    const response = await axiosInstance.get('/api/projects/filter', { 
      params,
      cancelToken: new axios.CancelToken((c) => {
        window.axiosCancel = c;
      })
    });
    
    // Transform API response to match our component's expected format
    const formattedData = response.data.projects.map(project => {
      const projectPrice = getProjectPrice(project);
      return {
        id: project.id,
        name: project.name,
        location: project.location,
        price: projectPrice, // Use extracted price from payment plan or regular price
        payment_plan: project.payment_plan, // Keep for reference
        featured: false, // You might want to add this to your API or handle it differently
        bedrooms: project.bedrooms || 0,
        bathrooms: project.bathrooms || 0,
        surface_area: project.surface_area,
        housing_type: project.housing_type,
        images: (project.images || []).map(img => ({
          id: img.id,
          url: img.image_path && img.image_path.startsWith('http') ? img.image_path : `http://sekna.soexplast.com${img.image_path}`,
          image_path: img.image_path,
          caption: img.caption
        })),
        created_at: project.created_at,
        updated_at: project.updated_at,
        num_units: project.num_units || null,
        delivery_date: project.delivery_date,
        description: project.description,
        f1_count: project.f1_count || 0,
        f2_count: project.f2_count || 0,
        f3_count: project.f3_count || 0,
        f4_count: project.f4_count || 0
      };
    });
    
    // Update component state with API data
    properties.value = formattedData;
    totalItems.value = response.data.count || 0;
    // Since we're not paginating on the server, we'll handle it on the client
    totalPages.value = 1;
    
  } catch (err) {
    console.error('Error fetching properties:', err);
    error.value = 'Échec du chargement des biens. Veuillez réessayer plus tard.';
    // Reset properties on error
    properties.value = [];
    totalItems.value = 0;
    totalPages.value = 1;
  } finally {
    isLoading.value = false;
  }
};

// Handle property click
const navigateToProperty = (propertyId) => {
  router.push({ name: 'property-details', params: { id: propertyId } });
};

// Format location object/string into readable text
const formatLocation = computed(() => (location) => {
  if (!location) return '';
  
  try {
    // If it's already a string, try to parse it as JSON
    const locationObj = typeof location === 'string' ? JSON.parse(location) : location;
    
    // Extract address components
    const parts = [
      locationObj.street,
      locationObj.baladia,
      locationObj.daira,
      locationObj.wilaya
    ].filter(Boolean); // Remove any empty/undefined parts
    
    return parts.join(', ');
  } catch (e) {
    // If parsing fails or it's not an object, return as is
    return typeof location === 'string' ? location : '';
  }
});

// Formater le prix
const formatPrice = (price) => {
  if (!price && price !== 0) return 'Prix sur demande';
  const numericValue = Number(price);
  if (isNaN(numericValue)) return 'Prix sur demande';
  return new Intl.NumberFormat('fr-DZ', {
    style: 'currency',
    currency: 'DZD',
    minimumFractionDigits: 0,
    maximumFractionDigits: 0
  }).format(numericValue).replace('DZD', 'DA');
};

// Get first image URL from property
const getFirstImage = (property) => {
  if (!property.images || property.images.length === 0) return '';
  const firstImage = property.images[0];
  return firstImage.image_path || firstImage.url || '';
};

// Since we're doing server-side filtering, we don't need client-side filtering
const filteredProperties = computed(() => {
  return properties.value;
});

// Sorted properties
const sortedProperties = computed(() => {
  return [...filteredProperties.value].sort((a, b) => {
    switch (sortOption.value) {
      case 'price-asc':
        return a.price - b.price;
      case 'price-desc':
        return b.price - a.price;
      case 'newest':
        return new Date(b.created_at) - new Date(a.created_at);
      case 'featured':
      default:
        // Featured first, then by date (newest first)
        if (a.featured && !b.featured) return -1;
        if (!a.featured && b.featured) return 1;
        return new Date(b.created_at) - new Date(a.created_at);
    }
  });
});

// Pagination
const itemsPerPage = 12;
const paginatedProperties = computed(() => {
  const start = (currentPage.value - 1) * itemsPerPage;
  const end = start + itemsPerPage;
  return sortedProperties.value.slice(start, end);
});

// Reset all filters
const resetFilters = () => {
  // Reset all filters
  filters.value = {
    search: '',
    types: [],
    minPrice: null,
    maxPrice: null,
    minArea: null,
    maxArea: null,
    minUnits: null,
    maxUnits: null,
    minBedrooms: null,
    maxBedrooms: null,
    minBathrooms: null,
    maxBathrooms: null,
    deliveryStartDate: '',
    deliveryEndDate: '',
    wilaya: '',
    baladia: '',
    daira: '',
    baladias: [],
    dairas: [],
    apartmentTypes: []
  };
  
  // Reset sort option
  sortOption.value = 'featured';
  
  // Reset location dropdowns and reload wilayas
  loadWilayas();
  
  // Reset current page and fetch properties
  currentPage.value = 1;
  fetchProperties();
};

// Watch for page changes
watch(currentPage, () => {
  window.scrollTo({ top: 0, behavior: 'smooth' });
  fetchProperties();
});

// Watch for filter changes and refetch data when they change
watch(
  [() => filters.value, sortOption],
  () => {
    // Debounce the API call to avoid too many requests
    clearTimeout(filterTimeout.value);
    filterTimeout.value = setTimeout(() => {
      currentPage.value = 1;
      fetchProperties();
    }, 300); // 300ms debounce
  },
  { deep: true }
);

// Fetch properties when component is mounted
onMounted(() => {
  fetchProperties();
});
</script>

<style scoped>
/* Custom styles if needed */
</style>
