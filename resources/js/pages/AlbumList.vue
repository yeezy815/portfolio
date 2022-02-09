<template>
    <div class="article">
        <p> Все прослушанные альбомы </p>
    </div>
    <select-bar
        @filter="filterAlbums"/>
    <my-dialog v-if="showdialog">
        <delete-confirm :album = "deletealbum" @cancel="showdialog = false"
                        :message=" 'удалить альбом ' + deletealbum.name + '?' "
                        @confirm="deleteAlbum(deletealbum)"/>
    </my-dialog>
    <my-dialog v-if="addalbum" >
        <!--        <create-form @cancel="addalbum = false" @confirm="test"/>-->
        <div class="container justify-content-md-center" >
            <album-item @confirm="addAlbum"
                        @cancel="addalbum = false"
                        :creation="true"
            />
        </div>
    </my-dialog>
    <div class="album-list" >
        <album-item
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
export default {
    name: "AlbumList.vue",
    emits: ["remove", "confirm", "cancel"],
    components: {CreateForm, SelectBar, DeleteConfirm, AlbumItem, MyDialog},
    data(){
        return{
            albums:[],
            showdialog: false,
            deletealbum: {},
            addalbum: false,
            page: 0,
            filter: {},
            showspinner : true
        }
    },

    methods:{
        search(filter){
            console.log(filter)
        },
        filterAlbums(filter){
            this.filter = filter
            this.albums = []
            this.page = 0
            this.showspinner = true
            this.fetchAlbums()
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
        async fetchAlbums(){
            // filter = null

            this.page+=1
            if (this.filter !== null) {
                Object.keys(this.filter).forEach(key => {
                    if (this.filter[key] === null || this.filter[key] === '') {
                        delete this.filter[key];
                    }
                });
            }

            this.filter.page = this.page
            this.showspinner = false
            console.log(this.filter)
            const params = this.filter

            try{
                const response = await axios.get('api/albums', {params: params} );
                //       this.albums = response.data.data;
                this.albums=[...this.albums,...response.data.data];

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
        loadMorePosts(){
            console.log("222")
            this.fetchAlbums()
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
        //  this.fetchAlbums()
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
