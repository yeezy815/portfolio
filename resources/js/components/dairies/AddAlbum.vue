<template>
    <my-dialog  @close="$emit('close')">
        <div class="row mx-auto w-50">
            <div class="row">
                <div class="col w-25">
<!--                    $emit('selectalbum')-->
                    <button  class="btn btn-info w-100 mb-1" @click="test = true">
                        выбрать существующий альбом
                    </button>
                </div>
            </div>
            <div class="row">
                <div class="col w-25">
                    <button  class="btn btn-info w-100 mb-5" @click="$emit('createalbum')" >
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
</template>

<script>
import MyDialog from "@/components/UI/MyDialog";
import CreateAlbum from "@/components/dairies/CreateAlbum";
import AlbumItem from "@/components/albums/AlbumItem";
export default {
    name: "AddAlbum",
    components: {AlbumItem, CreateAlbum, MyDialog},

    data(){
    return{
            test: false
        }
    }
}
</script>

<style scoped>

</style>
