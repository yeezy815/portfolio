<template>
    <div @mouseover="showdelete = true" @mouseleave="showdelete = false">
        <input v-model="artist.name" placeholder="исполнитель">

        <button class="btn btn-danger" @click="$emit('remove', artist)" v-if="showdelete">x</button>
    </div>
</template>

<script>
export default {
    name: "ArtistItem",
    emits: ['remove'],
    props:{
        artist:{
            type: Object,
            required: false
        }
    },
    data(){
        return{
            showdelete: false
        }
    }
}
</script>

<style scoped>
input{
    background: none;
    border: 0;
    font-size: 15px;
    outline:none;
}
</style>
