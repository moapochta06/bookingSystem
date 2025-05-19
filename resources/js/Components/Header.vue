<template>
    <div class="navbar">
      <Link href="/">Главная</Link>
      <Link href="/objects" v-if="isAdmin">Объекты</Link>
      <Link href="/bookings" v-if="isAdmin">Бронирования</Link>
      <a href="#" @click.prevent="openModal" v-if="!isAuthenticated">Войти</a>
      <button @click="logout" v-else>Выйти</button>
    </div>
    <!-- Модальное окно входа -->
    <div v-if="isModalOpen" class="modal-overlay">
        <LoginModal
            @close="closeModal"
            @success="handleLoginSuccess"
        />
    </div>
  </template>
  
  <script setup>
  import { computed,ref } from 'vue';
  import { usePage, Link, router } from '@inertiajs/vue3';
  import LoginModal from './LoginModal.vue';
  const page = usePage();

  const isModalOpen = ref(false);

  const openModal = () => {
  isModalOpen.value = true;
  };
  const closeModal = () => {
  isModalOpen.value = false;
  };

  const isAuthenticated = computed(() => !!page.props.auth?.user);

  const isAdmin = computed(() => page.props.auth?.user?.is_admin);
  const handleLoginSuccess = () => {
    console.log('Авторизация успешна');
    closeModal();
  };
  
  const logout = () => {
    router.post('/logout');
  };
  
  </script>
  
  <style scoped>
  .navbar {
    display: flex;
    justify-content: flex-end;
    margin-top: 38px;
    gap: 30px;
  }
  
  a, button {
    font-weight: 500;
    cursor: pointer;
    background: none;
    border: none;
    padding: 0;
    color: inherit;
    font: inherit;
  }
  
  .modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.293);
    display: flex;
    z-index: 999;
  }
  </style>