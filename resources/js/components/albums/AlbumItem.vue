<template>
    <div class="album-item d-flex align-items-center justify-content-center">
        <div class="row  align-middle"
             style=" min-height: 75px; width: 98%;  "
             @mouseover="hover = true"
             @mouseleave="hover = false"
        >
            <div class="col-3 " >
                <album-artist :artists="album.artists" :edit="edit" @remove="deleteArtist"/>
            </div>
            <div class="col" >
                <a :href="'/albums/' + album.id"
                   v-if="!edit"
                   class="item-link"
                >
                    <p >{{album.name}}</p></a>
                <my-input v-else v-model="album.name" placeholder="альбом"/>
            </div>
            <div class="col-1" >
                <p  class="year"  >Год:
                    <my-input v-if="edit" v-model="album.year" placeholder="год" />
                    <span v-else>{{album.year}}</span>
                </p>
            </div>
            <div class="col-1" >
                <button type="button" class="btn btn-danger w-100" v-show="hover"  v-if="!creation"
                @click="removeAlbum()"
                >Удалить</button>
                <button type="button" class="btn btn-info w-100" v-show="hover" @click="edit = true">Изменить</button>
            </div>
            <div class="buttons" v-show="edit">
                <button @click="$emit('confirm', album); edit= false" class="btn btn-success">Сохранить</button>
                <button class="btn btn-secondary" @click="cancel">Отменить</button>
            </div>
            <item-status v-if="album.status" :item="album.status"/>
        </div>
    </div>
</template>

<script>
import AlbumArtist from "@/components/albums/AlbumArtist";
 import MyInput from "@/components/UI/MyInput";
import ItemStatus from "@/components/UI/ItemStatus";
export default {
    name: "AlbumItem",
    emits: ['remove', 'confirm', 'cancel'],
    components: {ItemStatus, MyInput, AlbumArtist},
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
        creation:{
            type: Boolean,
            default: false
        }
    },
    data(){
        return{
            hover: false,
            edit: false,
            defaultItem:{
                artists:{},
                name: '',
                year: 0
            }
        }
    },
    mounted() {
        if (this.creation === true)
            this.edit = true
    },
    methods:{
        async removeAlbum(){
            this.$emit('remove',this.album);
        },
        deleteArtist(artist){
            this.album.artists=this.album.artists.filter(p => p.id !== artist.id);
        },
        cancel(){
            for (let key in this.defaultItem)
                this.album[key] = this.defaultItem[key]
            if (!this.creation)
                this.edit = false
            else {
                this.$emit('cancel')
            }
        },
    },

    watch:{
        edit(newVal){
            if (newVal){
                for (let key in this.album) {
                    this.defaultItem[key] = this.album[key];
                }
            }
        }
    },


}
</script>

<style scoped>
.album-item{
    background-color:rgba(172,177,150,0.58);
    width: 100%;
    min-height: 50px;
    border: 1px solid;
    border-radius: 15px;
    margin-bottom: 5px;
}

.year{
    float:right;

}
.year input{
    width:60px
}

.item-link{
    color: black;
    text-decoration:none
}

.item-link:hover{
    color: #f7f7f7}

.data-list{
    display: inline-block;
    width: 25%;
}
</style>
