<template>
    <div class="article">
        <p> Записи </p>
    </div>
    <div class="album-list" >
        <dairy-item v-for="dairy in dairies" :dairy="dairy"
                    @remove="removeAlbum"
                    @confirm="updateAlbum"
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
            @confirm="addDairy"
            @editalbum="editAlbum"
        />
    </my-dialog>


    <add-album
        v-show="editalbum"
        @selectalbum="selectalbum = true"
        @createalbum="addalbum = true"
        @close="editalbum=false"
    />
    <create-album
        v-show="addalbum"
        @close="addalbum = false"
        @cancel="addalbum = false"
        @confirm="addAlbum"
    />

    <select-album
        v-if="selectalbum"
        :albums="albums"
        :album-settings="albumSettings"
        @close="selectalbum = false"
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
import AddAlbum from "@/components/dairies/AddAlbum";
import CreateAlbum from "@/components/dairies/CreateAlbum";
import SelectAlbum from "@/components/dairies/SelectAlbum";
import {vModelSelect} from "vue";
export default {
    name: "AlbumList.vue",

    emits: ["remove", "confirm", "cancel", "close", "selectalbum", "createalbum", "setAlbum", "filter"],
    components: {
        SelectAlbum,
        CreateAlbum, AddAlbum, DairyItem, CreateForm, SelectBar, DeleteConfirm, AlbumItem, MyDialog, AlbumList},
    data(){
        return{

            dairies:[],
            addeddairy: {},
            showdialog: false,
            deletealbum: {},
            addalbum: false,
            adddairy: false,
            page: 0,
            filter: {},
            albums: [],
            showspinner : true,
            editalbum: false,
            dairyitem:{},
            selectalbum: false,
            albumSettings: {
                currentPage: 1,
                totalPages: 0
            }
        }
    },
    watch:{
      // adddairy(val){
      //     const dairy = {
      //         id: Date.now(),
      //         date: '',
      //         score: '',
      //         experience: '',
      //         description: '',
      //         album_id: null,
      //         albums:{}
      //     }
      //    if (val)
      //        this.dairies.push(dairy)
      // }
    },
    methods:{
        editAlbum(dairy)
            {
                this.editalbum = true
                this.dairyitem = dairy
                console.log(dairy)
            },
        async addDairy(dairy)
        {
           // const newar = [];
          //  album.artists.forEach(element => newar.push(element.name));
            console.log(dairy);
            try{
                const response = await axios.post('api/dairy/', {
                    description: dairy.description,
                    score: dairy.score,
                    experience: dairy.experience,
                    date: dairy.date,
                    album_id: dairy.album_id
                    }

                );

                if (response.status === 201){
                    this.addalbum = false
                    this.adddairy = false
                    this.dairies.push(dairy)
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
                // const response = await axios.put('api/dairy/' + this.dairyitem.id,
                //     {
                //         album_id: album.id
                //     });

                     const objIndex = this.dairies.findIndex((o => o.id === this.dairyitem.id));
                if (!this.adddairy) {
                    this.dairies[objIndex].albums = album
                    this.dairies[objIndex].album_id = album.id
                }
                else {
                    this.addeddairy.albums = album
                    this.addeddairy.album_id = album.id
                }
                this.selectalbum = false
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
                    this.addalbum = false
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
                    // const obj = this.dairies.find(o => {if (o.id === this.dairyitem.id)
                    // {
                    //     o.album_id
                    //     o.albums = response.data
                    //
                    // }
                    // });
                    // const response2 = await axios.put('api/dairy/'+ this.dairyitem.id,
                    //     {
                    //         album_id :response.data
                    //     }
                    // );

                 //   this.dairyitem.albums=response.data
                  //  this.dairies.push(album)
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
            // filter = null
            console.log(this.filter)
            this.page+=1
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
            // filter = null

          //  this.page+=1
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
            this.fetchDairies()
        },
        async updateAlbum(dairy){
            const newar = [];
         //   dairy.artists.forEach(element => newar.push(element.name));

            try{
                const response = await axios.put('api/dairy/' + dairy.id,
                    {
                     //
                        //  artists: newar,
                        name: dairy.name,
                        score: dairy.score,
                        experience: dairy.experience,
                        description: dairy.description,
                        date: dairy.date,
                        album_id:dairy.album_id
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
        cancelEdit(ActualDairyVal){
            const objIndex = this.dairies.findIndex((o => o.id === ActualDairyVal.id))
            this.dairies[objIndex]=ActualDairyVal

        },
        async deleteAlbum(album){
            try{
                const response = await axios.delete('api/dairy/' + album.id);
                if (response.status === 200) {
                    this.updatestatus = "данные успешно обновлены";
                    this.buttons = false;
                    this.dairies=this.dairies.filter(p => p.id !== album.id);
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
