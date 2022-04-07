<template>
    <div  >
        <!--        <div class="spinner-border" role="status" ><span class="visually-hidden">Loading...</span>  </div>-->
        <button class="btn btn-secondary"  @click="$emit('loadMore')">Загрузить еще</button>
    </div>
</template>

<script>
export default {
    name: "ShowMoreItems"
}
</script>

<style scoped>

</style>
