<template>
    <input :value="modelValue" class="input" type="text" @input="updateInput">
</template>

<script>
export default {
    name: "MyInput",
    props:{
        modelValue: [String, Number]
    },
    methods: {
        updateInput(event){
            this.$emit('update:modelValue',event.target.value);
        }
    }
}
</script>

<style scoped>
/*.input{*/
/*    width:100%;*/
/*    border: 1px solid teal;*/
/*    padding: 10px 15px*/
/*}*/
.input{
    background: none;
    height: 100%;
    width: 100%;
    border: 0;
    font-size: 15px;
    outline:none;
    display: inline-block;
}
</style>
