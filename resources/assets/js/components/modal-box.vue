<style scoped>
    .action-link {
        cursor: pointer;
    }

    .m-b-none {
        margin-bottom: 0;
    }
</style>

<template>


        <!-- Create Modal -->
        <!-- <div class="modal fade" :id="modalData.id" tabindex="-1" role="dialog"> -->
        <div class="modal fade" id="modal-box" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                        <h4 class="modal-title">
                            <!-- {{ modalData.titulo }} -->
                            {{ titulo }}
                        </h4>
                    </div>

                    <div class="modal-body">
                        <slot></slot>
                    </div>

                    <!-- Modal Actions -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        /*
         * The component's data.
         */
        data() {
            modalData: {}
        },

        props: ['titulo'],

        /**
         * Prepare the component (Vue 1.x).
         */
        ready() {
            this.showModal();
        },

        /**
         * Prepare the component (Vue 2.x).
         */
        mounted() {
            this.showModal();
        },

        methods: {
            /**
             * Prepare the component.
             */
            showModal() {
                //this.modalData = data;
                $('#modal-box').modal('show');
                //this.modal('show');
            },
        }
    }
</script>
