<template>
    <my-dialog  @close="$emit('close')">
        <select-bar
            @filter="filterAlbums"/>
        <div style="width:80%">
            <div style="margin-bottom: 5px"
                 v-for="album in albums"
                 @click="$emit('setAlbum',album)">
                Исполнитель:
                <span v-for="artist in album.artists">
                     <span v-if="artist.id !==album.artists[0].id">, </span>
                    {{artist.name}}
                </span>
                Альбом: {{album.name}} - {{album.year}}</div>
            <div class="page-btns">
                <div v-for="page in lastPage"
                     @click="filterAlbums(filter, page)"
                     :class="{'choosed' : page === currentPage}"
                     class="page-btn">
                    {{page}}
                </div>
            </div>
        </div>
    </my-dialog>
</template>

<script>
import MyDialog from "@/components/UI/MyDialog";
import SelectBar from "@/components/albums/SelectBar";
import useItems from "@/composables/itemsAPI";
import {onMounted} from "vue";

export default {
    name: "SelectAlbum",
    emits: ['changePage', 'setAlbum', 'filter'],
    components: {SelectBar, MyDialog},
    setup(){
        const { items, lastPage, currentPage, getItems, destroyItem, updateItem, createItem, setItemType} = useItems()

        let albums = items

        onMounted(() => {
            setItemType("album")
            getItems()
        })

        return {
            albums,
            lastPage,
            currentPage,
            getItems,
            destroyItem,
            updateItem,
            createItem
        }
    },
    data(){
      return{
          filter:{}
      }
    },
    props: {
        albumSettings:{
            type: Object
        }
    },
    methods:{
        filterAlbums(filter, page=1){
            this.filter = filter
            this.getItems(filter, page)
            //this.$emit('filter', filter);
        }
    },
}
</script>

<style scoped>
.page-btns{
    position: absolute;
    left: 50%;
    transform: translate(-50%, -20px);
    border: 3px solid rgba(172,177,150,0.58);
    text-align: center;
}
.page-btn{
    display: inline-block;
    width: 30px;
    height: 30px;
    border: 2px solid #000000;
}
.choosed{
    background-color: green;
}
</style>
