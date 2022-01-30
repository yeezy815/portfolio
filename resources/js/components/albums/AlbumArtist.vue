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
    color: #FFFFFF;    text-decoration: none;
}
.comma{
    color: black;
}
</style>
