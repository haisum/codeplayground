<?php
return [
	"languages" => [
		"php" => [
			"command" => 'docker run --rm -v %s:/myapp.php:ro php:5.6-cli sh -c "useradd dummy; su dummy -c \'php /myapp.php\'"',
			"aceModeScript" => "mode-php.js",
		],
		"golang" => [
			"command" => 'docker run --rm -v %s:/myapp.go:ro golang:1.4 sh -c "go build /myapp.go; useradd dummy; su dummy -c ./myapp"',
			"aceModeScript" => "mode-golang.js",
		],
		"c" => [
			"command" => 'docker run --rm -v %s:/myapp.c:ro gcc:4.9 sh -c "gcc -o myapp /myapp.c; useradd dummy; su dummy -c ./myapp"',
			"aceModeScript" => "mode-c_cpp.js",
		],
		"c++" => [
			"command" => 'docker run --rm -v %s:/myapp.cpp:ro gcc:4.9 sh -c "g++ -o myapp /myapp.cpp; useradd dummy; su dummy -c ./myapp"',
			"aceModeScript" => "mode-c_cpp.js",
		],
		"bash" => [
			"command" => 'docker run --rm -v %s:/myapp.sh:ro ubuntu:14.04 sh -c "cat myapp.sh > myapp; chmod +x myapp; useradd dummy; su dummy -c ./myapp"',
			"aceModeScript" => "mode-sh.js",
		],
		"python" => [
			"command" => 'docker run --rm -v %s:/myapp.py:ro python:2.7 sh -c "useradd dummy; su dummy -c \'python /myapp.py\'"',
			"aceModeScript" => "mode-python.js",
		]
	],
	//configuration for frontend
	"jsConfig" => [
		'aceModes' => [
			"php" => [
				'mode' => "php",
			],
			"golang" => [
				'mode' => "golang",
			],
			"c" => [
				'mode' => "c_cpp",
			],
			"c++" => [
				'mode' => "c_cpp",
			],
			"bash" => [
				'mode' => "sh",
			],
			"python" => [
				'mode' => "python",
			]
		],
		'requestUrl' => 'execute',
		'aceTheme' => 'textmate',
	],
	"codeFile" => __DIR__ . "/../runtime/codeFile",
	"httpService" => "http://localhost:4000",
];