<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>{{ config('app.name') }}</title>
    <style type="text/css" rel="stylesheet" media="all">
        /* Media Queries */
        @media only screen and (max-width: 500px) {
            .button {
                width: 100% !important;
            }
        }
    </style>
</head>
<?php
	$style = [
	/* Layout ------------------------------ */
	'body' => 'margin: 0; padding: 0; width: 100%; background-color: #F2F4F6;',
	'email-wrapper' => 'width: 100%; margin: 0; padding: 0 25px; background-color: #F2F4F6;',
	/* Masthead ----------------------- */
	'email-masthead' => 'padding: 25px 0; text-align: center;',
	'email-masthead_name' => 'font-size: 16px; font-weight: bold; color: #2F3133; text-decoration: none; text-shadow: 0 1px 0 white;',
	'email-body' => 'width: 100%; margin: 0; padding: 25px; border-top: 1px solid #EDEFF2; border-bottom: 1px solid #EDEFF2; background-color: #FFF;',
	'email-body_inner' => 'width: auto; max-width: 570px; margin: 0 auto; padding: 0;',
	'email-body_cell' => 'padding: 35px;',
	'email-footer' => 'width: auto; max-width: 570px; margin: 0 auto; padding: 0; text-align: center;',
	'email-footer_cell' => 'color: #AEAEAE; padding: 35px; text-align: center;',
	/* Body ------------------------------ */
	'body_action' => 'width: 100%; margin: 30px auto; padding: 0; text-align: center;',
	'body_sub' => 'margin-top: 25px; padding-top: 25px; border-top: 1px solid #EDEFF2;',
	'body_header' => 'margin-top: 0; color: #2F3133; font-size: 19px; font-weight: bold; text-align: left;',
	/* Type ------------------------------ */
	'anchor' => 'color: #3869D4;',
	'label' => 'padding-right: 7px;',
	'paragraph' => 'margin-top: 0; color: #74787E; font-size: 16px; line-height: 1.5em;',
	'paragraph-sub' => 'margin-top: 0; color: #74787E; font-size: 12px; line-height: 1.5em;',
	'paragraph-center' => 'text-align: center;',
	];
	$fontFamily = 'font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif;'; 
?>

<body style="{{ $style['body'] }}">
    <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td style="{{ $style['email-wrapper'] }}" align="center">
                <table width="100%" cellpadding="0" cellspacing="0">
                    <!-- Logo -->
                    <tr>
                        <td style="{{ $style['email-masthead'] }}"><a
                                style="{{ $fontFamily }} {{ $style['email-masthead_name'] }}" href="{{ url('/') }}"
                                target="_blank"> 
                                {{ config('app.name') }}
                            </a><br /><br />
                            <div align="center">Olá, {{ $contract['name'] }}</div>
                        </td>
                    </tr>
                    <!-- Email Body -->
                    <tr>
						<td style="{{ $style['email-body'] }}" width="100%">
							<h3 style="{{ $style['body_header'] }}">Confirmação de Contrato</h3>
                            <table style="{{ $style['body_action'] }}" align="center" width="100%" cellpadding="0"
                                cellspacing="0">
                                <tr>
									<th style="{{ $style['label'] }}" align="right" width="200px">Endereço da propriedade: </th>
                                    <td align="left">{{ $contract['property_address'] }} </td>
								</tr>
								<tr>
									<th style="{{ $style['label'] }}" align="right" width="200px">Tipo de Contrato: </th>
                                    <td align="left">{{ $contract['type_text'] }} </td>
                                </tr>
                                <tr>
									<th style="{{ $style['label'] }}" align="right" width="200px">Documento: </th>
                                    <td align="left">{{ $contract['document'] }} </td>
                                </tr>
								<tr>
									<th style="{{ $style['label'] }}" align="right" width="200px">Nome: </th>
                                    <td align="left">{{ $contract['name'] }} </td>
                                </tr>
								<tr>
									<th style="{{ $style['label'] }}" align="right" width="200px">E-mail: </th>
                                    <td align="left">{{ $contract['email'] }} </td>
                                </tr>
                                <tr>
									<th style="{{ $style['label'] }}" align="right" width="200px">Descrição: </th>
                                    <td align="left">{{ $contract['description'] }} </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <!-- Footer -->
                    <tr>
                        <td>
                            <table style="{{ $style['email-footer'] }}" align="center" width="570" cellpadding="0"
                                cellspacing="0">
                                <tr>
                                    <td style="{{ $fontFamily }} {{ $style['email-footer_cell'] }}">
                                        <p style="{{ $style['paragraph-sub'] }}"> &copy; {{ date('Y') }} <a
                                                style="{{ $style['anchor'] }}" href="{{ url('/') }}"
                                                target="_blank">{{ config('app.name') }}</a> | Todos os direitos reservados.</p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>