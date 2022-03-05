<template>
    <div  @mouseover="showaddbutton = true" @mouseleave="showaddbutton = false" style="width: 100%; height: 100%">
<!--        <p>Исполнитель: </p>-->
        <div v-for="artist in artists">
            <artist-item :artist="artist"
                         :edit="edit"
            @remove="$emit('remove', artist)"/>
            <span v-if="!edit && artist !== artists[artists.length - 1]">, &nbsp;</span>
        </div>
        <button class="btn btn-secondary" @click="addArtist" v-show="showaddbutton && edit">+</button>
    </div>
<!--    <button v-if="showbutton">+</button>-->
</template>

<script>
import ArtistItem from "./ArtistItem";
export default {
    name: "AlbumArtist",
    emits: ['remove'],
    components: {ArtistItem},
    props:{
        artists:{
            type:Array,
            required: false
        },
        edit:{
            type: Boolean,
            default: true
        }
    },

    data(){
        return{
            showaddbutton: false,
          //  edit: false,

        }
    },
    methods:{
        addArtist()
        {
            const newartist = {
                id: Date.now(),
                name: null
            }
            this.artists.push(newartist)
        },
    }
}
</script>

<style scoped>
a{
    color: rgba(17,17,14,0.58);
    text-decoration: none;
}
a:hover{
    color:#000
}

.comma{
    color: black;
}
input{
    background: none;
    /*width: 100px;*/
    border: 0;
    font-size: 15px;
    outline:none;
}
</style>
