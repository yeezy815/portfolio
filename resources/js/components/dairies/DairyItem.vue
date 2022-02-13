<template>
    <div class="album-item d-flex align-items-center justify-content-center">
        <div class="row  align-middle" style=" min-height: 75px; width: 98%;  "
             @click = "buttons = true"

             @mouseover="hover = true"
             @mouseleave="hover = false"
        >
            <div class="col">
                <div class="row">
                    <div class="col-4" >
                       <p   >Дата:
                           <my-input v-model="dairy.date" v-if="edit" placeholder="дд.мм.гггг" />
                           <span v-else>{{dairy.date}}</span>    </p>
                    </div>
                    <div class="col" v-show="hover && !creation" >
                        <button @click="edit = true" class="btn btn-info">Изменить</button>
                        <button @click="$emit('remove', dairy)" class="btn btn-danger">Удалить</button>
                    </div>

                </div>
                <div class="row" >
                    <div class="col album-info" @click="$emit('editalbum',dairy)" >
                        <div class="col" v-if="dairy.albums">
                            <p>Альбом:
<!--                                <my-input v-if="edit" v-model="dairy.albums.name" placeholder="альбом" />-->
                                <span >{{dairy.albums.name}}</span>
                            </p></div>
                        <div class="col" v-if="dairy.albums">
                            <span>Исполнитель:</span><br>
                            <span v-for="artist in dairy.albums.artists">
                                {{artist.name}}
                                <span v-if="artist.id !== dairy.albums.artists[dairy.albums.artists.length-1].id">, </span>
                            </span>
                            <!--                            <my-input v-model="dairy.albums.name" placeholder="оценка" />-->

                        </div>
                    </div>

                    <div class="col" >
                        <p    >Оценка: <input v-model="dairy.score"  v-if="edit" placeholder="оценка" >
                        <span v-else><br> {{dairy.score}}</span>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-5" >
                <p   >Впечатление:
                 </p>
                <textarea v-if="edit" v-model="dairy.experience" style="width: 100%"></textarea>
                <p v-else>{{dairy.experience}}</p>

            </div>
            <div class="col-4" >
                <p    >Описание: </p>
                 <textarea v-if="edit" v-model="dairy.description" style="width: 100%"></textarea>
                <p v-else>{{dairy.description}}</p>

            </div>


            <div class="buttons" v-if="edit || creation ">
                <button @click="edit = false ; $emit('confirm', dairy)" class="btn btn-success">Сохранить</button>
                <button class="btn btn-secondary" @click="edit = false">Отменить</button>

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
    name: "DairyItem",
    emits: ['remove', 'confirm', 'cancel', 'editalbum'],
    components: {MyInput, AlbumArtist},
    props:{
      dairy:{
            type: Object,
            default: {
                id: Date.now(),
                date: '',
                score: '',
                experience: '',
                description: '',
                album_id: null,
                albums:{}
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
            edit: false

        }
    },
    mounted() {
        if (this.creation === true)
            this.edit = true
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

.album-info:hover{
    background-color: #cbd5e0;
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
