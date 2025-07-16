<template>
  <div class="min-h-screen bg-gray-50">
    <!-- Hero Section -->
    <div class="relative bg-gradient-to-r from-purple-700 to-indigo-800 text-white py-24">
      <div class="absolute inset-0 bg-black/30"></div>
      <div class="container mx-auto px-4 relative z-10">
        <div class="max-w-4xl mx-auto text-center">
          <h1 class="text-4xl md:text-5xl font-bold mb-6">À propos de SeknaConnect</h1>
          <p class="text-xl text-purple-100 max-w-3xl mx-auto">
            Vous connecter à la propriété de vos rêves grâce à l'innovation, l'intégrité et un service exceptionnel.
          </p>
        </div>
      </div>
    </div>

    <!-- Our Story Section -->
    <div class="py-16 bg-white">
      <div class="container mx-auto px-4">
        <div class="max-w-5xl mx-auto">
          <div class="grid md:grid-cols-2 gap-12 items-center">
            <div class="space-y-6">
              <h2 class="text-3xl font-bold text-gray-900">Notre Histoire</h2>
              <p class="text-gray-600 leading-relaxed">
                Fondée en 2023, SeknaConnect est née d'une idée simple : transformer l'expérience immobilière en la rendant plus transparente, efficace et agréable pour tous les acteurs concernés.
              </p>
              <p class="text-gray-600 leading-relaxed">
                Ce qui a commencé comme une petite équipe de professionnels passionnés de l'immobilier est devenu une plateforme de confiance reliant des milliers d'acheteurs, de vendeurs et de locataires à leurs propriétés idéales.
              </p>
              <div class="bg-purple-50 p-6 rounded-xl border-l-4 border-purple-500">
                <p class="text-purple-800 font-medium italic">
                  "Notre mission est de simplifier les transactions immobilières et d'aider les gens à trouver non seulement une maison, mais un endroit où se sentir chez soi."
                </p>
              </div>
            </div>
            <div class="relative rounded-xl overflow-hidden shadow-xl">
              <img 
                src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80" 
                alt="Our team"
                class="w-full h-full object-cover aspect-video"
              >
              <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
              <div class="absolute bottom-0 left-0 p-6 text-white">
                <p class="text-sm font-medium">Notre équipe lors de la conférence annuelle sur l'immobilier 2024</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Our Values -->
    <div class="py-16 bg-gradient-to-br from-purple-50 to-indigo-50">
      <div class="container mx-auto px-4">
        <div class="text-center mb-16">
          <h2 class="text-3xl font-bold text-gray-900 mb-4">Nos Valeurs Fondamentales</h2>
          <p class="text-xl text-gray-600 max-w-3xl mx-auto">
            Ces principes guident tout ce que nous faisons chez SeknaConnect
          </p>
        </div>
        
        <div class="grid md:grid-cols-3 gap-8 max-w-6xl mx-auto">
          <!-- Value 1 -->
          <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-xl transition-shadow">
            <div class="w-14 h-14 bg-purple-100 rounded-xl flex items-center justify-center mb-6">
              <svg class="h-8 w-8 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
              </svg>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-3">Intégrité</h3>
            <p class="text-gray-600">
              Nous croyons en une transparence et une honnêteté totales dans toutes nos transactions, vous garantissant de pouvoir nous faire confiance pour votre parcours immobilier.
            </p>
          </div>
          
          <!-- Value 2 -->
          <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-xl transition-shadow">
            <div class="w-14 h-14 bg-purple-100 rounded-xl flex items-center justify-center mb-6">
              <svg class="h-8 w-8 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
              </svg>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-3">Innovation</h3>
            <p class="text-gray-600">
              Nous utilisons une technologie de pointe pour simplifier la recherche de biens et le processus de transaction, vous faisant gagner du temps et des efforts.
            </p>
          </div>
          
          <!-- Value 3 -->
          <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-xl transition-shadow">
            <div class="w-14 h-14 bg-purple-100 rounded-xl flex items-center justify-center mb-6">
              <svg class="h-8 w-8 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
              </svg>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-3">Communauté</h3>
            <p class="text-gray-600">
              Nous nous engageons à construire des relations solides et à redonner aux communautés que nous servons, car une maison est là où se trouve le cœur.
            </p>
          </div>
        </div>
      </div>
    </div>

    <!-- Team Section -->
    <div class="py-16 bg-white">
      <div class="container mx-auto px-4">
        <div class="text-center mb-16">
          <h2 class="text-3xl font-bold text-gray-900 mb-4">Rencontrez Notre Équipe de Direction</h2>
          <p class="text-xl text-gray-600 max-w-3xl mx-auto">
            Les passionnés qui font avancer SeknaConnect
          </p>
        </div>
        
        <div class="grid md:grid-cols-3 gap-8 max-w-6xl mx-auto">
          <!-- Team Member 1 -->
          <div class="text-center">
            <div class="w-48 h-48 mx-auto mb-6 rounded-full overflow-hidden border-4 border-white shadow-xl">
              <img 
                src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=774&q=80" 
                alt="Sarah Johnson"
                class="w-full h-full object-cover"
              >
            </div>
            <h3 class="text-xl font-semibold text-gray-900">Sarah Johnson</h3>
            <p class="text-purple-600 font-medium mb-2">CEO & Founder</p>
            <p class="text-gray-600 text-sm max-w-xs mx-auto">
              Avec plus de 15 ans d'expérience dans l'immobilier, Sarah a fondé SeknaConnect pour révolutionner le secteur.
            </p>
          </div>
          
          <!-- Team Member 2 -->
          <div class="text-center">
            <div class="w-48 h-48 mx-auto mb-6 rounded-full overflow-hidden border-4 border-white shadow-xl">
              <img 
                src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=774&q=80" 
                alt="Michael Chen"
                class="w-full h-full object-cover"
              >
            </div>
            <h3 class="text-xl font-semibold text-gray-900">Michael Chen</h3>
            <p class="text-purple-600 font-medium mb-2">CTO</p>
            <p class="text-gray-600 text-sm max-w-xs mx-auto">
              Visionnaire technologique passionné par la création d'expériences numériques fluides dans l'immobilier.
            </p>
          </div>
          
          <!-- Team Member 3 -->
          <div class="text-center">
            <div class="w-48 h-48 mx-auto mb-6 rounded-full overflow-hidden border-4 border-white shadow-xl">
              <img 
                src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=870&q=80" 
                alt="Emily Rodriguez"
                class="w-full h-full object-cover"
              >
            </div>
            <h3 class="text-xl font-semibold text-gray-900">Emily Rodriguez</h3>
            <p class="text-purple-600 font-medium mb-2">Head of Customer Success</p>
            <p class="text-gray-600 text-sm max-w-xs mx-auto">
              Dédiée à garantir à chaque client une expérience exceptionnelle avec SeknaConnect.
            </p>
          </div>
        </div>
      </div>
    </div>

    <!-- CTA Section -->
    <div class="bg-gradient-to-r from-purple-600 to-indigo-700 text-white py-16">
      <div class="container mx-auto px-4 text-center">
        <h2 class="text-3xl font-bold mb-4">Prêt à trouver la maison de vos rêves ?</h2>
        <p class="text-xl text-purple-100 mb-8 max-w-2xl mx-auto">
          Rejoignez des milliers de clients satisfaits qui ont trouvé leur propriété idéale avec SeknaConnect.
        </p>
        <div class="flex flex-col sm:flex-row justify-center gap-4">
          <router-link 
            to="/properties" 
            class="bg-white text-purple-700 hover:bg-purple-50 font-medium py-3 px-8 rounded-lg transition-all duration-300 transform hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-white"
          >
            Voir les propriétés
          </router-link>
          <router-link 
            to="/contact" 
            class="bg-transparent border-2 border-white text-white hover:bg-white/10 font-medium py-3 px-8 rounded-lg transition-all duration-300 transform hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-white"
          >
            Contactez-nous
          </router-link>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'About',
  setup() {
    return {
      // Component logic here
    };
  }
};
</script>

<style scoped>
/* Custom styles if needed */
</style>
