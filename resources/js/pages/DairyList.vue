<template>
    <div class="article">
        <p> Записи </p>
    </div>
    {{test}}
    <div class="album-list" >
        <dairy-item v-for="dairy in dairies" :dairy="dairy"
                    @remove="removeAlbum"
                    @confirm="putDairy(dairy)"
                    @editalbum="editAlbum"
                    @cancel="cancelEdit"
        />
    </div>
    <div class="spinner-border" role="status" v-if="showspinner"><span class="visually-hidden">Loading...</span>  </div>
<!--    <div   v-intersection="getDairies" class="observer"></div>-->
    <button   @click="getDairies(filter)">Загрузить еще</button>
    <div class="fixed-bottom" style="margin: 0 auto; width: 150px; margin-bottom: 10px">
        <button type="button" class="btn btn-info" @click="adddairy= true">добавить запись</button>
    </div>
    <my-dialog v-if="showdialog">
        <delete-confirm :message="'удалить запись от '+ deletealbum.date"
                        @cancel="showdialog = false"
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
        @setAlbum="setAlbum"
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

        let test = dairies

        return {
          dairies,
            test,
        getDairies,
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
            filter: null,
            showspinner : true,
            editalbum: false,
            dairyitem:{},
        }
    },
    methods:{
        editAlbum(dairy)
            {
                this.editalbum = true
                this.dairyitem = dairy
            },
        async newDairy(dairy)
        {
            this.adddairy = false
            this.addDairy(dairy)
        },
        async setAlbum(album){
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

        },
        removeAlbum(album){
            this.showdialog = true;
            this.deletealbum = album
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
