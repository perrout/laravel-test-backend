<template>
	<v-card>
		<PageHeader	
			title="Editar contrato"
			action="/contracts"
			actionColor="secundary"
			actionIcon="mdi-arrow-left"
			actionText="Voltar"
			:loading="loading"
		/>
		<v-card-text class="pt-0">
			<div v-if="validationErrors">
				<v-alert 
					type="error"
				>
					<ul>
						<li v-for="(error, key, index) in validationErrors" :key="key">
							{{ error }}
						</li>
					</ul>
				</v-alert>
			</div>

			<v-form class="p-0" @submit.prevent="submit">
				<v-row>
					<v-col
						cols="12"
						sm="12"
						md="12"
					>
						<v-autocomplete
							ref="property_id"
							label="Busque a propriedade"
							v-model="propertySelected"
							:items="propertiesFound"
        					:search-input.sync="propertySearch"
							:error-messages="propertyErrors"
							:loading="loadingProperties"
							:no-data-text="propertiesNotFound"
							clearable
							required
							return-object
						    hide-selected
							@input="$v.contract.property_id.$touch()"
							@blur="$v.contract.property_id.$touch()"
						></v-autocomplete>
					</v-col>

					<v-col
						cols="12"
						sm="6"
						md="6"
					>
						<v-radio-group
							ref="type"
							label="Tipo de contrato"
							v-model="contract.type"
							row
							:error-messages="typeErrors"
							required
							@input="$v.contract.type.$touch()"
							@blur="$v.contract.type.$touch()"
						>
							<v-radio
								value="person"
							>
								<template v-slot:label>
									<div><v-icon>mdi-account</v-icon> Pessoa Física</div>
								</template>
							</v-radio>
							<v-radio
								value="company"
							>
								<template v-slot:label>
									<div><v-icon>mdi-account-tie</v-icon> Pessoa Jurídica</div>
								</template>
							</v-radio>
						</v-radio-group>
					</v-col>
					<v-col
						cols="12"
						sm="6"
						md="6"
					>
						<v-text-field
							ref="document"
							:label="documentLabel"
							v-model="contract.document"
							:error-messages="documentErrors"
							required
							@input="$v.contract.document.$touch()"
							@blur="$v.contract.document.$touch()"
							v-mask="documentMask"
						></v-text-field>
					</v-col>
					<v-col
						cols="12"
						sm="6"
						md="6"
					>
						<v-text-field
							ref="name"
							label="Nome do contratante"
							v-model="contract.name"
							:error-messages="nameErrors"
							required
							@input="$v.contract.name.$touch()"
							@blur="$v.contract.name.$touch()"
						></v-text-field>
					</v-col>
					<v-col
						cols="12"
						sm="6"
						md="6"
					>
						<v-text-field
							ref="email"
							label="E-mail do contratante"
							v-model="contract.email"
							:error-messages="emailErrors"
							required
							@input="$v.contract.email.$touch()"
							@blur="$v.contract.email.$touch()"
						></v-text-field>
					</v-col>
					<v-col
						cols="12"
						sm="12"
						md="12"
					>
						<v-textarea
							ref="description"
							label="Descrição"
							v-model="contract.description"
						></v-textarea>
					</v-col>
				</v-row>
				<v-row>
					<v-col
						cols="12"
						class="text-center mb-4"
					>
						<v-btn
							color="error"
							text
							to="/contracts"
							class="mb-4 mb-md-0 mr-md-4"
						>
							<v-icon class="pr-1">mdi-cancel</v-icon>Cancelar 
						</v-btn>
						<v-btn
							color="primary"
							type="submit"
							:disabled="loading"
						>
							<v-icon class="pr-1">mdi-content-save</v-icon>{{ loading ? 'Salvando...' : 'Salvar' }}
						</v-btn>
					</v-col>
				</v-row>
			</v-form>
		</v-card-text>
	</v-card>
</template>

<script>
import { validationMixin } from 'vuelidate';
import { required, maxLength, email } from 'vuelidate/lib/validators';
import PageHeader from '../components/PageHeader';
import api from '../api/api';

