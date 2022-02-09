<template>
    <div class="album-item d-flex align-items-center justify-content-center">
        <div class="row  align-middle" style=" min-height: 75px; width: 98%;  "
    @click = "buttons = true"

     @mouseover="hover = true"
     @mouseleave="hover = false"
>
        <div class="col-3 " >
            <album-artist :artists="album.artists" @remove="deleteArtist"/>
        </div>
        <div class="col" >
    <!--     <p>Альбом:</p> -->
            <my-input v-model="album.name" placeholder="альбом"/>
        </div>
        <div class="col-1" >
            <p  class="year"  >Год: <my-input v-model="album.year" placeholder="год" /></p>
        </div>
        <div class="col-1" >
            <button type="button" class="btn btn-danger" v-show="hover"  v-if="!creation"
            @click="removeAlbum()"

            >Удалить</button>
        </div>
        <div class="buttons" v-if="buttons ">
            <button @click="$emit('confirm', album)" class="btn btn-success">Сохранить</button>
            <button class="btn btn-secondary" @click="$emit('cancel')">Отменить</button>

        <p v-if="updatestatus" >{{updatestatus}}</p>

     </div>
</div>
    </div>
</template>

<script>
import AlbumArtist from "@/components/albums/AlbumArtist";
 import MyInput from "@/components/UI/MyInput";
//import MyInput from "../UI/MyInput";
export default {
    name: "AlbumItem",
    emits: ['remove', 'confirm', 'cancel'],
    components: {MyInput, AlbumArtist},
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
    width: 100%;
    min-height: 50px;
    /*#a0aec0*/
    /*display: inline-block;*/
    border: 1px solid;
    border-radius: 15px;
    margin-bottom: 5px;
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
