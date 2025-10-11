#!/bin/bash
cd wordpress/
wp search-replace "https://en.app.local" "https://app.local"  --skip-columns=guid 
