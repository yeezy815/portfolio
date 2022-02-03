<template>
   <div class="article">
       <p> Все прослушанные альбомы </p>
   </div>
    <select-bar
    @filter="fetchAlbums"/>
    <my-dialog v-if="showdialog">
       <delete-confitm :album = "deletealbum"/>
    </my-dialog>
    <div class="album-list">
        <album-item
            v-for="album in albums"
            :album="album"
            @remove="removeAlbum"
        />
    </div>
    <div class="fixed-bottom" style="margin: 0 auto; width: 150px; margin-bottom: 10px">
        <button type="button" class="btn btn-info" @click="addAlbum">добавить альбом</button></div>
</template>

<script>
import AlbumItem from "@/components/albums/AlbumItem";
import MyDialog from "../UI/MyDialog";
import DeleteConfitm from "./DeleteConfitm";
import SelectBar from "./SelectBar";
export default {
    name: "AlbumsIndex.vue",
    emits: ["remove"],
    components: {SelectBar, DeleteConfitm, AlbumItem, MyDialog},
    data(){
        return{
            albums:[],
            showdialog: false,
            deletealbum: {}
        }
    },

    methods:{
        search(filter){
            console.log(filter)
        },
        async fetchAlbums(filter = null){
            if (filter !== null) {
                Object.keys(filter).forEach(key => {
                    if (filter[key] === null || filter[key] === '') {
                        delete filter[key];
                    }
                });
            }
            console.log(filter)
            const params = filter

            try{
                const response = await axios.get('api/albums', {params: params} );
               this.albums = response.data;

            }
            catch(e){
                alert(e);
            }
        },
        removeAlbum(album){
            this.showdialog = true;
            this.deletealbum = album
            this.albums=this.albums.filter(p => p.id !== album.id);
        }
    },
    mounted() {
       this.fetchAlbums()
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
</style>
