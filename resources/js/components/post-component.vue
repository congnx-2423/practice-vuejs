<template>
    <div class="container">
        <div class="row">
            <div class="col-5" id="post_table">
                <table style="border: 1px solid black">
                    <thead>
                        <tr>
                            <td style="padding:10px">Name</td>
                            <td style="padding:10px">Email</td>
                            <td style="padding:10px">Created at</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="user in users" :key="user.id">
                            <td style="padding:10px" @click="toggleExpansion(user.id)" :title="'Click me!'">{{ user.name }}</td>
                            <td style="padding:10px">{{ user.email }}</td>
                            <td style="padding:10px">{{ user.created_at}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <detail-post-component v-show="isExpanded(code)"
                :detail-post="detailPost"
                :edit-permission="currentUser.isAdmin"
            ></detail-post-component>
        </div>
    </div>
</template>

<script>
    import DetailPostComponent from './detail-post-component';

    export default {
        name: 'post-component',

        props: {
            currentUser: {
                type: Object,
                default: () => ({}),
            },
        },

        components: {
            DetailPostComponent
        },

        data() {
            return {
                users: [],
                detailPost: [],
                code: 0,
                editPermission: false,
            }
        },

        created() {
            this.getUsers();
        },

        methods: {
            getUsers() {
                axios.get(laroute.route('users.index'))
                    .then(({data}) => {
                        this.users = data.users;
                    }).catch(({error}) => {
                        alert('Error');
                    });
            },

            isExpanded(key) {
                return this.users.indexOf(key) !== -1;
            },

            toggleExpansion(key) {
                for (let index in this.users) {
                    if (this.users[index].id === key) {
                        this.detailPost = this.users[index].posts;
                        break;
                    }
                }
                this.code = key;
                if (this.isExpanded(key))
                    this.users.splice(this.users.indexOf(key), 1);
                else
                    this.users.push(key);
            }
        }
    }
</script>
<style scoped>
    #post_table {
        max-height: 800px;
        overflow-y: scroll;
    }
</style>
