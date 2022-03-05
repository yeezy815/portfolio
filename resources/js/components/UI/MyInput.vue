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
    height: 50px;
    width: 100%;
    font-size: 15px;
    outline:none;
    border-width: 0 0 2px;  border-color: #G7G7G7;

    display: inline-block;
}
</style>
