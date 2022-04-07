<template>
    <div class="article">
        <p> Записи </p>
    </div>
    <div class="item-list" >
        <dairy-item v-for="dairy in dairies" :dairy="dairy"
                    @remove="askRemoveDairy"
                    @confirm="updateDairy(dairy)"
                    @editalbum="editAlbum"
        />
    </div>
    <show-more-items v-show="!isLastPage"
    @loadMore="getItems"

    />
    <div class="fixed-bottom" style="margin: 0 auto; width: 150px; margin-bottom: 10px">
        <button type="button" class="btn btn-info" @click="showAddDairy= true">добавить запись</button>
    </div>
    <my-dialog v-if="showPopUp">
        <delete-confirm :message="'удалить запись от '+ deletingDairy.date"
                        @cancel="showPopUp = false"
                        @confirm="confirmDairyDeletion(deletingDairy)"
        />
    </my-dialog>

    <my-dialog v-if="showAddDairy" @close="showAddDairy = false">
        <dairy-item
            :dairy="addingDairy"
            :creation="true"
            @cancel="showAddDairy = false"
            @remove="askRemoveDairy"
            @confirm="onCreateDairy"
            @editalbum="editAlbum"
        />
    </my-dialog>

    <attach-album
        v-show="showEditDairy"
        @close="showEditDairy=false"
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
import useItems from "@/composables/itemsAPI";
import {onMounted} from "vue";
import ShowMoreItems from "@/components/UI/ShowMoreItems";
import VueHeader from "@/components/UI/VueHeader";
export default {
    name: "DairyList",
    emits: ["remove", "confirm", "cancel", "close",  "createItem", "setAlbum", "filter"],
    components: {
        VueHeader,
        ShowMoreItems,
    AttachAlbum, DairyItem, CreateForm, SelectBar, DeleteConfirm, AlbumItem, MyDialog, AlbumList},
    setup(){
      const { items, getItems, setItemType, destroyItem, updateItem, createItem, isLastPage} = useItems()

         onMounted(() => {
             setItemType('dairy')
             getItems()
         })

        return {
          dairies : items,
            isLastPage,
            getItems,
            deleteDairy :  destroyItem,
            updateDairy: updateItem,
            createDairy : createItem
        }
    },

    data(){
        return{
            addingDairy: {},
            showPopUp: false,
            deletingDairy: {},
            showAddDairy: false,
            showEditDairy: false,
            editingDairyId:{},
        }
    },
    methods:{
        editAlbum(dairy) {
                this.showEditDairy = true
                this.editingDairyId = dairy.id
            },
        async onCreateDairy(dairy) {
            this.showAddDairy = false
            this.createDairy(dairy)
        },
        async setAlbum(album){
            const objIndex = this.dairies.findIndex((o => o.id === this.editingDairyId));
            if (!this.showAddDairy) {
                this.dairies[objIndex].albums = album
                this.dairies[objIndex].album_id = album.id
            }
            else {
                this.addingDairy.albums = album
                this.addingDairy.album_id = album.id
            }
               this.showEditDairy = false

        },
        askRemoveDairy(album){
            this.showPopUp = true;
            this.deletingDairy = album
        },
         confirmDairyDeletion(album){
            this.deleteDairy(album)
            this.deletingDairy = null
            this.showPopUp = false;
        },
    },
    created() {
        document.title = "Записи"
    }
}
</script>
<style scoped>
</style>
