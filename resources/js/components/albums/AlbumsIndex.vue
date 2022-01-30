<template>
   <div class="article">
       <p> Все прослушанные альбомы </p>
   </div>
    <div class="album-list">
        <album-item
            v-for="album in albums"
            :album="album"

        />
    </div>

</template>

<script>
import AlbumItem from "@/components/albums/AlbumItem";
export default {
    name: "AlbumsIndex.vue",
    components: {AlbumItem},
    data(){
        return{
            albums:[]
        }
    },

    methods:{
        async fetchAlbums(){
            try{
                const response = await axios.get('api/albums');
               this.albums = response.data;

            }
            catch(e){
                alert('error');
            }
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
