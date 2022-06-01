<template>
    <div>
        <h1>Approve page</h1>

        {{ $route.query.token }}
    </div>
</template>

<script>
export default {
     created() {
            this.$Progress.start();
         
            console.log( this.$route.query.token)

            this.$Progress.finish();
        }
}
</script>