<template>
    <p  :class="item.type">
                <p v-if="Array.isArray(item.message) || typeof item.message=== 'object' " v-for="message in item.message">
                    <span v-if="Array.isArray(message)" v-for="singleMessage in message">
                        {{singleMessage}}
                    </span>
                   <span v-else>{{message}}</span>
                </p>
    <span v-else>{{item.message}}</span>
    </p>
</template>

<script>
export default {
    name: "ItemStatus",
    props: {
        item:{
            type:Object,
            required: true
        }
    }
}
</script>

<style scoped>

</style>
