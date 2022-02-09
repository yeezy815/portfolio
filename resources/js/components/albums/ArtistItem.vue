<template>
    <div @mouseover="showdelete = true" @mouseleave="showdelete = false" style="height: 35px">
        <my-input v-model="artist.name" placeholder="исполнитель" style="width: 50%"/>

        <button class="btn btn-danger" @click="$emit('remove', artist)" v-show="showdelete" style="height: 100%">x</button>
    </div>
</template>

<script>
import MyInput from "../UI/MyInput";
export default {
    name: "ArtistItem",
    components: {MyInput},
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

</style>
