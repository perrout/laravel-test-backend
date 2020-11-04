<template>
	<v-card>
		<v-card-title>
			<div class="text-h5 font-weight-bold text-uppercase">
				Teste Full Stack Laravel
			</div>
			<v-spacer></v-spacer>
		</v-card-title>
    <v-card-subtitle>
      O objetivo deste teste é entendermos um pouco mais sobre seus conhecimentos de Frontend e Backend no Laravel.
    </v-card-subtitle>
		<v-divider class="py-2"></v-divider>
		<v-card-text class="pt-0">
            <div class="py-2">
                <p class="subtitle-1 font-weight-bold">- Requisitos</p>
                <ul class="mb-6">
                    <li>PHP 7.1+</li>
                    <li>Laravel (Preferência 5.8+)</li>
                    <li>Vue.JS</li>
                    <li>Docker Engine</li>
                </ul>
                <p class="subtitle-1 font-weight-bold">Orientações</p>
                <p>Faça um fork deste projeto.</p>
                <p>Para facilitar o seu desenvolvimento, nós disponibilizamos um <code>docker-compose.yml</code> com o serviços que
                    utilizamos habitualmente no nosso dia a dia.</p>
                <p class="subtitle-1 font-weight-bold">-O Desafio</p>
                <p>Simular o cadastro de uma propriedade e criar um contrato para o mesmo.</p>
                <p class="subtitle-1 font-weight-bold">-Funcionalidade 1:</p>
                <ul class="mb-6">
                    <li>Permitir o cadastro de um imóvel com algumas características.</li>
                    <li>o cadastro de um imóvel deve possuir:</li>
                    <li>e-mail do proprietário, rua, número, complemento, bairro, cidade, estado;</li>
                </ul>
                <p>Para que o cadastro ocorra deverá haver validações em dois níveis. Frontend e backend:</p>
                <ul class="mb-6">
                    <li>e-mail, rua, bairro, cidade e estado são campos obrigatórios;</li>
                    <li>e-mail deverá ser validado;</li>
                </ul>
                <p class="subtitle-1 font-weight-bold">-Funcionalidade 2:</p>
                <ul class="mb-6">
                    <li>Contexto: Permitir visualização dos imóveis cadastrados. Os dados de imóveis deverão ser carregados via request
                        assíncrona. Esses dados deverão ser exibidos numa tabela e ao menos uma das colunas serem ordenáveis.</li>
                    <li> 
                        Dados que deverão ser exibidos na tabela:
                        <ul>
                            <li>E-mail do proprietário;</li>
                            <li>Rua, número, cidade, estado (separados por vírgula);</li>
                            <li>Status (Contratado / Não contratado)</li>
                            <li>Coluna para ações (remover).</li>
                        </ul>
                    </li>
                </ul>
                <p class="subtitle-1 font-weight-bold">Funcionalidade 3:</p>
                <ul class="mb-6">
                    <li>Contexto: permitir a remoção de uma propriedade via chamada assíncrona com atualização posterior da lista de
                        propriedades.</li>
                    <li>Observação: a remoção de uma propriedade deverá ser virtual.</li>
                </ul>
                <p class="subtitle-1 font-weight-bold">Funcionalidade 4:</p>
                <ul class="mb-6">
                    <li>Contexto: Criação de um contrato que permita associação com uma propriedade. Um contrato possui os seguintes
                        campos:</li>
                    <li>Propriedade (deverá ser selecionável a propriedade. Sendo usado como informação da propriedade a rua, número,
                        complemento, bairro);</li>
                    <li>Tipo de pessoa (Pessoa física ou Pessoa Jurídica);</li>
                    <li>Documento (A máscara do campo de documento deverá alterar de acordo com o tipo de pessoa. Pessoa física deverá
                        ser máscara de CPF e pessoa jurídica deverá ser máscara de CNPJ)</li>
                    <li>E-mail do contratante;</li>
                    <li>Nome completo do contratante;</li>
                </ul>
                <p class="subtitle-1 font-weight-bold">Regras específicas sobre a criação de contrato:</p>
                <ul class="mb-6">
                    <li>Uma propriedade não pode estar associada a dois contratos;</li>
                    <li>Todos os campos do contrato são obrigatórios;</li>
                    <li>Deverá ocorrer validação do documento;</li>
                    <li>Deverá ocorrer validação do e-mail;</li>
                </ul>
                <p class="subtitle-1 font-weight-bold">Extras</p>
                <ul class="mb-6">
                    <li>Job: deve-se utilizar alguma forma de job;</li>
                    <li>Teste unitário de backend;</li>
                    <li>Teste de integração backend;</li>
                    <li>SPA.</li>
                    <li>Usabilidade (A usabilidade das funcionalidades fica a cargo do desenvolvedor) :D</li>
                </ul>
                <p class="subtitle-1 font-weight-bold">Entrega</p>
                <p>Deixar um repositório público e nos enviar por e-mail - o mesmo e-mail que foi enviado o teste.</p>
            </div>
		</v-card-text>
	</v-card>
</template>