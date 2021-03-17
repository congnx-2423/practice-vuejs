<template>
    <div class="container">
        <div class="row">
            <div style="float: left">
                Number of members: {{ members }}
            </div>
            <div v-if="user.isAdmin === 1" ref="addNew">
                <button :title="'Adding new user'" type="button" class="btn btn-primary" @click="showCreateModal">Add</button>
            </div>
<!--            <linh-tinh-component :number="number" :title="'Button 1'" @updateNumber="updateNumber"></linh-tinh-component>-->
<!--            <linh-tinh-component :number="number" :title="'Button 2'" @updateNumber="updateNumber"></linh-tinh-component>-->
<!--            <huhu-component :number="number" @updateNumber="updateNumber"></huhu-component>-->
        </div>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <table>
	                <thead>
	                	<tr style="position: sticky; top: 0; background-color: #f7f7f7">
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
                			<td style="padding:10px">{{ shortName(useR.name,  15) }}</td>
	                		<td style="padding:10px">{{ shortName(useR.email, 20) }}</td>
	                		<td style="padding:10px">{{ useR.created_at }}</td>
	                		<td style="padding:10px">{{ useR.updated_at }}</td>
                            <td style="padding:10px">
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#detail" data-whatever="@mdo" @click="showDetail(useR.id)">
                                    View
                                </button>
                            </td>
                            <td style="padding:10px" v-if="user.isAdmin === 1">
                                <button type="button" class="btn btn-primary" @click="showEdit(useR.id)">
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

        <modal-component v-if="showModal" :title="title" :button="button" :userDetail="userDetail" ></modal-component>
    </div>
</template>
<script>
    import LinhTinhComponent from "./linh-tinh-component";
    import HuhuComponent from "./huhu-component";
    import ModalComponent from "./modal-component";

    export default {
    	name: 'dashboard-component',
        components: {
    	    LinhTinhComponent,
            HuhuComponent,
            ModalComponent
        },
        props: {
    	    user: {
    	        type: Object,
                default: function () {
                    return {};
                },
            },
        },
        data() {
    	    return {
                userDetail: {},
                newUser: {
                    name: '',
                    email: '',
                },
                users: [],
                title: '',
                button: '',
                showModal: false,
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
                this.showModal = true;
                this.getUser(id);

                this.$nextTick(() => {
                    window.$('#create-update-modal').modal('show');
                });
            },

            deleteUser(id) {
                let index = this.users.findIndex(item => {
                    return (id === item.id);
                });

                axios.delete(laroute.route('users.destroy', {user: id}))
                    .then(({data}) => {
                        this.users.splice(index, 1);
                    }).catch(({error}) => {
                        alert('Error');
                    });
            },

            getUsers() {
                axios.get(laroute.route('users.index'))
                    .then(response => {
                        this.users = response.data.users;
                    }).catch(error => {
                        alert('Error');
                    });
            },

            getUser(id) {
                axios.get(laroute.route('users.show', {user: id}))
                    .then(({data}) => {
                        this.userDetail = data;
                    }).catch(({error}) => {
                        alert('Error');
                    });
            },

            shortName(input, limit) {
                if (input.length > limit) {
                    let shortName = input.substring(0, limit);

                    return shortName + '...';
                }

                return input;
            },

            showCreateModal() {
                this.showModal = true;
                this.title = undefined;
                this.button = undefined;
                this.$nextTick(() => {
                    window.$('#create-update-modal').modal('show');
                });
            }
        }
    }
</script>
