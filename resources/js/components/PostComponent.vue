<template>
	<div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
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
                			<td style="padding:10px">{{ user.name }}</td>
	                		<td style="padding:10px">{{ user.email }}</td>
	                		<td style="padding:10px">{{ user.created_at}}</td>
                		</tr>
                	</tbody>
                </table>
            </div>
            

            <detail-post-component></detail-post-component>
        </div>
    </div>
</template>

<script>
	import DetailPostComponent from './DetailPostComponent.vue'

	export default {
		name: 'post-component',

		components: {
			'detail-post-component': DetailPostComponent
		},

		data() {
			return {
				users: [],
				currentUser: [],
			}
		},

		created() {
			this.getUsers();
		},

		methods: {
			getUsers() {
				axios.get(`/users`)
					.then(({data}) => {
						this.users = data.users;
						console.log(data);
					}).catch(({error}) => {

					});
			},
		}
	}
</script>
