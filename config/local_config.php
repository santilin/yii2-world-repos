<?php

$config['components']['db']['dsn'] = "sqlite:@app/runtime/wrepos.db";
if ($web_app) {
	$config['components']['request']['cookieValidationKey'] = '␒Q␒␆ÉÑ␙4J/�\"¶F�TÄV€f}BH␋Ý¿œ8␏�M®�Nò�ÿ␡';
}
