<template>
	<div class="">
		<div class="d-flex flex-row justify-space-between align-center pa-4">
			<div class="text-h5 font-weight-bold text-uppercase">
				{{ title }}
			</div>
			<v-spacer></v-spacer>
			<v-btn v-if="action" :color="actionColor" :to="action" :dark="actionDarkMode"> 
				<v-icon class="pr-1">{{ actionIcon }}</v-icon>{{ actionText }}
			</v-btn>
		</div>
		<PageLoading :loading="loading" />
		<v-divider class="py-2"></v-divider>
	</div>
</template>

<script>
	import PageLoading from '../components/PageLoading';
	export default {
		components: {
			PageLoading,
		},
		props: {
			title: {
				type: String,
				required: true
			},
			action: {
				type: String
			},
			actionColor: {
				type: String
			},
			actionIcon: {
				type: String
			},
			actionText: {
				type: String
			},
			actionDarkMode: {
				type: Boolean,
			},
			loading: {
				type: Boolean,
			},
		},
	}
</script>