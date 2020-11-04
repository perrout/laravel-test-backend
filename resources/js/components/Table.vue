<template>
	<v-data-table
		:headers="tableHeaders"
		:items="tableItems"
		:items-per-page="tableItemsPerPage"
		:sort-by="tableSortBy"
		:sort-desc="tableSortDesc"
		:options.sync="tableOptions"
		:server-items-length="tablePageCount"
		:loading="tableLoading"
		:footer-props="tableFooter"
		class="pt-4"
	>
		<template v-slot:[`item.actions`]="{ item }">
			<v-icon
				small
				class="mr-2"
				@click="editItem(item)"
			>
				mdi-pencil
			</v-icon>
			<v-icon
				small
				@click="deleteItem(item)"
			>
				mdi-delete
			</v-icon>
		</template>
		<template v-slot:no-data>
			<div>
				Nenhum item cadastrado. 
			</div>
		</template>
	</v-data-table>
</template>

<script>
  	import api from '../api/api';

	export default {
		props: {
			headers: {
				type: Array,
				required: true
			},
			sortBy: {
				type: Array,
				required: true
			},
			route: {
				type: String,
				required: true
			},
		},
		data () {
			return {
				message: false,
				messageType: 'info',  
				tableLoading: true,
				tablePage: 1,
				tablePageCount: 0,
				tableItemsPerPage: 10,
				tableSortBy: this.sortBy || [],
				tableSortDesc: false,
				tableHeaders: this.headers || [],
				tableFooter: {
					itemsPerPageOptions: [10, 25, 50, 100],
					itemsPerPageText: 'Itens por página',
					pageText: '{0}-{1} de {2}'
				},
				tableOptions: {},
				tableItems: []
			}
		},
		watch: {
			tableOptions: {
				handler () {
					this.fetchDataFromApi()
				},
				deep: true,
			}
		},
		methods: {
			async fetchDataFromApi() {
				this.tableLoading = true;
				const { sortBy, sortDesc, page, itemsPerPage } = this.tableOptions
				const params = {
					sortBy: sortBy.length === 1 ? sortBy[0] : '',
					sortDesc: sortDesc.length === 1 ? sortDesc[0] : false,
					page: page ? page : 1,
					itemsPerPage: itemsPerPage ? itemsPerPage : 10
				}
				try {
					let response = await api.all( this.route, { params } );
					let data = response.data;
					if ( data ) {
						this.tableItems = data.data;
						this.tablePage = parseInt( data.current_page );
						this.tablePageCount = parseInt( data.total );
						this.tableItemsPerPage = parseInt( data.per_page );
					}
				} catch (error) {
					console.log(error)
					this.$notify({
						group: 'message',
						title: 'Ops! Ocorreu um problema ao coletar itens da tabela.',
						type: 'error'
					});
				}
				this.tableLoading = false;
			},

			editItem(item) {
				this.$router.push({ name: `${this.route}.edit`, params: { id: item.id } });
			},

			deleteItem(item) {
				this.tableLoading = true;
				api.delete( this.route, item.id )
					.then((response) => {
						this.tableLoading = false;
						this.fetchDataFromApi();
						this.$notify({
							group: 'message',
							title: response.data.message,
							type: 'success'
						});
					})
          			.finally(() => (this.loading = false));
			},
		},
	}
</script> 