<template>
	<v-card>
		<v-card-title>
			<div class="text-h5 font-weight-bold text-uppercase">
				Editar contrato
			</div>
			<v-spacer></v-spacer>
			<v-btn 
				color="secundary"
				to="/contracts">
				<v-icon class="pr-1">mdi-arrow-left</v-icon>Voltar
			</v-btn>
		</v-card-title>
		<v-divider class="py-2"></v-divider>
		<v-card-text class="pt-0">
			<v-alert
				:value="true"
				type="info"
				v-if="message" 
			>
				{{ message }}
			</v-alert>

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
							label="Selecione a propriedade"
							v-model="contract.property_id"
							:items="properties"
							item-value="id"
							item-text="full_address"
							clearable
							required
							:error-messages="propertyErrors"
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
							:disabled="saving"
						>
							<v-icon class="pr-1">mdi-content-save</v-icon>{{ saving ? 'Salvando...' : 'Salvar' }}
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
import api from '../api/api';

export default {
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
		saving: false,
		message: false,
		errors: false,
		contract: {
			id: null,
			property_id: '',
			type: 'person',
			document: '',
			email: '',
			name: '',
			description: '',
		}
	}),
	computed: {
		documentLabel() {
			 return this.contract.type === 'person' ? 'CPF' : 'CNPJ';
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
	},
	created() {
		api.all( 'properties' )
			.then((response) => {
				this.properties = response.data.data;
			});

		api.find( this.route, this.$route.params.id )
			.then((response) => {
				this.loaded = true;
				console.log(response.data.data)
				this.contract = response.data.data;
			})
			.catch((err) => {
				this.$router.push({ name: '404' });
			});;
	},
	methods: {
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
				this.saving = true;
				this.message = false;
				api.update( this.route, this.contract.id, this.contract )
					.then((response) => {
						this.message = response.data.message;
						this.contract = response.data.data;
						setTimeout(() => this.message = null, 5000);
					})
					.catch((e) => {
						this.saving = false;
						this.alert = true;
						this.errors = e.response.data;
						setTimeout(() => this.errors = null, 5000);
					})
					.then( () => this.saving = false )
			}
		},
	},
}
</script>