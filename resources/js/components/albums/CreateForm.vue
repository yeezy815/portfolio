<template>
    <album-item
                :creation="true"

                v-model="album"
    />
    <button type="button" class="btn btn-danger" style="margin-right: 10px" @click="$emit('confirm',album)">Добавить</button>
    <button type="button" class="btn btn-primary" @click="$emit('cancel')">Отмена</button>
</template>

<script>
import AlbumItem from "./AlbumItem";
export default {
    emits: ['cancel','confirm'],
    name: "CreateForm",
    components: {AlbumItem},

    data(){
        return{
            album: {
                    id: Date.now(),
                    year: null,
                    name: null,
                    artists: []
                },
        }
    }
}
</script>

<style scoped>

</style>
