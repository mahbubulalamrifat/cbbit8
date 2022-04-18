<template>
    <div>
        <div id="map"></div>
    </div>
</template>


<script>
    export default {

        methods: {
            getLocation() {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(this.showPosition, this.showError);
                } else {
                   console.log( "Geolocation is not supported by this browser.");
                }
            },

            showPosition(position) {
               console.log( "Latitude: " + position.coords.latitude +
                    "<br>Longitude: " + position.coords.longitude);
            },
            showError(error) {

                switch (error.code) {
                    case error.PERMISSION_DENIED:
                       console.log( "User denied the request for Geolocation.")
                        break;
                    case error.POSITION_UNAVAILABLE:
                       console.log( "Location information is unavailable.")
                        break;
                    case error.TIMEOUT:
                       console.log( "The request to get user location timed out.")
                        break;
                    case error.UNKNOWN_ERROR:
                       console.log( "An unknown error occurred.")
                        break;
                }
            }
        },


        mounted() {
            this.getLocation();

        },

    }

</script>


<style scoped>
    #map {
        width: 100%;
        height: 100vh;
    }

</style>
