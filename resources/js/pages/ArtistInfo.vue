<template>
    <div>
       <div class = "header" style="margin-left: 200px">  {{artist.name}}</div> <hr>
            <div style="margin-left: 200px">
                <p class="mention align-items-center">Альбомы исполнителя</p>
                <div v-for="album in artist.albums" style="margin-bottom:10px">
               Альбом     {{album.name}} - {{album.year}}г.
                </div>
            </div>
        <div class="fixed-bottom" style="margin: 0 auto; width: 150px; margin-bottom: 10px">
            <button type="button" class="btn btn-dark">добавить альбом</button></div>
    </div>
</template>

<script>
import useItems from "@/composables/itemsAPI";
import {onMounted} from "vue";
import {useRoute} from "vue-router";
export default {
    name: "ArtistInfo",
    setup(){
        const { item, getItem, setItemType} = useItems()
        const route =useRoute()

        let artist=item
        onMounted(()=>{
            setItemType('artist')
            getItem(route.params.id)

        })

        return {
            artist,
            item,
            getItem
        }
    },
}
</script>

<style scoped>
.header{
    font-size: 40px;

}
.mention {
    font-size: 20px
}
</style>
