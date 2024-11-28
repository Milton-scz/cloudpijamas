<template>
    <div>
      <!-- Contenido de la página -->
      <Header @search="handleSearch" />

      <LandigHero />
      <!-- Sección principal del contenido -->
      <MainContent />
      <Catalogo :productos="productos" /> <!-- Pasa los productos aquí -->
      <!-- El contenido principal de la página -->

      <!-- Footer -->
      <Footer :pageview="pageview" />
    </div>
  </template>

  <script setup>
  import { ref } from 'vue';
  import axios from 'axios';
  import Header from '@/Pages/LandingPage/Components/Header.vue';  // Importa el Header
  import Footer from '@/Pages/LandingPage/Components/Footer.vue';  // Importa el Footer
  import MainContent from '@/Pages/LandingPage/Components/Maincontent.vue';
  import LandigHero from '@/Pages/LandingPage/Components/landing-hero.vue';
  import Catalogo from '@/Pages/LandingPage/Components/Catalogo.vue';
  import { usePage } from '@inertiajs/vue3';

  const page = usePage();
  let productos = ref(page.props.productos); // Debería ser un ref
  const pageview = ref(page.props.pageview);

  // Manejar el término de búsqueda recibido del Header
  const handleSearch = async (searchTerm) => {
    try {
      const response = await axios.get(route('landing.productos.search'), {
        params: { search: searchTerm },
      });

      // Asigna correctamente el valor a productos
      productos.value = response.data.productos.data;
      console.log('Productos encontrados:', productos.value); // Verifica el contenido de productos
    } catch (error) {
      console.error('Error buscando productos:', error);
    }
  };
  </script>

  <style scoped>
  /* Agregar estilos generales aquí si es necesario */
  </style>
