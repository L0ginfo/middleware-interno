<?php

$empresa = 'BARRA DO RIO';


return [
    'EMPRESA' => $empresa,
	'base-url' => 'http://agendamento.barradorio.com.br:8080/',
	'md5-salt' => 'salt-5dgd4er815uko4i51g8g',

	// case sensitive
	'boleto-path' => '//10.1.1.201/totvs/TOTVS11_PRD/Microsiga/Protheus_Data/BOLETO/',
	'nfse-itajai-url' => 'http://nfse.itajai.sc.gov.br/nfse/NFES?nfp_numero=%s&nfp_serie=%s&nfp_tipo=1&cdt_cnpjcpf=%s&chave_validacao=%s',
    'nfse-itajai-cnpj' => '06989608000177',

    'mail-profiles' => [
        'default' => [
            'host' => 'smtp.office365.com',
            'auth' => 'login',
            'username' => 'faturamento@barradorio.com.br',
            'password' => 'Caya9879',
            'ssl' => 'tls',
            'port' => '587',
            'from_email' => 'faturamento@barradorio.com.br',
            'from_name' => "Portal $empresa",
            'bcc' => 'comex@barradorio.com.br;financeiro@barradorio.com.br',
            //'reply_name' => '',
            //'reply_to' => '',
        ],

        'nfe' => [
            'host' => 'smtp.office365.com',
            'auth' => 'login',
            'username' => 'faturamento@barradorio.com.br',
            'password' => 'Caya9879',
            'ssl' => 'tls',
            'port' => '587',
            'from_email' => 'faturamento@barradorio.com.br',
            'from_name' => "Portal $empresa",
            'bcc' => 'comex@barradorio.com.br;financeiro@barradorio.com.br',
            //'reply_name' => '',
            //'reply_to' => '',
        ],
        'comex' => [
            'host' => 'smtp.office365.com',
            'auth' => 'login',
            'username' => 'comex@barradorio.com.br',
            'password' => 'Pa$$w0rd',
            'ssl' => 'tls',
            'port' => '587',
            'from_email' => 'comex@barradorio.com.br',
            'from_name' => "Portal $empresa",
           // 'bcc' => 'faturamento@barradorio.com.br',
            //'reply_name' => '',
            //'reply_to' => '',
        ],
    ]
];
