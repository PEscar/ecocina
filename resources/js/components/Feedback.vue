<template>
    <div>
        <button id="feedback_btn" type="button" class="btn btn-primary" data-toggle="modal" data-target="#feedbackModal">
            Feedback
        </button>

        <!-- Modal -->
        <div class="modal fade" id="feedbackModal" tabindex="-1" aria-labelledby="feedbackModal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Dejanos un comentario</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form :action="route" method="POST">

                            <input type="hidden" name="_token" :value="$root.csrf">

                            <div class="form-group">
                                <label>Nombre </label>
                                <input type="text" name="name" class="form-control w-auto d-inline" v-model="feedback.name" v-bind:class="{ 'is-valid' : feedback.name, 'is-invalid' : !feedback.name }" placeholder="Juan">
                            </div>

                            <div class="form-group">
                                <label for="date">Mail</label>
                                <input type="email" name="email" class="form-control w-auto d-inline" v-model="feedback.email" placeholder="pepe@casas.com">

                                <small v-if="!feedback.email" class="form-text text-danger">Déjanos tu email.</small>
                            </div>

                            <div class="form-group">
                                <label for="total">Total </label>
                                <textarea name="comment" class="form-control w-auto d-inline" v-model="feedback.comment" placeholder="Necesito poder agregar ...">
                                    
                                </textarea>
                            </div>

                            <button type="submit" v-bind:disabled="!validForm" class="btn btn-primary">Enviar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
 
<script>
    export default {
        data() {
            return {
                feedback: {},
            }
        },
        computed: {
            validForm: function()
            {
                return this.feedback.name && this.feedback.comment
            },

            route: function()
            {
                return this.$root.base_url + '/feedbacks'
            }
        }
    }
</script>