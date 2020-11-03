<template>
	<v-card>
		<PageHeader	
			title="Lista de contratos"
			action="/contracts/create"
			actionColor="cyan"
			actionIcon="mdi-plus"
			actionText="Novo contrato"
			:actionDarkMode="true"
		/>
		<Table 
			:headers="headers"
			:sortBy="sortBy"
			route="contracts"
		/>
	</v-card>
</template>

<script>
  	import api from '../api/api';
	import PageHeader from '../components/PageHeader';
	import Table from '../components/Table';

	export default {
		components: {
			PageHeader,
			Table
		},
		data () {
			return {
				route: 'contracts',
				sortBy: ['name'],
				headers: [
					{ text: 'Nome do contratante', value: 'name' },
					{ text: 'E-mail do contratante', value: 'email' },
					{ text: 'Propriedade', value: 'property_address', sortable: false },
					{ text: 'Ações', value: 'actions', sortable: false },
				],
			}
		},
	}
</script> 