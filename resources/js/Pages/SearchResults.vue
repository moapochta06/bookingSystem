 <template>
    <Layout>
    <Search/>
        <div v-for="object in estateObjects" :key="object.id" class="object-card ">
            <img  v-if="object.image && object.image !== 'null'" :src="`/storage/${object.image}`" alt="Изображение объекта" class="object-cover">

            <div class="w-full">
                <div>
                    <h4>{{ object.title }}</h4>
                    <span>{{ object.area }} м²</span>
                    <span>{{ object.rooms_count }} комнаты</span>
                    <span>{{ object.guests_count }} гостя</span>
                    <div class="price">{{ object.price }} ₽ <span>за сутки</span></div>
                </div>
                
                    <div class="flex justify-between ">
                        <div cclass="adress">{{ object.city }}, ул.{{ object.street }}, д.{{ object.house_number }}, кв.{{ object.apartment_number }}</div>
                        <Link :href="`/objects/estate/${object.id}?from=${from}&to=${to}&guests=${guests}`">Подробнее</Link>
                    </div>
            
                
                
            </div>
        </div>
    </Layout>
</template>
<script setup>
import Layout from '../Layouts/Layout.vue'
import Search from '../Components/Search.vue'
import { router, usePage, Link } from '@inertiajs/vue3'

const page = usePage();
const { estateObjects } = usePage().props
document.title = page.props.title;

const urlParams = new URLSearchParams(window.location.search)
const from = urlParams.get('from')
const to = urlParams.get('to')
const guests = urlParams.get('guests')
</script>
<style scoped>
h4 {
    font-size: 24px;
    font-weight: 600;
    line-height: 30px;
    margin-bottom: 10px;
}
.object-card {
    width: 857px;
    height: 241px;
    margin: 0 auto;
    display: flex;
    background: #fff;
    margin-bottom: 20px;
    border-radius: 20px;
}
img {
    min-width: 367px;
    border-radius: 20px 0 0 20px ;
}
.object-card > div {
    position: relative;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    padding: 24px 70px 28px 28px;
}
.object-card > div > div > span {
    font-size: 15px;
    color: #6B6B6B;
    margin-top: 8px;
    margin-right: 14px;
}
.price {
    background: url();
    font-size: 20px;
    font-weight: 600;
    margin-top: 15px;
}
.price > span {
    font-size: 15px;
}
.adress {
    font-size: 14px;
}
a {
    position: absolute;
    right: 39px;
}
</style>