#! /bin/sh

HOST= '192.168.117.133'
USER= 'dap_edgekit'
PORT= '5432'
DB= 'edgekit_dap'

vacuumdb -h $HOST -U $USER -p $PORT --full --analyze -d $DB