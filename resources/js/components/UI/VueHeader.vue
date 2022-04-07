<template>
    <header class="p-3 bg-dark  text-white">
        <div class="container-fluid row ">
            <div class="col  text-center"><a :href="$link['albums']" class="custom-link  text-white">Альбомы</a></div>
            <div class="col  text-center"><a :href="$link['dairies']" class="custom-link text-white" >Записи</a></div>
        </div>
    </header>
</template>

<script>
export default {
    name: "VueHeader"
}
</script>

<style scoped>

</style>
