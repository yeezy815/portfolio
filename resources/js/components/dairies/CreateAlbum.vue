<template>
    <my-dialog  @close="$emit('close')">
        <div class="container justify-content-md-center" >
            <album-item @confirm="getCreatedItem"
                        @cancel="$emit('close')"
                        :creation="true"
            />
        </div>
    </my-dialog>
</template>

<script>
import MyDialog from "@/components/UI/MyDialog";
import AlbumItem from "@/components/albums/AlbumItem";
import useAlbums from "@/composables/albums";
import {onMounted} from "vue";


export default {
    name: "CreateAlbum",
    emits: ['confirm', 'cancel'],
    setup(props, {emit}){
        const {  createAlbum,items, setItemType} = useAlbums()

        let albums=items

        const getCreatedItem = async (album) => {
             await createAlbum(album)
             emit('confirm',albums.value[0])
             emit('close')
        }

        onMounted(()=>{
            setItemType('album')
        })




        return {
            createAlbum,
            getCreatedItem,
            albums
        }
    },
    components: {AlbumItem, MyDialog},
}
</script>

<style scoped>

</style>
