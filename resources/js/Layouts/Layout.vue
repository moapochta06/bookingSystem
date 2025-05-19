<template>
    <div class="layout">
        <Header />
        <main>
            <slot />
        </main>
        <footer>
            <!-- <p>&copy; 2023 My App</p> -->
        </footer>
    </div>
</template>

<script setup>
import Header from '../Components/Header.vue';
</script>

<style scoped>
    .layout{
        /* padding: 0 224px; */
        max-width: 922px;
        margin: 0 auto;
    }
</style>