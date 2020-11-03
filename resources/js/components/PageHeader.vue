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
		<v-divider class="py-2"></v-divider>
	</div>
</template>

<script>
	export default {
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
		},
	}
</script>