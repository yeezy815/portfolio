<template>
    <div class="article">
        <p> Записи </p>
    </div>
    <div class="album-list" >
        <dairy-item v-for="dairy in dairies" :dairy="dairy"
                    @remove="removeAlbum"
                    @confirm="putDairy(dairy)"
                    @editalbum="editAlbum"
                    @cancel="cancelEdit"
        />
    </div>
    <div class="spinner-border" role="status" v-if="showspinner"><span class="visually-hidden">Loading...</span>  </div>
    <div   v-intersection="loadMorePosts" class="observer"></div>
    <div class="fixed-bottom" style="margin: 0 auto; width: 150px; margin-bottom: 10px">
        <button type="button" class="btn btn-info" @click="adddairy= true">добавить запись</button>
    </div>
    <my-dialog v-if="showdialog">
        <delete-confirm :message="'удалить запись от '+ deletealbum.date" @cancel="showdialog = false"
                        @confirm="deleteAlbum(deletealbum)"/>
    </my-dialog>


    <my-dialog v-show="adddairy" @close="adddairy = false">
        <dairy-item
            :dairy="addeddairy"
            :creation="true"
            @cancel="adddairy = false"
            @remove="removeAlbum"
            @confirm="newDairy"
            @editalbum="editAlbum"
        />
    </my-dialog>


    <attach-album
        v-show="editalbum"
        @close="editalbum=false"
        @createAlbum="addAlbum"
        :albums="albums"
        :album-settings="albumSettings"
        @filter="filterAlbums"
        @setAlbum="setAlbum"
        @changePage="fetchAlbums"
    />
</template>

<script>
import AlbumItem from "@/components/albums/AlbumItem";
import MyDialog from "@/components/UI/MyDialog";
import DeleteConfirm from "@/components/albums/DeleteConfirm";
import SelectBar from "@/components/albums/SelectBar";
import CreateForm from "@/components/albums/CreateForm";
import DairyItem from "@/components/dairies/DairyItem";
import AlbumList from "@/pages/AlbumList";
import AttachAlbum from "@/components/dairies/AttachAlbum";
import useDairies from "@/composables/dairies";
import {onMounted} from "vue";

export default {
    name: "AlbumList.vue",

    emits: ["remove", "confirm", "cancel", "close",  "createAlbum", "setAlbum", "filter"],
    components: {
    AttachAlbum, DairyItem, CreateForm, SelectBar, DeleteConfirm, AlbumItem, MyDialog, AlbumList},

    setup(){
      const { dairies, getDairies, destroyDairy, updateDairy, createDairy} = useDairies()


        onMounted(getDairies)

        const deleteDairy = async (dairy) => {
          await destroyDairy(dairy)
        }

        const putDairy = async (dairy) => {
            await updateDairy(dairy)
        }

        const addDairy = async (dairy) => {
            await createDairy(dairy)
        }

        return {
          dairies,

         deleteDairy,
            putDairy,
            addDairy
        }
    },

    data(){
        return{
            addeddairy: {},
            showdialog: false,
            deletealbum: {},
            adddairy: false,
            page: 0,
            filter: {},
            albums: [],
            showspinner : true,
            editalbum: false,
            dairyitem:{},
            albumSettings: {
                currentPage: 1,
                totalPages: 0
            }
        }
    },
    methods:{
        editAlbum(dairy)
            {
                this.editalbum = true
                this.dairyitem = dairy
                console.log(dairy)
            },
        async newDairy(dairy)
        {
            this.adddairy = false
            this.addDairy(dairy)
        },
        filterAlbums(filter){
            console.log(filter)
            this.filter = filter
            this.albums = []
            this.page = 0
            this.showspinner = true
            this.fetchAlbums()
        },
        async setAlbum(album){
            console.log(album)
            try {
                     const objIndex = this.dairies.findIndex((o => o.id === this.dairyitem.id));
                if (!this.adddairy) {
                    this.dairies[objIndex].albums = album
                    this.dairies[objIndex].album_id = album.id
                }
                else {
                    this.addeddairy.albums = album
                    this.addeddairy.album_id = album.id
                }
                this.editalbum = false
            }
            catch (e){
                console.log(e)
            }
        },
        async addAlbum(album)
        {
            console.log(album)

            const newar = [];
            album.artists.forEach(element => newar.push(element.name));
            try{
                const response = await axios.post('api/albums/',
                    {
                        artists: newar,
                        name: album.name,
                        year: album.year,
                    }

                );

                if (response.status === 200){
                    const objIndex = this.dairies.findIndex((o => o.id === this.dairyitem.id));
                    const getalbum = await axios.get('api/albums/'+ response.data);
                    console.log(this.adddairy)
                    if (this.adddairy === false) {
                        console.log("here")
                        this.dairies[objIndex].albums = getalbum.data;
                        this.dairies[objIndex].album_id = response.data
                    }
                    else{
                        this.addeddairy.albums = getalbum.data;
                        this.addeddairy.album_id = response.data
                    }

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
        async fetchAlbums(page = 1){

            if (this.filter ) {
                Object.keys(this.filter).forEach(key => {
                    if (this.filter[key] === null || this.filter[key] === '') {
                        delete this.filter[key];
                    }
                });
            }

            this.filter.page = page
           // this.showspinner = false
            const params = this.filter

            try{
                const response = await axios.get('api/albums', {params: params} );
                //       this.albums = response.data.data;
                this.albums=response.data.data //[...this.albums,...response.data.data];
                console.log(response.data);
                this.albumSettings.totalPages = response.data.last_page
                this.albumSettings.currentPage =  response.data.current_page
            }
            catch(e){
                alert(e);
            }
        },
        async fetchDairies(){
            if (this.filter !== null) {
                Object.keys(this.filter).forEach(key => {
                    if (this.filter[key] === null || this.filter[key] === '') {
                        delete this.filter[key];
                    }
                });
            }

       //     this.filter.page = this.page
            this.showspinner = false
            const params = this.filter

            try{
                const response = await axios.get('api/dairy', {params: params} );
                //       this.dairies = response.data.data;
                this.dairies=[...this.dairies,...response.data];

            }
            catch(e){
                alert(e);
            }
        },
        removeAlbum(album){
            this.showdialog = true;
            this.deletealbum = album
            //this.dairies=this.dairies.filter(p => p.id !== album.id);
        },
        loadMorePosts(){
         //   this.fetchDairies()
        },
        cancelEdit(actualDairyVal){
            const objIndex = this.dairies.findIndex((o => o.id === actualDairyVal.id))
            this.dairies[objIndex]=actualDairyVal
        },

        async deleteAlbum(album){
            this.deleteDairy(album)
            this.deletealbum = null
            this.buttons = false
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
