<template>
    <div class="article">
        <p> Записи </p>
    </div>
    <div class="album-list" >
        <dairy-item v-for="dairy in dairies" :dairy="dairy"
                    @remove="removeAlbum"
                    @confirm="updateAlbum"
                    @editalbum="editAlbum"
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


    <my-dialog v-if="adddairy" @close="adddairy = false">
        <dairy-item
            :creation="true"
            @cancel="adddairy = false"
            @remove="removeAlbum"
            @confirm="addDairy"
            @editalbum="editAlbum"
        />
    </my-dialog>




<!--    <my-dialog v-show="editalbum" @close="editalbum = false">-->
<!--        <div class="row mx-auto w-50">-->

<!--        <div class="row">-->
<!--            <div class="col w-25">-->
<!--                <button  class="btn btn-info w-100 mb-1" @click="selectalbum = true">-->
<!--                    выбрать существующий альбом-->
<!--                </button>-->
<!--            </div>-->
<!--        </div>-->
<!--    <div class="row">-->
<!--        <div class="col w-25">-->
<!--            <button  class="btn btn-info w-100 mb-5" @click="addalbum =true; " >-->
<!--                создать новый альбом-->
<!--            </button>-->
<!--        </div>-->
<!--    </div>-->
<!--        <div class="row mx-auto w-50">-->
<!--            <div class="col w-25  ">-->
<!--                <button  class="btn btn-dark w-100" @click="editalbum =false; " >-->
<!--                   отмена-->
<!--                </button>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--</my-dialog>-->

    <add-album
        v-show="editalbum"
        @selectalbum="selectalbum = true"
        @createalbum="addalbum = true"
        @close="editalbum=false"
    />
    <my-dialog v-if="addalbum" @close="addalbum = false">
        <div class="container justify-content-md-center" >
            <album-item @confirm="addAlbum"
                        @cancel="addalbum = false"
                        :creation="true"
            />
        </div>
    </my-dialog>

    <my-dialog v-if="selectalbum" @close="selectalbum = false">
        <select-bar
            @filter="filterAlbums"/>
        <div style="width:80%">
            <div style="margin-bottom: 5px"
                 v-for="album in albums"
                 @click="setAlbum(album)">
                Исполнитель:
                <span v-for="artist in album.artists">
                     <span v-if="artist.id !==album.artists[0].id">, </span>
                    {{artist.name}}

                </span>
                Альбом: {{album.name}} - {{album.year}}</div>
            <div   v-intersection="fetchAlbums" class="observer"></div>
            <div style="position: absolute;
                        left: 50%;
                        transform: translate(-50%, -20px);
                        border: 3px solid rgba(172,177,150,0.58);
                        text-align: center;
                        ">
                 <div v-for="page in albumSettings.totalPages"
                      @click="fetchAlbums(page)"
                      :class="{'choosed' : page === albumSettings.currentPage}"
                      style="display: inline-block; width: 30px; height: 30px; border: 2px solid #000000; ">
                     {{page}}
                 </div>
            </div>
        </div>
    </my-dialog>
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
export default {
    name: "AlbumList.vue",

    emits: ["remove", "confirm", "cancel", "close", "selectalbum", "createalbum"],
    components: {AddAlbum, DairyItem, CreateForm, SelectBar, DeleteConfirm, AlbumItem, MyDialog, AlbumList},
    data(){
        return{

            dairies:[],
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

    methods:{
        search(filter){
            console.log(filter)
        },
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
            //console.log(album);
            try{
                const response = await axios.post('api/dairy/', {
                    description: dairy.description,
                    score: dairy.score,
                    experience: dairy.experience,
                    date: dairy.date
                    }

                );

                if (response.status === 200){
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
            this.filter = filter
            this.albums = []
            this.page = 0
            this.showspinner = true
            this.fetchAlbums()
        },
        async setAlbum(album){
            try {
                // const response = await axios.put('api/dairy/' + this.dairyitem.id,
                //     {
                //         album_id: album.id
                //     });
                const objIndex = this.dairies.findIndex((o => o.id === this.dairyitem.id));
                this.dairies[objIndex].albums = album
                this.selectalbum = false
                this.editalbum = false
            }
            catch (e){
                console.log(response)
            }
        },
        async addAlbum(album)
        {
            console.log(album)
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
                    const objIndex = this.dairies.findIndex((o => o.id === this.dairyitem.id));
                    const getalbum = await axios.get('api/albums/'+ response.data);
                    this.dairies[objIndex].albums=getalbum.data;
                    this.dairies[objIndex].album_id = response.data
                    // const obj = this.dairies.find(o => {if (o.id === this.dairyitem.id)
                    // {
                    //     o.album_id
                    //     o.albums = response.data
                    //
                    // }
                    // });
                    console.log(this.dairies)
                    // const response2 = await axios.put('api/dairy/'+ this.dairyitem.id,
                    //     {
                    //         album_id :response.data
                    //     }
                    // );
                        console.log()
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

            this.page+=1
            if (this.filter !== null) {
                Object.keys(this.filter).forEach(key => {
                    if (this.filter[key] === null || this.filter[key] === '') {
                        delete this.filter[key];
                    }
                });
            }

            this.filter.page = page
           // this.showspinner = false
            console.log(this.filter)
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
            console.log(this.filter)
            const params = this.filter

            try{
                const response = await axios.get('api/dairy', {params: params} );
                //       this.dairies = response.data.data;
                this.dairies=[...this.dairies,...response.data];

            }
            catch(e){
                alert(e);
            }
            console.log(this.dairies)
        },
        removeAlbum(album){
            console.log("pressed")
            this.showdialog = true;
            this.deletealbum = album
            //this.dairies=this.dairies.filter(p => p.id !== album.id);
        },
        loadMorePosts(){
            console.log("222")
            this.fetchDairies()
        },
        async updateAlbum(dairy){
            const newar = [];
         //   dairy.artists.forEach(element => newar.push(element.name));
            console.log(dairy);
            try{
                const response = await axios.put('api/dairy/' + dairy.id,
                    {
                        artists: newar,
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
        async deleteAlbum(album){
            console.log(album)
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
.choosed{
    background-color: green;
}
</style>
