<template>
    <div>
        <v-app-bar app flat dense color="transparent">
            <v-spacer></v-spacer>
            <v-app-bar-nav-icon href="/">
                <v-img  src="/all-assets/common/logo/cpb/cpbit.png" alt="CPB-IT" max-height="40" max-width="40" contain></v-img>
            </v-app-bar-nav-icon>
            <v-app-bar-title >CPB-IT {{ headerText }} Dashboard</v-app-bar-title>

            <v-spacer></v-spacer>
            <v-btn v-if="homeBtn"  small color="primary" link href="/">
              <v-icon left>mdi-view-dashboard</v-icon>  Home
            </v-btn>
        </v-app-bar> 
    </div>
</template>

<script>
export default {
    props:['headerText', 'homeBtn']
}
</script>


<style scoped>
.v-app-bar.v-app-bar--fixed {
  position: relative;
}
</style>