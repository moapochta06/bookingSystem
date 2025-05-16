<template>
    <div class="modal-content">
    <h1>Создайте аккаунт</h1>
    <button class="close-btn" @click="$emit('close')"></button>
     <form @submit.prevent="submit">
        <input type="name" placeholder="Имя" v-model="form.name">
        <span v-if="form.errors.name" class="text-danger">{{ form.errors.name }}</span>
        <input type="email" placeholder="E-mail" v-model="form.email">
        <span v-if="form.errors.email" class="text-danger">{{ form.errors.email }}</span>
        <input type="password"  placeholder="Пароль" v-model="form.password">
        <span v-if="form.errors.password" class="text-danger">{{ form.errors.password }}</span>
        <input type="password"  placeholder="Пароль повторно" v-model="form.password_confirmation" >
        <button type="submit" class="sub-btn">Зарегистрироваться</button>
     </form>
    <p>или <a @click.prevent="openModal">войдите</a></p>
    </div>
</template>
<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
const emit = defineEmits(['close',]);
const form = useForm({
    email: '',
    password: '',
    name:'',
    password_confirmation: '',
});
const submit = () => {
    form.post('/register', {
        onSuccess: () => {
            form.reset();
            emit('close');
          console.log('Регистрация успешна');
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
</script>
<style scoped>
.modal-content {
        margin: 100px auto;
        position: relative;
        background:var(--bg-color);
        padding: 32px;
        border-radius: 16px;
        height: fit-content;
        width: 359px;
    }
    .sub-btn{
    margin-top: 23px;
    margin-bottom: 23px;
    background: #C7F65B;
    width: 100%;
    height: 45px;
    border-radius: 10px;
}
</style>