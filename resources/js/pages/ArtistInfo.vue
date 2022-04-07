<template>
    <div>
     <vue-header/>
       <div class = "header" style="margin-left: 200px"> <a :href="$link['artists'] + artist.id" class="custom-link">{{artist.name}}</a> </div> <hr>
            <div style="margin-left: 200px">
                <p class="mention align-items-center">Альбомы исполнителя</p>
                <div v-for="album in artist.albums" style="margin-bottom:10px">
              <a :href="$link['albums'] + album.id" class="custom-link">  Альбом   {{album.name}}   - {{album.year}}г. </a>
                </div>
            </div>
    </div>
</template>

<script>
import useItems from "@/composables/itemsAPI";
import {onMounted} from "vue";
import {useRoute} from "vue-router";
import VueHeader from "@/components/UI/VueHeader";
export default {
    name: "ArtistInfo",
    components: {VueHeader},
    created() {
        document.title = "Информация об исполнителе"
    },
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
