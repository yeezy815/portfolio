<template>
    <a v-for="artist in artists"
       :href="'/artist/' + artist.id">


        {{artist.name}}<span v-if="artist !== artists[artists.length - 1]" class="comma">, </span></a>

</template>

<script>
export default {
    name: "AlbumArtist",
    props:{
        artists:{
            type:Array,
            required: false
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
</style>
