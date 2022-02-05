<template>
    <div style="margin: 0 auto; width:200px; text-align: center" >
        <p> удалить альбом {{album.name}}?</p>
        <button type="button" class="btn btn-danger" style="margin-right: 10px" @click="$emit('confirm', album)">Удалить</button>
        <button type="button" class="btn btn-primary" @click="$emit('cancel')">Отмена</button>
    </div>
</template>

<script>
export default {
    name: "DeleteConfitm",
    emits: ['confirm', 'cancel'],
    props:{
        album:{
            type: Object,
            required: true
        }
    },
    data(){
        return{
            show: false
        }
    }
}
</script>

<style scoped>

</style>
