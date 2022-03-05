<template>
    <div>
    <my-dialog  @close="$emit('close')">
        <div class="row mx-auto w-50">
            <div class="row">
                <div class="col w-25" >
                    <button  class="btn btn-info w-100 mb-1" @click="showSelectAlbum = true">
                        выбрать существующий альбом
                    </button>
                </div>
            </div>
            <div class="row">
                <div class="col w-25">
                    <button  class="btn btn-info w-100 mb-5" @click="showCreateAlbum = true" >
                        создать новый альбом
                    </button>
                </div>
            </div>
            <div class="row mx-auto w-50">
                <div class="col w-25  ">
                    <button  class="btn btn-dark w-100" @click="$emit('close')" >
                        отмена
                    </button>
                </div>
            </div>
        </div>
    </my-dialog>

        <create-album
            v-if="showCreateAlbum"
            @close="showCreateAlbum = false"
            @confirm="setAlbum"
        />

        <select-album
            v-if="showSelectAlbum"
            @close="showSelectAlbum= false"
            @setAlbum="setAlbum"
        />
</div>
</template>

<script>
import MyDialog from "@/components/UI/MyDialog";
import CreateAlbum from "@/components/dairies/CreateAlbum";
import AlbumItem from "@/components/albums/AlbumItem";
import DairyItem from "@/components/dairies/DairyItem";
import SelectAlbum from "@/components/dairies/SelectAlbum";
export default {
    name: "AttachAlbum",
    components: {AlbumItem, CreateAlbum, MyDialog, DairyItem, SelectAlbum},
    emits: ['close', 'confirm', 'cancel', 'fetchAlbums', 'createAlbum', 'setAlbum', 'filter', 'changePage'],



    data(){
        return{
            showCreateAlbum: false,
            showSelectAlbum: false
        }
    },
    props:{
        albums:{type: Array},
        albumSettings: {type: Object}
    },


    methods:{
        createAlbum(album){
           this.$emit('createAlbum',album);
           this.showCreateAlbum = false;
           this.$emit('close')
        },
        setAlbum(album){
            this.$emit('setAlbum', album)
        },
    }

}
</script>

<style scoped>

</style>