export default {
	components: {
		PageHeader,
	},
	mixins: [ validationMixin ],
	validations: {
		contract: {
			property_id: { required },
			type: { required },
			document: { required },
			email: { required },
			name: { required }
		}
	},
	data: () => ({
		route: 'contracts',
        properties: [],
		loading: false,
		errors: false,
		contract: {
			id: null,
			property_id: '',
			type: 'person',
			document: '',
			email: '',
			name: '',
			description: '',
		},
		propertySearch: null,
		propertySelected: null,
		loadingProperties: false
	}),
	computed: {
		documentLabel() {
			 return this.contract.type === 'person' ? 'CPF' : 'CNPJ';
		},
		documentMask() {
			 return this.contract.type === 'person' ? '###.###.###-##' : '##.###.###/####-##';
		},
		propertyErrors () {
			const errors = []
			if (!this.$v.contract.property_id.$dirty) return errors
			!this.$v.contract.property_id.required && errors.push('O campo Propriedade é obrigatório.')
			return errors
		},
		typeErrors () {
			const errors = []
			if (!this.$v.contract.type.$dirty) return errors
			!this.$v.contract.type.required && errors.push('O campo Tipo de contrato é obrigatório.')
			return errors
		},
		documentErrors () {
			const errors = []
			if (!this.$v.contract.document.$dirty) return errors
			!this.$v.contract.document.required && errors.push('O campo CPF/CNPJ é obrigatório.')
			return errors
		},
		emailErrors () {
			const errors = []
			if (!this.$v.contract.email.$dirty) return errors
			// !this.$v.contract.email.email && errors.push('Informe um endereço de e-mail válido.')
			!this.$v.contract.email.required && errors.push('O campo E-mail é obrigatório.')
			return errors
		},
		nameErrors () {
			const errors = []
			if (!this.$v.contract.name.$dirty) return errors
			!this.$v.contract.name.required && errors.push('O campo Nome é obrigatório.')
			return errors
		},
		validationErrors(){
			if ( this.errors ) {
				let errors = Object.values( this.errors );
				errors = errors.flat();
				return errors;
			}
		},
		propertiesFound() {
			let _properties = this.properties;
			if ( _properties && _properties.length ) {
				_properties = _properties.map( item => ( { text: item.full_address, value: item.id } ) );
			}
			return _properties;
		},
		propertiesNotFound() {
			return this.loadingProperties ? 'Carregando propriedades...' : 'Nenhuma propriedade encontrada.';
		}
	},
	created() {
		this.fetchPropertiesFromApi();
		this.fetchDataFromApi();
	},
    watch: {
		propertySearch( value ) {
			if ( this.loadingProperties ) return;
			if ( value && ( !this.propertySelected || this.propertySelected.text !== value ) ) {
				this.fetchPropertiesFromApi( value )
			}
		},
		propertySelected( item ) {
			this.setProperty( item );
		},
	},
	methods: {
		setProperty( item ) {
			if ( !item ) {
				this.contract = Object.assign( this.contract, { property_id: null } );
				this.propertySelected = null;
			} else if ( !this.propertySelected || this.propertySelected.value !== this.contract.property_id ) {
				this.contract = Object.assign( this.contract, { property_id: item.value } );
				this.propertySelected = item;
			}
		},
		getPropertyById( id ) {
			return this.properties.find( item => item.id === id );
		},
		async fetchPropertiesFromApi( value = false ) {
			this.loadingProperties = true;
			const params = {
				doesntHave: 'contract',
				doesntHaveIgnore: this.$route.params.id,
				sortBy: 'full_address',
			}
			if ( value ) {
				Object.assign( params, {
					search: value,
					searchColumn: 'address',
				});
			}
			const response = await api.all( 'properties', { params } );
			try {
				if ( response.data && response.data.data ) {
					let data = response.data.data;
					if ( this.properties.length > 0 && data.length > 0 ) {
						let union = _.unionBy( this.properties, data, 'id' );
						this.properties = _.uniqBy( union, 'id' );
					}else {
						this.properties = data;
					}
				}else {
					this.properties = [];
				}
			} catch (error) { 
				console.log(error)
				this.$notify({
					group: 'message',
					title: 'Ops! Ocorreu um problema ao coletar propriedades.',
					type: 'error'
				});
			}
			this.loadingProperties = false;
		},
		fetchDataFromApi() {
			this.loading = true;
			api.find( this.route, this.$route.params.id )
				.then((response) => {
					if ( response.data && response.data.data ) {
						let data = response.data.data;
						if ( data.property_id ) {
							const property = this.getPropertyById( data.property_id );
							if ( this.properties.length && property ) {
								this.propertySelected = { text: property.full_address, value: property.id };
							}
						}
						this.contract = Object.assign( this.contract, data );
					}
				})
				.catch((err) => {
					this.$notify({
						group: 'message',
						title: 'Ops! O contrato não existe.',
						type: 'error'
					});
					this.$router.push({ name: '404' });
				})
				.finally(() => (this.loading = false));
		},
		submit () {
			this.$v.$touch();
			if (this.$v.$invalid) {
				for (let key in Object.keys(this.$v.contract)) {
					const input = Object.keys(this.$v.contract)[key];
					if (input.includes("$")) return false;
					if (this.$refs[input] && this.$v.contract[input].$error) {
						this.$refs[input].focus();
						break;
					}
				}
			} else {
				let errorTimer = null;
				this.loading = true;
				api.update( this.route, this.contract.id, this.contract )
					.then((response) => {
						this.$notify({
							group: 'message',
							title: response.data.message,
							type: 'success'
						});
						// this.contract = response.data.data;
						// this.fetchPropertiesFromApi();
					})
					.catch((e) => {
						clearTimeout( errorTimer );
						this.errors = e.response.data;
						errorTimer = setTimeout(() => this.errors = null, 5000);
					})
          			.finally(() => (this.loading = false));
			}
		},
	},
}
</script>