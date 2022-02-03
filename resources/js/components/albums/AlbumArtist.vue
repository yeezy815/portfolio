<template>
    <div v-for="artist in artists">
<!--    <a v-if="edit"-->
<!--       :href="'/artist/' + artist.id">-->


<!--        {{artist.name}}<span v-if="artist !== artists[artists.length - 1]" class="comma">, </span></a>-->
        <div>
            <input v-model="artist.name" placeholder="исполнитель">

            <button class="btn btn-danger">x</button>
        </div>

    </div>
    <button class="btn btn-secondary" @click="addArtist">+</button>
<!--    <button v-if="showbutton">+</button>-->
</template>

<script>
export default {
    name: "AlbumArtist",
    props:{
        artists:{
            type:Array,
            required: false
        },
        data(){
            return{
                edit: false,
                showbutton: false
            }
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
        }
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
