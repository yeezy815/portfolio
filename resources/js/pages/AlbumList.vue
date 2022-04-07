<template>
    <vue-header/>
    <div class="article">
        <p> Все прослушанные альбомы </p>
    </div>
    <select-bar
        @filter="filterAlbums"/>
    <my-dialog v-if="showPopUp" @close="showPopUp = false">
        <delete-confirm
            :album = "deletingAlbum" @cancel="showPopUp = false"
            :message=" 'удалить альбом ' + deletingAlbum.name + '?' "
            @confirm="confirmAlbumDeletion(deletingAlbum)"
        />
    </my-dialog>
    <my-dialog v-if="showAddAlbum" @close="showAddAlbum = false">
        <div class="container justify-content-md-center" >
            <album-item
                @confirm="addAlbum"
                @cancel="showAddAlbum = false"
                :creation="true"
            />
        </div>
    </my-dialog>
    <div class="item-list" >
        <album-item
            :key="album.id"
            v-for="album in albums"
            :album="album"
            @remove="askToRemoveAlbum"
            @confirm="updateItem"
        />
    </div>
    <show-more-items v-show="!isLastPage"
    @loadMore="loadMorePosts"
    />
<!--    <div   v-intersection="loadMorePosts" class="observer"></div>-->
    <div class="fixed-bottom" style="margin: 0 auto; width: 150px; margin-bottom: 10px">
        <button type="button" class="btn btn-info" @click="showAddAlbum = true">добавить альбом</button></div>
</template>

<script>
import AlbumItem from "@/components/albums/AlbumItem";
import MyDialog from "@/components/UI/MyDialog";
import DeleteConfirm from "@/components/albums/DeleteConfirm";
import SelectBar from "@/components/albums/SelectBar";
import CreateForm from "@/components/albums/CreateForm";
import useItems from "@/composables/itemsAPI";
import {onMounted} from "vue";
import ShowMoreItems from "@/components/UI/ShowMoreItems";
import VueHeader from "@/components/UI/VueHeader";
export default {
    name: "AlbumList.vue",
    emits: ["remove", "confirm", "cancel"],
    components: {VueHeader, ShowMoreItems, CreateForm, SelectBar, DeleteConfirm, AlbumItem, MyDialog},
    setup(){
        const { items, getItems, destroyItem, updateItem, createItem, isLastPage, setItemType, currentPage} = useItems()

        let albums=items
         onMounted(()=>{
             setItemType('album')
             getItems()
         })

        return {
            albums,
            isLastPage,
            currentPage,
            getItems,
            destroyItem,
            updateItem,
            createItem
        }
    },
    data(){
        return{
            showPopUp: false,
            deletingAlbum: {},
            showAddAlbum: false,
            filter: null,
            showSpinner : true
        }
    },

    methods:{
        filterAlbums(filter){
            this.filter = filter
            this.albums = []
            this.currentPage = 0
            this.loadMorePosts()
            this.showSpinner = true
        },
        addAlbum(album) {
            this.createItem(album)
            this.showAddAlbum = false
        },
        askToRemoveAlbum(album){
            this.showPopUp = true;
            this.deletingAlbum = album
        },
        loadMorePosts(){
            this.getItems(this.filter)
        },
        async confirmAlbumDeletion(album){
            this.destroyItem(album)
            this.deletingAlbum = null
            this.showPopUp = false;
        },
    },
    created() {
        document.title = "Альбомы"
    }
}
</script>

<style scoped>

.observer{
    height:30px;
}
</style>
