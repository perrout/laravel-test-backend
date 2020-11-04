<template>
	<v-card>
		<PageHeader	
			title="Editar propriedade"
			action="/properties"
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
						sm="6"
						md="8"
					>
						<v-text-field
							ref="email"
							label="E-mail do proprietário"
							v-model="property.email"
							:error-messages="emailErrors"
							required
							@input="$v.property.email.$touch()"
							@blur="$v.property.email.$touch()"
						></v-text-field>
					</v-col>
					<v-col
						cols="12"
						sm="6"
						md="4"
					>
						<v-text-field
							ref="postal"
							label="CEP"
							v-model="property.postal"
							v-mask="'#####-###'"
            				@blur="onPostalChange"
						></v-text-field>
					</v-col>
					<v-col
						cols="12"
						sm="6"
						md="10"
					>
						<v-text-field
							ref="address"
							label="Endereço"
							v-model="property.address"
							:error-messages="addressErrors"
							required
							@input="$v.property.address.$touch()"
							@blur="$v.property.address.$touch()"
						></v-text-field>
					</v-col>
					<v-col
						cols="12"
						sm="6"
						md="2"
					>
						<v-text-field
							ref="number"
							label="Número"
							v-model="property.number"
						></v-text-field>
					</v-col>
					<v-col
						cols="12"
						sm="6"
						md="12"
					>
						<v-text-field
							ref="secondary_address"
							label="Complemento"
							v-model="property.secondary_address"
						></v-text-field>
					</v-col>
					<v-col
						cols="12"
						sm="6"
						md="4"
					>
						<v-text-field
							ref="neighborhood"
							label="Bairro"
							v-model="property.neighborhood"
							:error-messages="neighborhoodErrors"
							required
							@input="$v.property.neighborhood.$touch()"
							@blur="$v.property.neighborhood.$touch()"
						></v-text-field>
					</v-col>

					<v-col
						cols="12"
						sm="6"
						md="4"
					>
						<v-text-field
							ref="city"
							label="Cidade"
							v-model="property.city"
							:error-messages="cityErrors"
							required
							@input="$v.property.city.$touch()"
							@blur="$v.property.city.$touch()"
						></v-text-field>
					</v-col>

					<v-col
						cols="12"
						sm="6"
						md="4"
					>
						<v-text-field
							ref="state"
							label="Estado"
							v-model="property.state"
							:error-messages="stateErrors"
							required
							@input="$v.property.state.$touch()"
							@blur="$v.property.state.$touch()"
						></v-text-field>
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
							to="/properties"
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
	import apiPostal from '../api/apiPostal';

	export default {
		components: {
			PageHeader,
		},
		mixins: [validationMixin],
		validations: {
			property: {
				email: { required },
				address: { required },
				neighborhood: { required },
				city: { required },
				state: { required }
			}
		},
		data: () => ({
			route: 'properties',
			loading: false,
			errors: false,
			property: {
				id: null,
				email: '',
				postal: '',
				address: '',
				number: '',
				secondary_address: '',
				neighborhood: '',
				city: '',
				state: '',
			}
		}),
		computed: {
			emailErrors () {
				const errors = []
				if (!this.$v.property.email.$dirty) return errors
				// !this.$v.property.email.email && errors.push('Informe um endereço de e-mail válido.')
				!this.$v.property.email.required && errors.push('O campo E-mail é obrigatório.')
				return errors
			},
			addressErrors () {
				const errors = []
				if (!this.$v.property.address.$dirty) return errors
				!this.$v.property.address.required && errors.push('O campo Endereço é obrigatório.')
				return errors
			},
			neighborhoodErrors () {
				const errors = []
				if (!this.$v.property.neighborhood.$dirty) return errors
				!this.$v.property.neighborhood.required && errors.push('O campo Bairro é obrigatório.')
				return errors
			},
			cityErrors () {
				const errors = []
				if (!this.$v.property.city.$dirty) return errors
				!this.$v.property.city.required && errors.push('O campo Cidade é obrigatório.')
				return errors
			},
			stateErrors () {
				const errors = []
				if (!this.$v.property.state.$dirty) return errors
				!this.$v.property.state.required && errors.push('O campo Estado é obrigatório.')
				return errors
			},
			validationErrors(){
				if ( this.errors ) {
					let errors = Object.values(this.errors);
					errors = errors.flat();
					return errors;
				}
			}
		},
		created() {
			this.fetchDataFromApi();
		},
		methods: {
			fetchDataFromApi() {
				this.loading = true;
				api.find( this.route, this.$route.params.id )
					.then((response) => {
						this.property = response.data.data;
					})
					.catch((err) => {
						this.$notify({
							group: 'message',
							title: 'Ops! A Propriedade não existe.',
							type: 'error'
						});
						this.$router.push({ name: '404' });
					})
					.finally(() => (this.loading = false));
			},
			onPostalChange () {
				let postcode = this.$refs.postal.value;
				apiPostal.get( postcode )
						.then((response) => {
							if ( !response.data.erro ) {
								Object.assign(this.property, {
									address: response.data.logradouro,
									number: '',
									secondary_address: '',
									neighborhood: response.data.bairro,
									city: response.data.localidade,
									state: response.data.uf,
								});
								this.$refs.number.focus();
							}else {
								Object.assign(this.property, {
									address: '',
									number: '',
									secondary_address: '',
									neighborhood: '',
									city: '',
									state: '',
								});
							}
						})
						.catch(function (error) {
							Object.assign(this.property, {
								address: '',
								number: '',
								secondary_address: '',
								neighborhood: '',
								city: '',
								state: '',
							});
						});
			},	
			submit () {
				this.$v.$touch();
				if (this.$v.$invalid) {
					for (let key in Object.keys(this.$v.property)) {
						const input = Object.keys(this.$v.property)[key];
						if (input.includes("$")) return false;
						if (this.$refs[input] && this.$v.property[input].$error) {
							this.$refs[input].focus();
							break;
						}
					}
				} else {
					let errorTimer = null;
					this.loading = true;
					api.update( this.route, this.property.id, this.property )
						.then((response) => {
							this.$notify({
								group: 'message',
								title: response.data.message,
								type: 'success'
							});
							this.property = response.data.data;
						})
						.catch((e) => {
							clearTimeout( errorTimer );
							this.errors = e.response.data;
							errorTimer = setTimeout(() => this.errors = null, 5000);
						})
						.then( () => this.loading = false );
				}
			},
		},
	}
</script>