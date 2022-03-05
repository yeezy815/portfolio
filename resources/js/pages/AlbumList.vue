<template>
    <div class="article">
        <p> Все прослушанные альбомы </p>
    </div>
    <select-bar
        @filter="filterAlbums"/>
    <my-dialog v-if="showdialog" @close="showdialog = false">
        <delete-confirm :album = "deletealbum" @cancel="showdialog = false"
                        :message=" 'удалить альбом ' + deletealbum.name + '?' "
                        @confirm="deleteAlbum(deletealbum)"/>
    </my-dialog>
    <my-dialog v-if="addalbum" @close="addalbum = false">
        <div class="container justify-content-md-center" >
            <album-item @confirm="addAlbum"
                        @cancel="addalbum = false"
                        :creation="true"
            />
        </div>
    </my-dialog>
    <div class="album-list" >
        <album-item
            :key="album.id"
            v-for="album in albums"
            :album="album"
            @remove="removeAlbum"
            @confirm="updateAlbum"

        />

    </div>
    <div class="spinner-border" role="status" v-if="showspinner"><span class="visually-hidden">Loading...</span>  </div>
    <div   v-intersection="loadMorePosts" class="observer"></div>
    <div class="fixed-bottom" style="margin: 0 auto; width: 150px; margin-bottom: 10px">
        <button type="button" class="btn btn-info" @click="addalbum = true">добавить альбом</button></div>
</template>

<script>
import AlbumItem from "@/components/albums/AlbumItem";
import MyDialog from "@/components/UI/MyDialog";
import DeleteConfirm from "@/components/albums/DeleteConfirm";
import SelectBar from "@/components/albums/SelectBar";
import CreateForm from "@/components/albums/CreateForm";
import useAlbums from "@/composables/albums";
import {onMounted} from "vue";
export default {
    name: "AlbumList.vue",
    emits: ["remove", "confirm", "cancel"],
    components: {CreateForm, SelectBar, DeleteConfirm, AlbumItem, MyDialog},
    setup(){
        const { albums, getAlbums, destroyAlbum, updateAlbum, createAlbum} = useAlbums()


        onMounted(getAlbums)





        return {
            albums,
            getAlbums,
            destroyAlbum,
            updateAlbum,
            createAlbum
        }
    },
    data(){
        return{
          //  albums:[],
            showdialog: false,
            deletealbum: {},
            addalbum: false,
            page: 0,
            filter: {},
            showspinner : true
        }
    },

    methods:{
        filterAlbums(filter){
            console.log(filter)
            this.filter = filter
            this.albums = []
            this.page = 0
           // this.getAlbums(filter, this.page)
            this.showspinner = true
        },
        addAlbum(album)
        {
            this.createAlbum(album)
            this.addalbum = false
        },
        removeAlbum(album){
            this.showdialog = true;
            this.deletealbum = album
        },
        loadMorePosts(){
            this.page++
            this.getAlbums(this.filter, this.page)
        },
        async deleteAlbum(album){
            this.destroyAlbum(album)
            this.buttons = false;
            this.deletealbum = null
            this.showdialog = false;
        },
    },
}
</script>

<style scoped>
.album-list{
    width:90%;
    margin: 0 auto;
}
.article {
    text-align: center;
    font-size: 20px;
}
.observer{
    height:30px;
}
</style>
