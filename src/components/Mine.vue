<template>
    <div class="mine">
        I am mine {{ email }}
    </div>
</template>

<script>
export default {
    data() {
        return {
            email: this.$cookies.get('email')
        }
    }
}
</script>

<style>

</style>
