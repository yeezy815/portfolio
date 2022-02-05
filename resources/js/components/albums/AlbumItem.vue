<template>
<div class="album-item"
     @click="showButtons()"
     @mouseover="hover = true"
     @mouseleave="hover = false">

    <div class="data-list">
        <album-artist :artists="album.artists" @remove="deleteArtist"/>
    </div>
    <div class="data-list">
        <p>Альбом:</p> <input  class="album" v-model="album.name" placeholder="альбом">
    </div>
    <div class="data-list">
        <p  class="year"  >Год: <input v-model="album.year" placeholder="год"></p>
    </div>
    <div class="data-list" v-show="hover"  v-if="!creation">
        <button type="button" class="btn btn-danger"
        @click="removeAlbum()"

        >Удалить</button>
    </div>
    <div class="buttons" v-if="buttons ">
        <button @click="$emit('confirm', album)" class="btn btn-success">Сохранить</button>
        <button class="btn btn-secondary" @click="$emit('cancel')">Отменить</button>

    </div>
    <p v-if="updatestatus" >{{updatestatus}}</p>
</div>
</template>

<script>
import AlbumArtist from "@/components/albums/AlbumArtist";
export default {
    name: "AlbumItem",
    emits: ['remove', 'confirm', 'cancel'],
    components: { AlbumArtist},
    props:{
        album:{
            type: Object,
            default: {
                id: Date.now(),
                year: null,
                name: null,
                artists: []
            },
            required: false
        },
        // buttons:{
        //     default:false
        // },
        creation:{
            type: Boolean,
            default: false
        }
    },
    data(){
        return{
            hover: false,
            updatestatus:"",
            buttons:false,

        }
    },
    mounted() {
        if (this.creation === true)
            this.buttons = true
    },
    methods:{

        showButtons(){
            this.buttons = true;
        },
        async removeAlbum(){

            try{
            //   const response = await axios.delete('api/albums/' + this.album.id);
            //   if (response.status === 200) {
                    this.updatestatus = "данные успешно обновлены";
                    this.$emit('remove',this.album);
            //   }
            //   else
              //      this.updatestatus = "не удалось обновить данные";
                this.buttons = false;

            }
            catch(e){
                alert(e);
            }
        },
        deleteArtist(artist){
            this.album.artists=this.album.artists.filter(p => p.id !== artist.id);
        },
    }
}
</script>

<style scoped>
.album-item{
    background-color:rgba(172,177,150,0.58);
    width:100%;
    min-height: 50px;
    /*#a0aec0*/
    display: inline-block;
    border: 1px solid;
    border-radius: 15px;
    margin-bottom: 5px;
}
input{
    background: none;
    width: 90%;
    border: 0;
    font-size: 15px;
    outline:none;
}
.album{
    width: 300px;
}

.buttons{
    margin-top: 5px;
    margin-bottom: 5px;
}
.year{
    float:right;

}
.year input{
    width:60px
}
.data-list{
    display: inline-block;
    width: 25%;
}
</style>
