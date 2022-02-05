<template>
   <div class="article">
       <p> Все прослушанные альбомы </p>
   </div>
    <select-bar
    @filter="fetchAlbums"/>
    <my-dialog v-if="showdialog">
       <delete-confitm :album = "deletealbum" @cancel="showdialog = false"
       @confirm="deleteAlbum"/>
    </my-dialog>
    <my-dialog v-if="addalbum" >
<!--        <create-form @cancel="addalbum = false" @confirm="test"/>-->
        <div class="container">
    <album-item @confirm="addAlbum"
                @cancel="addalbum = false"
                :creation="true"
    />
        </div>
    </my-dialog>
    <div class="album-list">
        <album-item
            v-for="album in albums"
            :album="album"
            @remove="removeAlbum"
            @confirm="updateAlbum"

        />
    </div>
    <div class="fixed-bottom" style="margin: 0 auto; width: 150px; margin-bottom: 10px">
        <button type="button" class="btn btn-info" @click="addalbum = true">добавить альбом</button></div>
</template>

<script>
import AlbumItem from "@/components/albums/AlbumItem";
import MyDialog from "../UI/MyDialog";
import DeleteConfitm from "./DeleteConfitm";
import SelectBar from "./SelectBar";
import CreateForm from "./CreateForm";
export default {
    name: "AlbumsIndex.vue",
    emits: ["remove", "confirm", "cancel"],
    components: {CreateForm, SelectBar, DeleteConfitm, AlbumItem, MyDialog},
    data(){
        return{
            albums:[],
            showdialog: false,
            deletealbum: {},
            addalbum: false
        }
    },

    methods:{
        search(filter){
            console.log(filter)
        },
        async addAlbum(album)
        {
            const newar = [];
            album.artists.forEach(element => newar.push(element.name));
            console.log(album);
            try{
                const response = await axios.post('api/albums/',
                    {
                        artists: newar,
                        name: album.name,
                        year: album.year,

                    }

                );

                 if (response.status === 200){
                     this.addalbum = false
                     this.albums.push(album)
                 }
                //     this.updatestatus = "данные успешно обновлены";
                // else
                //     this.updatestatus = "не удалось обновить данные";
                // this.buttons = false;
                console.log( response);

            }
            catch(e){
                alert(e);
            }
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
            //this.albums=this.albums.filter(p => p.id !== album.id);
        },
        async updateAlbum(album){
            const newar = [];
            album.artists.forEach(element => newar.push(element.name));
            console.log(newar);
            try{
                const response = await axios.put('api/albums/' + album.id,
                    {
                        artists: newar,
                        name: album.name,
                        year: album.year,

                    }
                );
                // if (response.status === 200)
                //     this.updatestatus = "данные успешно обновлены";
                // else
                //     this.updatestatus = "не удалось обновить данные";
                // this.buttons = false;
                console.log( response);

            }
            catch(e){
                alert(e);
            }
        },
        async deleteAlbum(album){
                console.log(album)
            try{
                  const response = await axios.delete('api/albums/' + album.id);
                  if (response.status === 200) {
                     this.updatestatus = "данные успешно обновлены";
                     this.buttons = false;
                     this.albums=this.albums.filter(p => p.id !== album.id);
                     this.deletealbum = null
                //this.$emit('remove',this.album);
                  }
                  else
                     this.updatestatus = "не удалось обновить данные";


            }
            catch(e){
                alert(e);
            }
            this.showdialog = false;
        },
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
