<template>
  <div id="app">
    <nav class="bg-white shadow-lg">
      <div class="max-w-7xl mx-auto px-4">
        <div class="flex justify-between h-16">
          <div class="flex">
            <div class="flex-shrink-0 flex items-center">
              <h1 class="text-xl font-bold text-indigo-600">SeknaConnect</h1>
            </div>
          </div>
          <div class="hidden md:ml-6 md:flex md:items-center md:space-x-8">
            <a href="#" class="text-gray-900 inline-flex items-center px-1 pt-1 border-b-2 border-indigo-500 text-sm font-medium">
              Home
            </a>
            <a href="#" class="text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium">
              Properties
            </a>
            <a href="#" class="text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium">
              About
            </a>
            <a href="#" class="text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium">
              Contact
            </a>
          </div>
        </div>
      </div>
    </nav>

    <main class="bg-gray-50 min-h-screen">
      <router-view></router-view>
    </main>

    <footer class="bg-gray-800 text-white py-8">
      <div class="max-w-7xl mx-auto px-4">
        <div class="md:flex md:justify-between">
          <div class="mb-8 md:mb-0">
            <h2 class="text-2xl font-bold mb-4">SeknaConnect</h2>
            <p class="text-gray-400">Find your dream property with us</p>
          </div>
          <div class="grid grid-cols-2 gap-8 sm:grid-cols-3">
            <div>
              <h3 class="text-sm font-semibold uppercase tracking-wider">Company</h3>
              <ul class="mt-4 space-y-2">
                <li><a href="#" class="text-gray-400 hover:text-white">About</a></li>
                <li><a href="#" class="text-gray-400 hover:text-white">Careers</a></li>
                <li><a href="#" class="text-gray-400 hover:text-white">Contact</a></li>
              </ul>
            </div>
            <div>
              <h3 class="text-sm font-semibold uppercase tracking-wider">Legal</h3>
              <ul class="mt-4 space-y-2">
                <li><a href="#" class="text-gray-400 hover:text-white">Privacy</a></li>
                <li><a href="#" class="text-gray-400 hover:text-white">Terms</a></li>
                <li><a href="#" class="text-gray-400 hover:text-white">Cookie Policy</a></li>
              </ul>
            </div>
          </div>
        </div>
        <div class="mt-8 border-t border-gray-700 pt-8">
          <p class="text-gray-400 text-sm text-center">&copy; 2023 SeknaConnect. All rights reserved.</p>
        </div>
      </div>
    </footer>
  </div>
</template>

<script>
export default {
  name: 'App',
}
</script>

<style scoped>
/* Add any custom styles here */
</style>
