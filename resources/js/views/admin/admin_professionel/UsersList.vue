<template>
  <div class="min-h-screen bg-gray-50 p-4 sm:p-6">
    <div class="max-w-7xl mx-auto">
      <!-- Header Section -->
      <div class="md:flex md:items-center md:justify-between mb-8">
        <div class="flex-1 min-w-0">
          <h1 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
            Utilisateurs
          </h1>
          <p class="mt-1 text-sm text-gray-500">
            Gérez les utilisateurs du système et leurs autorisations
          </p>
        </div>
      </div>
      
      <!-- Filter Section -->
      <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="w-full sm:w-64">
          <label for="verification-filter" class="block text-sm font-medium text-gray-700 mb-1">Filtrer par statut de vérification</label>
          <select 
            id="verification-filter"
            v-model="verificationFilter"
            @change="fetchUsers"
            class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md"
          >
            <option value="all">Tous les utilisateurs</option>
            <option value="verified">Vérifiés uniquement</option>
            <option value="not_verified">Non vérifiés uniquement</option>
          </select>
        </div>
      </div>
      
      <!-- Loading state -->
      <div v-if="isLoading" class="mt-8 text-center">
        <div class="inline-flex items-center px-4 py-2 font-semibold leading-6 text-sm shadow rounded-md text-white bg-purple-600">
          <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
          </svg>
