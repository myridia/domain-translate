#!/bin/bash
cd wordpress/
wp search-replace "https://www.app.local" "https://en.app.local"  --skip-columns=guid 
