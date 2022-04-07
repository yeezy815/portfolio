<template>

    <div class="popup" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="popup-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn btn-close"     @click="$emit('close')">
                    </button>
                </div>
                <div class="modal-body">
                    <slot></slot>
                </div>
<!--                <div class="modal-footer">-->
<!--                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>-->
<!--                    <button type="button" class="btn btn-primary">Save changes</button>-->
<!--                </div>-->
            </div>
        </div>
    </div>
<!--    <div class="dialog">-->
<!--        <div  class="dialog__content">-->
<!--            <button class="btn btn-close pos-right-corner"-->
<!--            @click="$emit('close')"-->
<!--            ></button>-->
<!--            <slot>-->

<!--            </slot>-->
<!--        </div>-->

<!--    </div>-->
</template>

<script>

export default {
    name: "MyDialog",
    emits: ["close"],
    data(){
        return{
            show: true
        }
    },
    mounted() {
    }
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
.pos-right-corner{
    float:right; display:flex;
}
.popup{
    position: fixed;
    top: 0;
    left: 0;
    z-index: 1055;
    width: 100%;
    height: 100%;
    overflow-x: hidden;
    overflow-y: auto;
    outline: 0;
}
.popup-dialog{
    max-width: 80%;
    margin: 1.75rem auto;
}
</style>
