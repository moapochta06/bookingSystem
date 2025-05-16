<template>
    <Layout>
        <div class="content">
            <h1 class="">Бронируйте  <span>легко</span>  — отдыхайте с удовольствием!</h1>
            <p v-if="user">Здравствуйте, {{ user }}</p>
            <Search />
        </div>
    </Layout>
</template>

<script setup>
import { ref, computed } from 'vue';
import Search from '../Components/Search.vue';
import Layout from '../Layouts/Layout.vue';
// import { watch,computed} from 'vue';
import { usePage } from '@inertiajs/vue3';

const page = usePage();
// Устанавливаем начальное значение заголовка
document.title = page.props.title;
const user = computed(() => page.props.auth?.user?.name);
// const user = ref(page.props.auth?.user.name);
// // Создаём реактивное свойство
// const title = computed(() => page.props.title);

// // Следим за изменениями
// watch(title, (newTitle) => {
//     console.log('New title:', newTitle);
//     document.title = newTitle;
// });
</script>
<style scoped>
    .content{
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    h1{ 
        margin-top: 148px;
        font-size: 32px;
        font-weight: 500;
        margin-bottom: 89px;
    }
    span {
    padding: 0 5px;
    position: relative; 
    display: inline-block; 
}

span::after {
    content: ''; 
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-45%, -36%); 
    width: 222px;
    height: 84px;
    background: url(../../images/Vector.svg) no-repeat center;
    background-size: contain;
}
</style>