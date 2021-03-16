<template>
    <div class="container">
        <div class="row">
            <div style="float: left">
                Number of members: {{ members }}
            </div>
            <div v-if="user.isAdmin === 1">
                <button :title="'Adding new user'" type="button" class="btn btn-primary" data-toggle="modal" data-target="#create" data-whatever="@mdo">Add</button>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <table>
	                <thead>
	                	<tr>
	                		<td style="padding:10px">Name</td>
	                		<td style="padding:10px">Email</td>
	                		<td style="padding:10px">Created at</td>
	                		<td style="padding:10px">Updated at</td>
                            <td style="padding:10px">View</td>
                            <td style="padding:10px" v-if="user.isAdmin === 1">Edit</td>
                            <td style="padding:10px" v-if="user.isAdmin === 1">Delete</td>
	                	</tr>
                	</thead>
                	<tbody>
                		<tr v-for="useR in users" :key="useR.id">
                			<td style="padding:10px">{{ useR.name }}</td>
	                		<td style="padding:10px">{{ useR.email }}</td>
	                		<td style="padding:10px">{{ useR.created_at }}</td>
	                		<td style="padding:10px">{{ useR.updated_at }}</td>
                            <td style="padding:10px">
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#detail" data-whatever="@mdo" @click="showDetail(useR.id)">
                                    View
                                </button>
                            </td>
                            <td style="padding:10px" v-if="user.isAdmin === 1">
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#edit" data-whatever="@mdo" @click="showEdit(useR.id)">
                                    Edit
                                </button>
                            </td>
                            <td style="padding:10px" v-if="user.isAdmin === 1">
                                <button type="button" class="btn btn-primary" @click="deleteUser(useR.id)">
                                    Delete
                                </button>
                            </td>
                		</tr>
                	</tbody>
                </table>
            </div>
        </div>

        <div class="modal fade" id="detail" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">User: {{ userDetail.name }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="col-form-label">Name: {{ userDetail.name }}</label>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label">Email: {{ userDetail.email }}</label>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label">Created_at: {{ userDetail.created_at }}</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="create" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Create</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <label for="name-create" class="col-form-label">Name: </label>
                                <input type="text" class="form-control" id="name-create" @input="newUser.name = $event.target.value">
                            </div>
                            <div class="form-group">
                                <label for="email-create" class="col-form-label">Email:</label>
                                <input type="text" class="form-control" id="email-create" @input="newUser.email = $event.target.value">
                            </div>
                            <span @click="createUser" class="btn btn-primary">Create</span>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit {{ userDetail.name }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <label for="name-edit" class="col-form-label">Name</label>
                                <input type="text" class="form-control" id="name-edit" v-model="userDetail.name">
                            </div>
                            <div class="form-group">
                                <label for="email-edit" class="col-form-label">Email</label>
                                <input type="text" class="form-control" id="email-edit" v-model="userDetail.email">
                            </div>
                            <span @click="editUser(userDetail.id)" class="btn btn-primary">Update</span>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
    	name: 'dashboard-component',
        props: {
    	    user: {
    	        type: Object,
                defaul: () => ({}),
            }
        },
        data: function () {
    	    return {
                userDetail: [],
                newUser: {
                    name: '',
                    email: '',
                },
                users: [],
            }
        },

        created() {
    	    this.getUsers();

        },

        computed: {
    	    members: function () {
    	        return this.users.length;
            },
        },

        methods: {
            showDetail(id) {
                this.getUser(id);
            },
            showEdit(id) {
                this.getUser(id);
            },
            deleteUser(id) {
                let index = this.users.findIndex(item => {
                    return (id === item.id);
                })
                axios.delete(`/users/${id}`)
                    .then(({data}) => {
                        this.users.splice(index, 1);
                    }).catch(({error}) => {
                        console.log(error);
                    });
            },
            createUser() {
                axios.post('/users', this.newUser)
                    .then(({data}) => {
                        this.users.push(data.newUser);
                    }).catch(({error}) => {
                        alert('error');
                    });

                this.hideModal('create');
            },
            getUsers() {
                axios.get('/users')
                    .then(response => {
                        this.users= response.data.users;
                    }).catch(error => {
                    console.log(error);
                });
            },
            getUser(id) {
                axios.get(`/users/${id}`)
                    .then(({data}) => {
                        this.userDetail = data;
                    }).catch(({error}) => {
                    alert('ec');
                });
            },
            editUser(id) {
                let index = this.users.findIndex(item => {
                    return (id === item.id);
                })
                axios.patch(`/users/${id}`, this.userDetail)
                    .then(({data}) => {
                        Vue.set(this.users, index, data.user);
                    }).catch(error => function() {
                        console.log(error);
                    });
                $('#edi').modal('hide');
            },
            hideModal() {
                $('#create').modal('hide');
                $(document).on('hidden.bs.modal', '#create', function () {
                    $('#create input[id="name-create"]').val('');
                    $('#create input[id="email-create"]').val('');
                });
            },
        }
    }
</script>
