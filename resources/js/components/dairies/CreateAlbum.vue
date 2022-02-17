<template>
    <my-dialog  @close="$emit('close')">
        <div class="container justify-content-md-center" >
            <album-item @confirm="addAlbum"
                        @cancel="$emit('cancel')"
                        :creation="true"
            />
        </div>
    </my-dialog>
</template>

<script>
import MyDialog from "@/components/UI/MyDialog";
import AlbumItem from "@/components/albums/AlbumItem";
export default {
    name: "CreateAlbum",
    emits: ['confirm', 'cancel'],
    components: {AlbumItem, MyDialog},
    methods:{
      addAlbum(album){

            this.$emit('confirm',album)
         // this.$emit('close');
        }
    }
}
</script>

<style scoped>

</style>
