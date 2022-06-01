<template>
    <div>

        <v-dialog v-model="ratingDialog" max-width="400">

            <v-card class="elevation-16 mx-auto" width="400" :class="this.error ? 'shake' : ''">
                <v-card-title class="text-h5 justify-center">
                    Give Feedback
                </v-card-title>
                <v-divider></v-divider>
                <form action="" @submit.prevent="feedbackStore()">
                    <v-card-text>

                        <div class="text-center">
                            <h5>Rating</h5>
                            <v-rating v-model="form.rating" color="yellow darken-3" background-color="grey darken-1"
                                empty-icon="$ratingFull" half-increments hover large required></v-rating>
                            <div class="small text-danger" v-if="form.errors.has('rating')"
                                v-html="form.errors.get('rating')" />
                        </div>

                        <div class="small text-danger" v-if="form.errors.has('feedback')"
                            v-html="form.errors.get('feedback')" />
                        <v-textarea label="Feedback" placeholder="Give Your Feedback" outlined v-model="form.feedback"
                            sm="1" :rules="remRules" ></v-textarea>
                        



                    </v-card-text>
                    <v-divider></v-divider>
                    <v-card-actions class="justify-space-between">
                        <v-btn text @click="ratingDialog = false" color="error">
                            Close
                        </v-btn>
                        <v-btn color="primary" type="submit">
                            Submit
                        </v-btn>
                    </v-card-actions>
                </form>
            </v-card>
        </v-dialog>

    </div>
</template>

<script>
    import Form from 'vform';
    export default {
        props:['currentDataId'],
        data() {
            return {

                ratingDialog: true,

                remRules: [
                    v => (v || '').length <= 20000 || 'Feedback must be 20,000 characters or less',
                    v => (v || '').length >= 10 || '10 chars minimum or more',
                ],

                form: new Form({

                    id: '',
                    feedback: '',
                    rating: null,

                }),


                // any error
                error: false

            }
        },

        methods: {
            

            feedbackStore() {
                this.form.id = this.currentDataId;
                this.form.post('/cms/app/feedback').then(response => {

                    if (response.status == 200) {
                        Toast.fire({
                            icon: response.data.icon,
                            title: response.data.msg
                        });
                        this.ratingDialog = false;
                        this.form.reset();
                        // getReuslt function call
                        this.$emit('childToParent');
                        // in mixin
                        this.closeComplainForRating();
                    }
                }).catch(err => {

                    this.error = true;

                })
            }
        },

        watch: {
            ratingDialog: function (e) {
                if (!e) {
                    this.form.errors.clear();
                    this.form.reset();
                    this.error = false;
                }
            }
        }
    }

</script>

<style scoped>
    .shake {
        animation: shake 0.82s cubic-bezier(.36, .07, .19, .97) both;
        border: 2px solid red;
        transform: translate3d(0, 0, 0);
    }

    @keyframes shake {

        10%,
        90% {
            transform: translate3d(-1px, 0, 0);
        }

        20%,
        80% {
            transform: translate3d(2px, 0, 0);
        }

        30%,
        50%,
        70% {
            transform: translate3d(-4px, 0, 0);
        }

        40%,
        60% {
            transform: translate3d(4px, 0, 0);
        }
    }

</style>
