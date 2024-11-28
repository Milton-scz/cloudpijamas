<template>
    <header class="site-navbar">
      <div class="container">
        <div class="row">
          <div class="col-12 d-flex justify-content-between align-items-center">
            <!-- Contenedor de logo a la izquierda -->
            <div class="flex-left">
              Pijamas Cloud
            </div>

            <!-- Contenedor de buscador centrado -->
            <div class="flex-center">
              <form @submit.prevent="submitForm" class="flex-left w-full max-w-4xl"> <!-- Aumento el tamaño máximo -->
                <div class="relative flex items-stretch w-full">
                  <input
                    type="search"
                    v-model="form.search"
                    placeholder="Buscar productos"
                    class="block p-4 w-full text-sm text-gray-900 bg-white rounded-lg border"
                  />
                  <button
                    type="submit"
                    class="ml-2 text-red bg-red-500 hover:bg-red-200 focus:outline-none"
                  >
                    Buscar
                  </button>
                </div>
              </form>
            </div>

            <!-- Contenedor del menú de navegación a la derecha -->
            <nav class="flex justify-end">
  <ul class="nav-list">
    <li> <Link
            :href="route('/')"
            method="get"
            as="button">
            Home
        </Link></li>
    <li>
        <Link
            :href="route('landing.productos')"
            method="get"
            as="button">
            Productos
        </Link>
    </li>
  </ul>
</nav>

          </div>
        </div>
      </div>
    </header>
  </template>

  <script setup>
  import { Link, useForm } from '@inertiajs/vue3';

  const form = useForm({
    search: '',
  });

  const emit = defineEmits(['search']);
  const submitForm = () => {
    emit('search', form.search); // Emitir evento con el término de búsqueda
  };
  </script>

  <style scoped>
  /* Estilos básicos para el header */
  .site-navbar {
    position: fixed; /* Fijar el header en la parte superior */
    top: 0;
    left: 0;
    right: 0;
    background-color: #2e77d6;
    padding: 10px 0;
    color: white;
    z-index: 1000; /* Asegura que el header esté sobre otros elementos */
  }

  .site-logo {
    font-size: 1.8rem;
    color: white;
    text-decoration: none;
  }

  .nav-list {
    list-style: none;
    margin: 0;
    padding: 0;
    display: flex; /* Usar flex para alinear los items en una fila */
  }

  .nav-list li {
    margin: 0 20px;
  }

  .nav-list li a {
    color: white;
    text-decoration: none;
    font-size: 1.1rem;
  }

  .nav-list li a:hover {
    text-decoration: underline;
  }

  body {
    padding-top: 70px; /* Ajusta este valor dependiendo de la altura de tu header */
  }

  /* Organiza el header */
  .d-flex {
    display: flex;
    justify-content: space-between; /* Distribuye el contenido entre los elementos */
    align-items: center;
    width: 100%;
  }

  /* Contenedor de logo alineado a la izquierda */
  .flex-left {
    display: flex;
    align-items: center;
  }

  /* Contenedor del buscador centrado */
  .flex-center {
    display: flex;
    justify-content: center; /* Centra el contenido */
    flex: 1; /* Hace que el contenedor ocupe el máximo espacio disponible */
    text-align: center; /* Asegura que el formulario se centre */
  }

  /* Contenedor del formulario de búsqueda con ancho máximo más grande */
  form.w-full {
    max-width: 700px; /* Aumento el tamaño máximo del formulario */
  }

  /* Contenedor del menú de navegación alineado a la derecha */
  .flex-right {
    display: flex;
    align-items: center;
    margin-left: auto; /* Alinea los elementos de navegación a la derecha */
  }
  </style>