Chargement des utilisateurs...
        </div>
      </div>

      <!-- Error state -->
      <div v-else-if="error" class="mt-8 p-4 bg-red-50 text-red-700 rounded-md">
        {{ error }}
      </div>

      <!-- Empty state -->
      <div v-else-if="users.length === 0" class="mt-8 text-center">
        <div class="p-8 bg-gray-50 rounded-lg">
          <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0111-3.5M13 7a4 4 0 11-8 0 4 4 0 018 0zm6 7a6 6 0 01-6 6m0 0h6v-6m-6 0h6" />
          </svg>
          <h3 class="mt-2 text-sm font-medium text-gray-900">Aucun utilisateur trouvé</h3>
          <p class="mt-1 text-sm text-gray-500">Il n'y a pas encore d'utilisateurs dans le système.</p>
        </div>
      </div>

      <!-- Users list -->
      <div v-else class="mt-8 flex flex-col">
        <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
          <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
            <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
              <table class="min-w-full divide-y divide-gray-300">
                <thead class="bg-gray-50">
                  <tr>
                    <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">ID</th>
                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Nom</th>
                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Email</th>
                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Rôle</th>
                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Vérification</th>
                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Date d'inscription</th>
                    <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                      <span class="sr-only">Actions</span>
                    </th>
                  </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                  <tr v-for="user in users" :key="user.id">
                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">{{ user.id }}</td>
                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-900 font-medium">{{ user.name }}</td>
                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ user.email }}</td>
                    <td class="whitespace-nowrap px-3 py-4 text-sm">
                      <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium capitalize" :class="{
                        'bg-purple-100 text-purple-800': user.role === 'admin',
                        'bg-blue-100 text-blue-800': user.role === 'professional',
                        'bg-green-100 text-green-800': user.role === 'user',
                        'bg-gray-100 text-gray-800': !['admin', 'professional', 'user'].includes(user.role)
                      }">
                        {{ user.role }}
                      </span>
                    </td>
                    <td class="whitespace-nowrap px-3 py-4 text-sm">
                      <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium" :class="{
                        'bg-green-100 text-green-800': user.is_verified,
                        'bg-yellow-100 text-yellow-800': !user.is_verified
                      }">
                        <svg v-if="user.is_verified" class="-ml-0.5 mr-1.5 h-2 w-2 text-green-500" fill="currentColor" viewBox="0 0 8 8">
                          <circle cx="4" cy="4" r="3" />
                        </svg>
                        <svg v-else class="-ml-0.5 mr-1.5 h-2 w-2 text-yellow-500" fill="currentColor" viewBox="0 0 8 8">
                          <circle cx="4" cy="4" r="3" />
                        </svg>
                        {{ user.is_verified ? 'Vérifié' : 'Non vérifié' }}
                      </span>
                    </td>
                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ formatDate(user.created_at) }}</td>
                    <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                      <div class="flex space-x-3 justify-end">
                        <button @click="viewUser(user)" class="text-blue-600 hover:text-blue-900">
                          Voir
                        </button>
                        <button @click="confirmDelete(user)" class="text-red-600 hover:text-red-900">
                          Supprimer
                        </button>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- User Details Dialog -->
    <div v-if="showUserDetails" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50">
      <div class="bg-white rounded-lg p-6 max-w-2xl w-full mx-4">
        <div class="flex justify-between items-start">
          <div>
            <h3 class="text-lg leading-6 font-medium text-gray-900">
              Détails de l'utilisateur
            </h3>
            <p class="mt-1 text-sm text-gray-500">
              Informations détaillées de l'utilisateur
            </p>
          </div>
          <button @click="showUserDetails = false" class="text-gray-400 hover:text-gray-500">
            <span class="sr-only">Fermer</span>
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
        </div>
        
        <div class="mt-6 border-t border-gray-200 pt-6">
          <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
            <div class="sm:col-span-1">
              <dt class="text-sm font-medium text-gray-500">Nom complet</dt>
              <dd class="mt-1 text-sm text-gray-900">{{ selectedUser?.name || 'Non spécifié' }}</dd>
            </div>
            <div class="sm:col-span-1">
              <dt class="text-sm font-medium text-gray-500">Email</dt>
              <dd class="mt-1 text-sm text-gray-900">{{ selectedUser?.email || 'Non spécifié' }}</dd>
            </div>
            <div class="sm:col-span-1">
              <dt class="text-sm font-medium text-gray-500">Téléphone</dt>
              <dd class="mt-1 text-sm text-gray-900">{{ selectedUser?.phone || 'Non spécifié' }}</dd>
            </div>
            <div class="sm:col-span-1">
              <dt class="text-sm font-medium text-gray-500">Rôle</dt>
              <dd class="mt-1">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium capitalize" :class="{
                  'bg-purple-100 text-purple-800': selectedUser?.role === 'admin',
                  'bg-blue-100 text-blue-800': selectedUser?.role === 'professional',
                  'bg-green-100 text-green-800': selectedUser?.role === 'user',
                  'bg-gray-100 text-gray-800': !['admin', 'professional', 'user'].includes(selectedUser?.role)
                }">
                  {{ selectedUser?.role || 'Non spécifié' }}
                </span>
              </dd>
            </div>
            <div class="sm:col-span-1">
              <dt class="text-sm font-medium text-gray-500">Date d'inscription</dt>
              <dd class="mt-1 text-sm text-gray-900">{{ selectedUser?.created_at ? formatDate(selectedUser.created_at) : 'Non spécifié' }}</dd>
            </div>
            <div class="sm:col-span-1">
              <dt class="text-sm font-medium text-gray-500">Compte vérifié</dt>
              <dd class="mt-1">
                <span :class="selectedUser?.is_verified ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800'" class="px-2 py-1 text-xs font-medium rounded-full">
                  {{ selectedUser?.is_verified ? 'Oui' : 'Non' }}
                </span>
              </dd>
            </div>
          </dl>
        </div>
        
        <div class="mt-6 pt-6 border-t border-gray-200 flex justify-between">
          <div>
            <button 
              v-if="!selectedUser?.is_verified"
              @click="verifyUser(selectedUser)" 
              class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500"
              :disabled="isVerifying"
            >
              <svg v-if="isVerifying" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
              </svg>
              {{ isVerifying ? 'Vérification...' : 'Vérifier ce compte' }}
            </button>
          </div>
          <div class="space-x-3">
            <button 
              @click="showUserDetails = false" 
              type="button" 
              class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
            >
              Fermer
            </button>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Delete Confirmation Dialog -->
    <div v-if="showDeleteDialog" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50">
      <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4">
        <div class="sm:flex sm:items-start">
          <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
            <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
          </div>
          <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
            <h3 class="text-lg leading-6 font-medium text-gray-900">
Supprimer l'utilisateur
            </h3>
            <div class="mt-2">
              <p class="text-sm text-gray-500">
Êtes-vous sûr de vouloir supprimer <span class="font-medium">{{ userToDelete?.name }}</span> ? Cette action est irréversible.
              </p>
            </div>
          </div>
        </div>
        <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
          <button
            type="button"
            @click="deleteUser"
            :disabled="isDeleting"
            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm disabled:opacity-50"
          >
            <svg v-if="isDeleting" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
              <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
              <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            {{ isDeleting ? 'Suppression...' : 'Supprimer' }}
          </button>
          <button
            type="button"
            @click="showDeleteDialog = false"
            :disabled="isDeleting"
            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm"
          >
