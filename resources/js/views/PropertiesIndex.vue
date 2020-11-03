<template>
	<v-card>
		<PageHeader	
			title="Lista de propriedades"
			action="/properties/create"
			actionColor="cyan"
			actionIcon="mdi-plus"
			actionText="Nova propriedade"
			:actionDarkMode="true"
		/>
		<Table 
			:headers="headers"
			:sortBy="sortBy"
			route="properties"
		/>
	</v-card>
</template>

<script>
	import PageHeader from '../components/PageHeader';
	import Table from '../components/Table';
	import api from '../api/api';
	
	export default {
		components: {
			PageHeader,
			Table
		},
		data () {
			return {
				sortBy: [ 'email' ],
				headers: [
					{ text: 'E-mail do proprietário', value: 'email' },
					{ text: 'Endereço da propriedade', value: 'full_address', sortable: true },
					{ text: 'Status', value: 'status', sortable: false },
					{ text: 'Ações', value: 'actions', sortable: false },
				],
			}
		},
	}
</script> 