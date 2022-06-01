<template>
    <div>
        <h1>User Manual </h1>
    </div>
</template>

<script>

import VuePdfApp from "vue-pdf-app";
import "vue-pdf-app/dist/icons/main.css";

export default {

    components: {
        VuePdfApp
    },

    data(){
        return{

            config: {
                toolbar: {
                    toolbarViewerLeft: { findbar: false }
                }
            },

            //current page url
            currentUrl: '/carpool',

        }
    },

    methods:{

        getBase64Data(){
            axios.get( this.currentUrl +'/pdf_view').then(response=>{
                console.log(response)

            }).catch(error=>{
                console.log(error)
            })
        }

    },

    created(){
        this.$Progress.start(); 

        this.getBase64Data();

        this.$Progress.finish();
    }

}
</script>