Jika eror “SSL certificate problem: unable to get local issuer certificate”

1. Copy folder _certs ke htdocs
2. Copy Text dibawah dan masukan ke dalam php.ini

[CA Certs]
curl.cainfo="C:/xampp/htdocs/_certs/ca-bundle.crt"
openssl.cafile="C:/xampp/htdocs/_certs/ca-bundle.crt"
[CA Certs]
curl.cainfo="C:/xampp/htdocs/_certs/ca-bundle.crt"
openssl.cafile="C:/xampp/htdocs/_certs/ca-bundle.crt"

3. Restart Apache