<template>
    <div class="container">
        <div class="row justify-content-center">
        	<div class="col-md-3">
	        	<button type="button" class="btn btn-info" v-if="user.isAdmin === 1">
	        		Add new
	    		</button>
    		</div>
            <div v-bind:class="(user.isAdmin === 1) ? 'col-md-9' : 'col-md-12'">
                <table>
	                <thead>
	                	<tr>
	                		<td style="padding:10px">Name</td>
	                		<td style="padding:10px">Email</td>
	                		<td style="padding:10px">Created at</td>
	                		<td style="padding:10px">Updated at</td>
	                	</tr>
                	</thead>
                	<tbody>
                		<tr v-for="user in users" :key="user.id">
                			<td style="padding:10px">{{ user.name }}</td>
	                		<td style="padding:10px">{{ user.email }}</td>
	                		<td style="padding:10px">{{ user.created_at }}</td>
	                		<td style="padding:10px">{{ user.updated_at }}</td>
                		</tr>
                	</tbody>
                </table>
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
    			default: () => ({}),
    		},
    		users: {
    			type: Array,
    			default: ()=> ({}),
    		}
    	},
        mounted() {
            console.log(this.user);
            console.log(this.users);
        }
    }
</script>