<template>
    <div class="modal-content">
    <h1>Вход</h1>
    <button class="close-btn" @click="$emit('close')"></button>
     <form @submit.prevent="submit">
        <input type="email" placeholder="E-mail" v-model="form.email">
        <input type="password"  placeholder="Пароль"   v-model="form.password">
        <button type="submit" class="sub-btn">Войти</button>
     </form>
    <p>Нет аккаунта? <a @click.prevent="openModal">Зарегистрируйтесь</a></p>
    </div>
    <div v-if="isModalOpen" class="modal-overlay">
      <RegisterModal @close="closeModal" @success="handleLoginSuccess" />
    </div>
</template>
<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
const emit = defineEmits(['close', 'success']);
import RegisterModal from './RegisterModal.vue';

const form = useForm({
    email: '',
    password: '',
    remember: true,
});

const submit = () => {
    form.post('/login', {
        onSuccess: () => {
            form.reset();
            emit('success');
            emit('close');
        },
        onError: () => {
            form.reset('password');
        }
    });
};

const isModalOpen = ref(false);
const openModal = () => {
  isModalOpen.value = true;
  };
  const closeModal = () => {
  isModalOpen.value = false;
  };
</script>
<style >
    h1{
        font-size: 32px;
        margin-bottom: 25px;
    }
    .close-btn{
        position: absolute;
        top: 27px;
        right: 27px;
        background: url(../../images/close.svg) no-repeat center;
        width: 24px;
        height: 24px; 
    }
.modal-content {
        margin: 150px auto;
        position: relative;
        background:var(--bg-color);
        padding: 32px;
        border-radius: 16px;
        height: 385px;
        width: 352px;
    }
input{
    background: white;
    width: 100%;
    height: 45px;
    padding: 13px;
    border-radius: 10px;
    margin-top: 15px;
}
.sub-btn{
    margin-top: 23px;
    margin-bottom: 35px;
    background: #C7F65B;
    width: 100%;
    height: 45px;
    border-radius: 10px;
}
a{
    color: var(--elem-color);
    padding-left: 5px;
}
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.393);
    display: flex;
    z-index: 999;
  }
</style> 