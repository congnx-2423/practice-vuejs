<template>
    <div>
        <div class="col-7 post-table" v-if="totalPost > 0">
            <table>
                <thead>
                    Total: {{ totalPost }}
                    <tr>
                        <td style="padding:10px">Content</td>
                        <td style="padding:10px">Created at</td>
                        <td style="padding:10px" v-if="editPermission === 1">Edit</td>
                        <td style="padding:10px" v-if="editPermission === 1">Delete</td>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="post in detailPost" :key="post.id">
                        <td style="padding:10px">{{ post.content }}</td>
                        <td style="padding:10px">{{ post.created_at}}</td>
                        <td style="padding:10px" v-if="editPermission === 1">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#edit" data-whatever="@mdo" @click="showEdit(post.id)">
                                Edit
                            </button>
                        </td>
                        <td style="padding:10px" v-if="editPermission === 1">
                            <button type="button" class="btn btn-primary" @click="deletePost(post.id)">
                                Delete
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-7" v-else>
            Empty
        </div>

        <div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <label for="content-edit" class="col-form-label">Content</label>
                                <input type="text" class="form-control" id="content-edit" v-model="editPost.content">
                            </div>
                            <span @click="updatePost(editPost.id)" class="btn btn-primary">Update</span>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>
<script>
    export default {
        name: 'detail-post-component',

        props: {
            detailPost: {
                type: Array,
                defaul: [],
            },
            editPermission: {
                type: Number,
                default: 0,
            },
        },

        computed: {
            totalPost() {
                return this.detailPost.length;
            }
        },

        data() {
            return {
                editPost: [],
            }
        },

        methods:{
            showEdit(id) {
                this.getPost(id);
            },
            updatePost(id) {
                let index = this.detailPost.findIndex(item => {
                    return (id === item.id);
                });
                axios.patch(laroute.route('posts.update', {post: id}), this.editPost)
                    .then(({data}) => {
                        Vue.set(this.detailPost, index, data.post);
                    }).catch(({error}) => {
                        alert('Error');
                    });

                $('#edit').modal('hide');
            },
            getPost(id) {
                axios.get(laroute.route('posts.show', {post: id}))
                    .then(({data}) => {
                        this.editPost = data.post;
                    }).catch(({error}) => {
                        alert('Error');
                    });
            },
            deletePost(id) {
                let index = this.detailPost.findIndex(item => {
                    return (id === item.id);
                });

                axios.delete(laroute.route('posts.destroy', {post: id}))
                    .then(({data}) => {
                        this.detailPost.splice(index, 1);
                    }).catch(({error}) => {
                        alert('Error');
                    });
            }
        }
    }
</script>
<style scoped>
    .post-detail {
        max-height: 500px;
        overflow-y: scroll;
    }
</style>
