UPDATE j_extensions SET params = '{
    "scoutnet_domain": "mockserver",
    "scoutnet_groupId": "1",
    "scoutnet_memberListApiKey": "abcdefghijklmnopqrstuvwxyz",
    "scoutnet_customListsApiKey": "abcdefghijklmnopqrstuvwxyz",
    "scoutnet_cacheLifeTime": "0"
}'
WHERE name = 'Scoutorg' AND type = 'component'