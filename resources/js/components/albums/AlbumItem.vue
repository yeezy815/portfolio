<template>
<div class="album-item" @click="test()">
    <span>Альбом: <input  class="album" v-model="album.name"></span>
    <span>Исполнитель: <album-artist :artists="album.artists"/></span>
    <span style="float:right">Год: <input  v-model="album.year"></span>
    <div class="buttons" v-if="album.buttons">
        <button>Сохранить</button>
        <button>Отменить</button>
    </div>
</div>
</template>

<script>
import AlbumArtist from "@/components/albums/AlbumArtist";
export default {
    name: "AlbumItem",
    components: {AlbumArtist},
    props:{
        album:{
            type: Object,
            required: true
        }
    },
    methods:{
        test(){
            this.album.buttons = true;
            console.log("clickeyd");
        }
    }
}
</script>

<style scoped>
.album-item{
    background-color:rgba(172,177,150,0.58);
    width:100%;
    min-height: 30px;
    /*#a0aec0*/
    display: inline-block;
    border: 1px solid;
    border-radius: 15px;
    margin-bottom: 5px;
}
input{
    background: none;
    border: 0px;
    font-size: 15px;
    outline:none;
}
.album{
    width: 500px;
}

.buttons{
    margin-top: 5px;
    margin-bottom: 5px;
}
</style>
