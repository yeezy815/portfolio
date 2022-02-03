<template>
    <div class="select-bar">
        <p>сортировать по
            <select v-model="filter.sortBy">
                <option value="year">
                    году
                </option>
                <option value="artists">
                    исполнителю
                </option>
                <option value="name">
                   альбому
                </option>
            </select>
        <select v-model="filter.sortorder">
            <option value="asc">
                возрастанию
             </option>
            <option value="desc" selected>
                убыванию
               </option>
        </select>
        </p>

       альбом <input v-model="filter.album" >
       артист <input v-model="filter.artist">
        год: от <input v-model="filter.min_year" @input="input('min_year')">
            до <input v-model="filter.max_year" @input="input('max_year')">
        <button type="button" class="btn btn-info" @click="$emit('filter',filter)">Применить</button>
    </div>
</template>

<script>
export default {
    name: "SelectBar",
    data(){
        return{
            filter:{
                sortBy: 'year',
                sortorder: 'asc',
                album: null,
                artist: null,
                min_year: null,
                max_year: null
            }
        }
    },
    methods:{
        search(){
            console.log(this.filter);
        },
        input: function(key) {
          //  console.log(this.max)
            this.filter[key]=  this.filter[key].replace(/[^0-9]+/g, "")
        },
    }
}
</script>

<style scoped>
.select-bar{
    margin: 0 auto;
    width: 80%;
    height: 100px;
}
</style>
