<template>
    <my-dialog  @close="$emit('close')">
        <select-bar
            @filter="filterAlbums"/>
        <div style="width:80%">
            <div style="margin-bottom: 5px"
                 v-for="album in albums"
                 @click="$emit('setAlbum',album)">
                Исполнитель:
                <span v-for="artist in album.artists">
                     <span v-if="artist.id !==album.artists[0].id">, </span>
                    {{artist.name}}
                </span>
                Альбом: {{album.name}} - {{album.year}}</div>
            <div class="page-btns">
                <div v-for="page in albumSettings.totalPages"
                     @click="$emit('changePage',page)"
                     :class="{'choosed' : page === albumSettings.currentPage}"
                     class="page-btn">
                    {{page}}
                </div>
            </div>
        </div>
    </my-dialog>
</template>

<script>
import MyDialog from "@/components/UI/MyDialog";
import SelectBar from "@/components/albums/SelectBar";
export default {
    name: "SelectAlbum",
    emits: ['changePage', 'setAlbum', 'filter'],
    components: {SelectBar, MyDialog},
    props: {
        albums: {
            type: Array
        },
        albumSettings:{
            type: Object
        }
    },
    methods:{
        filterAlbums(filter){
            this.$emit('filter', filter);
        }
    },
    mounted() {
        this.$emit('changePage')
    }
}
</script>

<style scoped>
.page-btns{
    position: absolute;
    left: 50%;
    transform: translate(-50%, -20px);
    border: 3px solid rgba(172,177,150,0.58);
    text-align: center;
}
.page-btn{
    display: inline-block;
    width: 30px;
    height: 30px;
    border: 2px solid #000000;
}
.choosed{
    background-color: green;
}
</style>