Annuler
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue';
import { useStore } from 'vuex';
import { useRouter } from 'vue-router';
import axios from 'axios'; // This will use the configured instance from app.js

// State
const users = ref([]);
const isLoading = ref(true);
const error = ref(null);
const showDeleteDialog = ref(false);
const userToDelete = ref(null);
const isDeleting = ref(false);
const showUserDetails = ref(false);
const selectedUser = ref(null);
const verificationFilter = ref('all');
const isVerifying = ref(false);
const verifyingUserId = ref(null);

// Format date
const formatDate = (dateString) => {
  if (!dateString) return 'N/A';
  const options = { year: 'numeric', month: 'short', day: 'numeric' };
  return new Date(dateString).toLocaleDateString(undefined, options);
};

const store = useStore();
const router = useRouter();

// Check if user is authenticated
const isAuthenticated = computed(() => store.getters['auth/isAuthenticated']);

// Fetch users from API
const fetchUsers = async () => {
  // Redirect to login if not authenticated
  if (!isAuthenticated.value) {
    router.push({ name: 'auth' });
    return;
  }

  isLoading.value = true;
  error.value = null;
  
  try {
    const params = {};
    
    // Add verification filter if not 'all'
    if (verificationFilter.value !== 'all') {
      params.is_verified = verificationFilter.value === 'verified' ? '1' : '0';
    }
    
    const response = await axios.get('/api/admin/users', { params });
    users.value = response.data.data || response.data; // Handle both paginated and non-paginated responses
  } catch (err) {
    console.error('Error fetching users:', err);
    
    if (err.response && err.response.status === 401) {
      // Token might be invalid, clear auth and redirect to login
      await store.dispatch('auth/logout');
      router.push({ 
        name: 'auth', 
        query: { redirect: router.currentRoute.value.fullPath } 
      });
      error.value = 'Votre session a expiré. Veuillez vous reconnecter.';
    } else {
      error.value = 'Erreur lors du chargement des utilisateurs. Veuillez réessayer.';
    }
  } finally {
    isLoading.value = false;
  }
};

// Open user details
const viewUser = (user) => {
  selectedUser.value = user;
  showUserDetails.value = true;
};

// Verify a user
const verifyUser = async (user) => {
  if (!user) return;

  try {
    isVerifying.value = true;
    verifyingUserId.value = user.id;
    
    await axios.post(`/api/admin/users/${user.id}/verify`);
    
    // Update the user in the list
    const index = users.value.findIndex(u => u.id === user.id);
    if (index !== -1) {
      users.value[index] = { ...users.value[index], is_verified: 1 };
    }
    
    // Update selected user if it's the same
    if (selectedUser.value && selectedUser.value.id === user.id) {
      selectedUser.value.is_verified = 1;
    }
  } catch (error) {
    alert('Erreur lors de la vérification de l\'utilisateur');
  } finally {
    isVerifying.value = false;
    verifyingUserId.value = null;
  }
};

// Open delete confirmation dialog
const confirmDelete = (user) => {
  userToDelete.value = user;
  showDeleteDialog.value = true;
};

// Delete user
const deleteUser = async () => {
  if (!userToDelete.value) return;
  
  isDeleting.value = true;
  
  try {
    await axios.delete(`/api/admin/users/${userToDelete.value.id}`);
    
    // Remove the deleted user from the list
    users.value = users.value.filter(user => user.id !== userToDelete.value.id);
    
    // Show success message
    store.dispatch('setAlert', {
      type: 'success',
      message: 'Utilisateur supprimé avec succès'
    });
    
    // Close the dialog
    showDeleteDialog.value = false;
    userToDelete.value = null;
  } catch (err) {
    console.error('Error deleting user:', err);
    
    let errorMessage = 'Échec de la suppression de l\'utilisateur. Veuillez réessayer.';
    
    if (err.response) {
      if (err.response.status === 401) {
        await store.dispatch('auth/logout');
        router.push({ 
          name: 'auth', 
          query: { redirect: router.currentRoute.value.fullPath } 
        });
        errorMessage = 'Votre session a expiré. Veuillez vous reconnecter.';
      } else if (err.response.data?.message) {
        errorMessage = err.response.data.message;
      }
    }
    
    store.dispatch('setAlert', {
      type: 'error',
      message: errorMessage
    });
  } finally {
    isDeleting.value = false;
  }
};

// Lifecycle hooks
onMounted(() => {
  fetchUsers();
});
</script>

<style scoped>
/* Add any custom styles here */
</style>
