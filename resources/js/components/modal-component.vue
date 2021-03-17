<template>
    <div class="modal fade" id="create-update-modal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false" >
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ title }}</h5>
                    <button type="button" class="close" aria-label="Close" @click="hideModal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="name-create" class="col-form-label">Name: </label>
                            <input type="text" class="form-control" id="name-create" v-model="userDetail.name">
                        </div>
                        <div class="form-group">
                            <label for="email-create" class="col-form-label">Email:</label>
                            <input type="text" class="form-control" id="email-create" v-model="userDetail.email">
                        </div>
                        <span @click="createUser" class="btn btn-primary">{{ button }}</span>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "modal-component",

    props: {
        title: {
            type: String,
            default: 'Create',
        },
        button: {
            type: String,
            default: 'Create'
        },
        userDetail: {
            type: Object,
            default: () => ({}),
        }
    },

    methods: {
        hideModal() {
            $('#create-update-modal').modal('hide');
            $(document).on('hidden.bs.modal', '#create-update-modal', function () {
                this.showModal = false;
            });
        },

        editUser(id) {
            let index = this.users.findIndex(item => {
                return (id === item.id);
            });

            axios.patch(laroute.route('users.update', {user: id}), this.userDetail)
                .then(({data}) => {
                    this.$set(this.users, index, data.user);
                }).catch(error => function() {
                    alert('Error');
                });
        },

        createUser() {
            axios.post(laroute.route('users.store'), this.newUser)
                .then(({data}) => {
                    this.users.push(data.newUser);
                }).catch(({error}) => {
                    alert('Error');
                });

            this.hideModal();
        },
    }
}
</script>

<style scoped>

</style>
