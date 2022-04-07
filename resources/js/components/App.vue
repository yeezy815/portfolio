<template>
    <header class="p-3 bg-dark  text-white">
        <div class="container-fluid row ">
            <div class="col  text-center"><router-link :to="{name: 'albums'}"  class="custom-link  text-white">Альбомы</router-link></div>
            <div class="col  text-center"><router-link :to="{name: 'dairy'}"  class="custom-link text-white" >Записи</router-link></div>
        </div>
    </header>
    <router-view></router-view>
</template>
<script>

</script>
<style>

</style>
