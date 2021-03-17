<template>
    <button @click="changeNumber">{{ title }} {{ number }}</button>
</template>

<script>
export default {
    name: "LinhTinhComponent",
    props: {
        title: {
            type: String,
            default: function() {
                return '';
            }
        },
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
