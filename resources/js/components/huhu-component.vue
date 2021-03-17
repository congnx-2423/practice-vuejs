<template>
    <button @click="changeNumber">{{ number }}</button>
</template>

<script>
export default {
    name: "HuhuComponent",
    props: {
        number: {
            type: Number,
            default() {
                return 0;
            }
        }
    },
    methods: {
        changeNumber() {
            this.$emit('updateNumber');
        }
    }
}
</script>

<style scoped>

</style>
