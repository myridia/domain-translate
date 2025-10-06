#!/bin/bash
domain='_.app.local'
rm $domain  -Rf
./minica --domains '*.app.local'


cp ./$domain/cert.pem ./$domain/en.app.local.crt
cp ./$domain/cert.pem ./$domain/dk.app.local.crt
cp ./$domain/cert.pem ./$domain/de.app.local.crt
cp ./$domain/cert.pem ./$domain/es.app.local.crt
cp ./$domain/cert.pem ./$domain/th.app.local.crt
cp ./$domain/cert.pem ../etc/nginx/conf.d/certs/
cp ./$domain/key.pem ./$domain/en.app.local.key
cp ./$domain/key.pem ./$domain/dk.app.local.key
cp ./$domain/key.pem ./$domain/de.app.local.key
cp ./$domain/key.pem ./$domain/es.app.local.key
cp ./$domain/key.pem ./$domain/th.app.local.key
cp ./$domain/key.pem ../etc/nginx/conf.d/certs/
chmod 755 ./$domain





