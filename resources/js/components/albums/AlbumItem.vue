<template>
<div class="album-item"
     @click="showButtons()"
     @mouseover="hover = true"
     @mouseleave="hover = false">

    <div class="data-list">
        <span>Исполнитель: <album-artist :artists="album.artists"/></span>
    </div>
    <div class="data-list">
        <span>Альбом: <input  class="album" v-model="album.name"></span>
    </div>
    <div class="data-list">
        <span  class="year"  >Год: <input v-model="album.year"></span>
    </div>
    <div class="data-list" v-show="hover">
        <button type="button" class="btn btn-danger"
        @click="removeAlbum()"
        >Удалить</button>
    </div>
    <div class="buttons" v-if="buttons">
        <button @click="updateAlbum()" class="btn btn-success">Сохранить</button>
        <button class="btn btn-secondary" >Отменить</button>

    </div>
    <p v-if="updatestatus" >{{updatestatus}}</p>
</div>
</template>

<script>
import AlbumArtist from "@/components/albums/AlbumArtist";
export default {
    name: "AlbumItem",
    components: { AlbumArtist},
    props:{
        album:{
            type: Object,
            required: true
        }
    },
    data(){
        return{
            hover: false,
            updatestatus:"",
            buttons:false,

        }
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
       async updateAlbum(){
             const newar = [];
            this.album.artists.forEach(element => newar.push(element.name));
            console.log(newar);
           try{
               const response = await axios.put('api/albums/' + this.album.id,
                   {
                       artists: newar,
                       name: this.album.name,
                       year: this.album.year,

                   }
               );
               if (response.status === 200)
                   this.updatestatus = "данные успешно обновлены";
               else
                   this.updatestatus = "не удалось обновить данные";
               this.buttons = false;
               console.log( response);

           }
           catch(e){
               alert(e);
           }
        }
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
