<template>
    <div class="container">
        <div class="container-select">
            <a href="admin/select_restaurant/1">
                <div class="select-li col-md-3" v-for="value in restaurantList">
                    <h3>{{ value.restaurants_name }}</h3>
                    <p>联系方式：{{ value.phone }}</p>
                    <p>地址：{{ value.address }}</p>
                    <p>创建时间：{{ value.created_at }}</p>
                </div>
            </a>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['restaurants'],
        mounted() {

        },
        data(){
            return {
                restaurantList: this.restaurants
            }
        },
        methods: {},
    }
</script>