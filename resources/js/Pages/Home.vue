<template>
    <Layout>
        <div class="content">
            <h1 class="">Бронируйте  <span>легко</span>  — отдыхайте с удовольствием!</h1>
            <Search />
        </div>
    </Layout>
</template>

<script setup>
import { ref, computed } from 'vue';
import Search from '../Components/Search.vue';
import Layout from '../Layouts/Layout.vue';
import { usePage } from '@inertiajs/vue3';

const page = usePage();

document.title = page.props.title;
const user = computed(() => page.props.auth?.user?.name);

</script>
<style scoped>
    .content{
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    h1{ 
        margin-top: 89px;
        font-size: 38px;
        font-weight: 500;
        margin-bottom: 68px;
    }
    span {
    padding: 0 9px;
    position: relative; 
    display: inline-block; 
}

span::after {
    content: ''; 
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-45%, -36%); 
    width: 277px;
    height: 110px;
    background: url(../../images/Vector.svg) no-repeat center;
    background-size: contain;
}
</style>