<template>
    <div>

        <div class = "header" style="margin-left: 200px" >
            <span v-for="artist in album.artists" >
               <router-link
                            :to="{name: 'artist', params: {id: artist.id}}" class="custom-link"> {{artist.name}}</router-link>
                <span v-if="artist !== album.artists[album.artists.length -1]">, </span>
            </span> <span v-if="album.artists && album.artists.length > 0">-</span>
            <span class="custom-link">{{album.name}}</span>
        </div> <hr>
        <div style="margin-left: 200px" >
            <p class="mention align-items-center">История прослушиваний</p>
            <div class="w-100"  v-if=" album.dairies && album.dairies.length > 0">

                <table class="table">
                    <thead class="thead-light">
                    <tr>
                        <th scope="col">Дата прослушивания</th>
                        <th scope="col">Оценка</th>
                        <th scope="col">Впечатление</th>
                        <th scope="col">Описание</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="dairy in album.dairies">
                        <th scope="row">{{dairy.date}}</th>
                        <td> {{dairy.score}}</td>
                        <td> {{dairy.experience}}</td>
                        <td>{{dairy.description}}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <span v-else class="align-content-center">История пуста </span>
        </div>
    </div>
</template>

<script>
import useItems from "@/composables/itemsAPI";
import {onMounted} from "vue";
import {useRoute} from "vue-router";
import VueHeader from "@/components/UI/VueHeader";
export default {
    name: "AlbumInfo",
    components: {VueHeader},
    setup(){
        const { item, getItemWithRelation, setItemType} = useItems()
        const route =useRoute()

        let album=item
        onMounted(()=>{
            setItemType('album')
            getItemWithRelation(route.params.id)

        })

        return {
            album,
            item,
            // getItem
        }
    },
    created() {
        document.title = "Информация об альбоме"
    }

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
