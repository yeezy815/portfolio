<template>
    <div class="dialog"
       >

        <div  class="dialog__content">
            <slot>

            </slot>
        </div>

    </div>
</template>

<script>

export default {
    name: "MyDialog",
    data(){
        return{
            show: true
        }
    },
}
</script>

<style scoped>
.dialog{
    top: 0;
    bottom: 0;
    right: 0;
    left: 0;
    background: rgba(0, 0, 0, 0.5);
    position: fixed;
    display: flex
}
.dialog__content{
    margin: auto;
    background: white;
    border-radius: 12px;
    min-height: 50px;
    min-width:90%;
    padding: 20px;
}
</style>
